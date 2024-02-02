<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;
use App\Models\Menu;
use App\Models\SetupConfig;
use App\Models\FeeStructure;
use App\Models\FeePayment;
use App\Models\StudentClass;
use App\Models\MpesaToken;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Http;
class FeePaymentController extends BaseController
{


    public $access_token;
    public $consumer_key;
    public $secret_key;
    public $access_token_url;
    public $BusinessShortCode;
    public $Passkey;
    public $initiate_url;
    public $SafPassword;
    public $Timestamp;



public function __construct()
{


    // $this->access_token_url="https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    // $this->consumer_key="DP6UgZmkcTawy7B6osDXCJELpS9wKLLL";
    // $this->secret_key="ukxk8YKszIn6sP5X";
    // $this->BusinessShortCode = '174379';
    // $this->Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';  
    // $this->initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    // $this->Timestamp = date('YmdHis'); 
    // $this->SafPassword= base64_encode($this->BusinessShortCode.$this->Passkey.$this->Timestamp);


    

    //  $mpesa= MpesaToken::where("status",0)->get()->last();
    //  if(!$mpesa)
    //  {
    //     $MpesaResponse = Http::withBasicAuth($this->consumer_key,$this->secret_key)
    //          ->get($this->access_token_url);

    //     $MpesaToken = new MpesaToken;
    //     $MpesaToken->acccess_token = $MpesaResponse["access_token"];
    //     $MpesaToken->status=0;
    //     $MpesaToken->token_time=Carbon::now()
    //     ->addSeconds($MpesaResponse["expires_in"])->format('Y-m-d H:i:s');;
    //     $MpesaToken->save();

    //     $this->access_token = $MpesaToken->acccess_token;
    //  }
    // else if(strtotime($mpesa->token_time) > strtotime(date("Y-m-d H:i:s")))
    // {
    //           $this->access_token=$mpesa->acccess_token;
    // }
    // else{

    //     $MpesaResponse = Http::withBasicAuth($this->consumer_key,$this->secret_key)
    //          ->get($this->access_token_url);

    //     $MpesaToken = new MpesaToken;
    //     $MpesaToken->acccess_token = $MpesaResponse["access_token"];
    //     $MpesaToken->status=0;
    //     $MpesaToken->token_time=Carbon::now()
    //     ->addSeconds($MpesaResponse["expires_in"])->format('Y-m-d H:i:s');;
    //     $MpesaToken->save();

    //     $this->access_token = $MpesaToken->acccess_token;

    // }



}


    public function index()
    {
        //
        
        
        $StudentLists = User::where("status","!=",3)->where("user_role",3)
        ->orderby("id","asc")->get(["id","name","admission_no"]);
        return view('admin.fee-payment.index',compact("StudentLists"));
    }


    public function feepaymentProc(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'value' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $record=$request->input("value");
            return redirect('/fee-payment-choice/'.$record)->with('status','Proceed.'); 
        }
    }

    public function choice($id=null)
    {
        $student= User::findOrFail($id);
        $Exclusion=StudentClass::where("status",0)
        ->where("student_id",$id)->get(["class_id"])->toArray();
        $FeeStructures=FeeStructure::where("status",1)->where("parent_id",0)
        // ->where("program_id",$student->program_id)
        ->whereIn("class_program",$Exclusion)
        ->get(["id","academic_year","academic_stage_id","class_program"]);
        $StudentLists = User::where("status",0)->where("user_role",3)
        ->orderby("id","asc")->get(["id","name","admission_no"]);
        return view("admin.fee-payment.choice",compact("FeeStructures","StudentLists","id","student"));

    }


    public function opBalance($FeeID=null,$StudentID=null)
    {

        $Paid =FeePayment::where("student_id",$StudentID)
        ->where("fee_structure_id",$FeeID)
        ->where("status",1)->sum("amount");
        $Outstanding= FeeStructure::where("status",1)
        ->where("parent_id",$FeeID)->sum("amount");

        return $Outstanding-$Paid;
    }


    public function create($FeeID=null,$userID=null)
    {

        $FeeStructures=FeeStructure::where("parent_id",$FeeID)
        ->where("status","!=",3)
        ->get();
        $PaymentModes=SetupConfig::where("status",0)->where("setup_id",13)
        ->get();

        $FeeStructuresAmount=FeeStructure::where("parent_id",$FeeID)
        ->where("status","!=",3)
        ->sum("amount");
        $FeeStructuresAmountPaid=FeePayment::where("student_id",$userID)
        ->where("fee_structure_id",$FeeID)
        ->where("status",1)->sum("amount");
        $FeePaymentItems=FeePayment::where("status",0)
        ->get();
        $Student=User::findOrFail($userID);
        $fee_structure_id=$FeeID;
        return view("admin.fee-payment.create",compact("FeeStructures","Student","fee_structure_id","FeeStructuresAmount","FeeStructuresAmountPaid","FeePaymentItems","PaymentModes"));
    }


    public function oldcreate($FeeID=null,$userID=null)
    {

        $FeeStructures=FeeStructure::where("parent_id",$FeeID)
        ->where("status","!=",3)
        ->get();
        $PaymentModes=SetupConfig::where("status",0)->where("setup_id",13)
        ->get();

        $FeeStructuresAmount=FeeStructure::where("parent_id",$FeeID)
        ->where("status","!=",3)
        ->sum("amount");
        $FeeStructuresAmountPaid=0;
        $FeePaymentItems=FeePayment::where("status",0)
        ->get();
        $Student=User::findOrFail($userID);
        $fee_structure_id=$FeeID;
        return view("admin.fee-payment.create",compact("FeeStructures","Student","fee_structure_id","FeeStructuresAmount","FeeStructuresAmountPaid","FeePaymentItems"));
    }


        public function destroy($id)
    {
        //

        $record= FeePayment::findOrFail($id);
        $record->status=3;
        if($record->save())
        {
            return redirect()->back()->with('error','item has been removed succesfully.');
        }
    }

    public function edit($id)
    {
        $FeePayment = FeePayment::findOrFail($id);

        // return $FeePayment;
        if($FeePayment->status==0)
        {

        $FeeID=$FeePayment->fee_structure_id;   
        $userID=$FeePayment->student_id; 
        $FeeStructures=FeeStructure::where("parent_id",$FeeID)
        ->where("status","!=",3)
        ->get();
        $PaymentModes=SetupConfig::where("status",0)->where("setup_id",13)
        ->get();

        $FeeStructuresAmount=FeeStructure::where("parent_id",$FeeID)
        ->where("status","!=",3)
        ->sum("amount");
               $FeeStructuresAmountPaid=FeePayment::where("student_id",$userID)
        ->where("fee_structure_id",$FeeID)
        ->where("status",1)->sum("amount");
        $FeePaymentItems=FeePayment::where("status",0)
        ->get();
        $Student=User::findOrFail($userID);
        $fee_structure_id=$FeeID;
        return view("admin.fee-payment.edit",compact("FeeStructures","Student","fee_structure_id","FeeStructuresAmount","FeeStructuresAmountPaid","FeePaymentItems","PaymentModes","FeePayment"));
        }
        else{

            return redirect('/fee-payment-history/'.$FeePayment->student_id)
                ->with('status','Record created successfully.'); 
        }


    }
    public function code($id)
    {
        $no_of_digit = 6;
        $number = $id;
        $length = strlen((string)$number);
            for($i = $length;$i<$no_of_digit;$i++)
            {
                $number = '0'.$number;
            }
            return $number;
    }

    public function feeHistory($id=null)
    {



        $FeePayments =FeePayment::sortable()->where("student_id",$id)->where("status",1)
        ->orderby("id","desc")
        ->get();
        $Student=User::findOrFail($id);
        $PaidAmount=FeePayment::where("student_id",$id)->where("status",1)->sum("amount");


        $PaymentsList= StudentClass::where("status","!=",3)
        ->where("student_id",$id)
        ->get(["year","class_id"])->toArray();
        $BalanceAmount=0;

       for($x=0;$x<count($PaymentsList);$x++)
        {
            $class_id=$PaymentsList[$x]["class_id"];
            $academic_year=$PaymentsList[$x]["year"];
            $results = FeeStructure::where("status",1)
            ->where("class_program",$class_id)
            ->where("academic_year",$academic_year)
            ->where("parent_id",0)
            ->get(["id"]);

            if($results)
            {

                foreach($results as $item)
                {
                    $BalanceAmount+=FeeStructure::where("status",1)
                    ->where("parent_id",$item->id)
                    ->sum("amount");
                }
            }

        }
       

        return view("admin.fee-payment.history",compact("BalanceAmount","FeePayments","Student","PaidAmount"));
    }

    public function globalBalance($id=null)
    {

        $PaidAmount=FeePayment::where("student_id",$id)->where("status",1)->sum("amount");


        $PaymentsList= StudentClass::where("status","!=",3)
        ->where("student_id",$id)
        ->get(["year","class_id"])->toArray();
        $BalanceAmount=0;

       for($x=0;$x<count($PaymentsList);$x++)
        {
            $class_id=$PaymentsList[$x]["class_id"];
            $academic_year=$PaymentsList[$x]["year"];
            $results = FeeStructure::where("status",1)
            ->where("class_program",$class_id)
            ->where("academic_year",$academic_year)
            ->where("parent_id",0)
            ->get(["id"]);

            if($results)
            {

                foreach($results as $item)
                {
                    $BalanceAmount+=FeeStructure::where("status",1)
                    ->where("parent_id",$item->id)
                    ->sum("amount");
                }
            }

        }


        return $BalanceAmount-$PaidAmount;
    }

    public function pdf($id=null)
    {

        $setting= Setting::find(1);
        $FeePayment = FeePayment::findOrFail($id);
        $AmountWords=$this->numberToWord($FeePayment->amount);
        $title="Fee Payment";
        $Outstanding=$this->globalBalance($FeePayment->student_id);
        $pdf = PDF::loadView('report.fee-payment',compact('setting',"FeePayment","AmountWords","title","Outstanding"))->setPaper('A4', 'potrait');
       return $pdf->stream("Fee_Payment".time().".pdf");
    }

public function numberToWord($num = '')
    {
        $num    = ( string ) ( ( int ) $num );
        
        if( ( int ) ( $num ) && ctype_digit( $num ) )
        {
            $words  = array( );
             
            $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
             
            $list1  = array('','one','two','three','four','five','six','seven',
                'eight','nine','ten','eleven','twelve','thirteen','fourteen',
                'fifteen','sixteen','seventeen','eighteen','nineteen');
             
            $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
                'seventy','eighty','ninety','hundred');
             
            $list3  = array('','thousand','million','billion','trillion',
                'quadrillion','quintillion','sextillion','septillion',
                'octillion','nonillion','decillion','undecillion',
                'duodecillion','tredecillion','quattuordecillion',
                'quindecillion','sexdecillion','septendecillion',
                'octodecillion','novemdecillion','vigintillion');
             
            $num_length = strlen( $num );
            $levels = ( int ) ( ( $num_length + 2 ) / 3 );
            $max_length = $levels * 3;
            $num    = substr( '00'.$num , -$max_length );
            $num_levels = str_split( $num , 3 );
             
            foreach( $num_levels as $num_part )
            {
                $levels--;
                $hundreds   = ( int ) ( $num_part / 100 );
                $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
                $tens       = ( int ) ( $num_part % 100 );
                $singles    = '';
                 
                if( $tens < 20 ) { $tens = ( $tens ? ' ' . $list1[$tens] . ' ' : '' ); } else { $tens = ( int ) ( $tens / 10 ); $tens = ' ' . $list2[$tens] . ' '; $singles = ( int ) ( $num_part % 10 ); $singles = ' ' . $list1[$singles] . ' '; } $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' ); } $commas = count( $words ); if( $commas > 1 )
            {
                $commas = $commas - 1;
            }
             
            $words  = implode( ', ' , $words );
             
            $words  = trim( str_replace( ' ,' , ',' , ucwords( $words ) )  , ', ' );
            if( $commas )
            {
                $words  = str_replace( ',' , ' and' , $words );
            }
             
            return $words;
        }
        else if( ! ( ( int ) $num ) )
        {
            return 'Zero';
        }
        return '';
    }



    public function store(Request $request)
    {

        // return $request->all();

        $field_amount=$this->opBalance($request->fee_structure_id,$request->student_id);
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|max:'.(int)$field_amount,
            'payment_mode_id' => 'required|not_in:0',
            'gl_date' => 'required',
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $FeeStructure = FeeStructure::findOrFail($request->input("fee_structure_id"));
            $record = new FeePayment();
            $record->created_by= Auth::id();
            $record->status=0;
            $record->parent_id=0;
            $record->updated_by= Auth::id();
            $record->fee_structure_id=$request->input("fee_structure_id");
            $record->description=$request->input("description");
            $record->gl_date=$request->input("gl_date");
            $record->payment_mode_id=$request->input("payment_mode_id");
            $record->phone_number=$request->input("phone_number");
            $record->student_id=$request->input("student_id");
            $record->fee_structure_item_id=$request->input("fee_structure_item_id");
            $record->amount=$request->input("amount");
            $record->class_id=$FeeStructure->class_program;
            $record->term_id=$FeeStructure->academic_stage_id;
            $record->academic_year=$FeeStructure->academic_year;
            $record->program_id=$FeeStructure->program_id;

            if($record->save())
            {
                    $data=FeePayment::find($record->id);
                    $data->ref=$this->code($record->id);
                    if($data->save())
                    {
                return redirect('/fee-payment/'.$record->id.'/edit')
                ->with('status','Record created successfully.'); 
                    }

            }


        }

        
    }


    public function complete($id=null)
    {
        $record = FeePayment::findOrFail($id);
        if($record->status==0)
        {
            $record->status=1;
            if($record->save())
            {
                  return redirect('/fee-payment/'.$record->id.'/edit')
                ->with('status','Record completed successfully.');
            }
        }
        else{

            return redirect('/fee-payment/'.$record->id.'/edit')
                ->with('status','Record created successfully.');
        }
    }


    public function update(Request $request,$id)
    {
        $Payment =FeePayment::findOrFail($id);
        $field_amount=$this->opBalance($Payment->fee_structure_id,$Payment->student_id);
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|max:'.(int)$field_amount,
            'payment_mode_id' => 'required|not_in:0',
            'gl_date' => 'required',
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $record = FeePayment::findOrFail($id);
            $record->status=0;
            $record->parent_id=0;
            $record->description=$request->input("description");
            $record->phone_number=$request->input("phone_number");
            $record->updated_by= Auth::id();
            $record->gl_date=$request->input("gl_date");
            $record->payment_mode_id=$request->input("payment_mode_id");
            $record->amount=$request->input("amount");
            if($record->save())
            {

                return redirect('/fee-payment/'.$record->id.'/edit')
                ->with('status','Record updated successfully.'); 
            }


        }

        
    }


    public function mpesa($id=null)
    {


         $FeePayment= FeePayment::findOrFail($id);
    $PartyA = $FeePayment->phone_number; // This is your phone number, 
    $AccountReference = "Fee Payment ".$FeePayment->ref;
    $TransactionDesc = "Fee Payment ".$FeePayment->ref;
    $Amount = $FeePayment->amount;
    $CallBackURL="https://primary-school.spark-collector.net/api/payment-process";

    $response = Http::withToken( $this->access_token)
    ->post($this->initiate_url,[
    'BusinessShortCode' => $this->BusinessShortCode,
    'Password' => $this->SafPassword,
    'Timestamp' => $this->Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => intval($Amount),
    'PartyA' => $PartyA,
    'PartyB' => $this->BusinessShortCode,
    'PhoneNumber' => $PartyA,
    'CallBackURL' => $CallBackURL,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc,

    ]);

    $record=$response["CheckoutRequestID"];
    if($record)
    {
        $FeePayment->CheckoutRequestID=$response["CheckoutRequestID"];
        $FeePayment->save();
    }

    return $response;




    }


        public function paymentProcess(Request $request)
{

// return $request->all();
    $Body = $request->all();
    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");

$txt = json_encode($Body);
fwrite($myfile, $txt);
fclose($myfile);
    $Result= $Body["Body"]["stkCallback"];
    $ResultCode=$Result["ResultCode"]; 
    $CheckoutRequestID=$Result["CheckoutRequestID"]; 
    $MpesaTransaction = FeePayment::where("CheckoutRequestID","$CheckoutRequestID")->first();
 
      if($ResultCode==0)
        {

        $MetaData = $Result["CallbackMetadata"]["Item"];
        $MpesaCode= $MetaData[1]["Value"];
        $record= FeePayment::find($MpesaTransaction->id);
        $record->mpesa_code=$MpesaCode;
        $record->mpesa_status=$ResultCode;
        $record->payment_mode_id=43;
        $record->status=1;
        $record->description="Fee Payment ".$MpesaCode;
        $record->save();


        }
        else{

        //update status

        $record= FeePayment::find($MpesaTransaction->id);
        $record->mpesa_status=$ResultCode;
        $record->description=$record->description." ==error occured".$ResultCode;
        $record->save();


    }
}



}
