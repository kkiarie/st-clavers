<?php

namespace App\Http\Controllers;

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

class FeedController extends Controller
{
    //


    public function schoolProgram()
    {

        return Program::where("status",0)->get(["id","name","description"]);
    }


//     public function paymentProcess(Request $request)
// {

// // return $request->all();
//     $Body = $request->all();
//     $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");

// $txt = json_encode($Body);
// fwrite($myfile, $txt);
// fclose($myfile);
//     $Result= $Body["Body"]["stkCallback"];
//     $ResultCode=$Result["ResultCode"]; 
//     $CheckoutRequestID=$Result["CheckoutRequestID"]; 
//     $MpesaTransaction = FeePayment::where("CheckoutRequestID","$CheckoutRequestID")->first();
 
//       if($ResultCode==0)
//         {

//         $MetaData = $Result["CallbackMetadata"]["Item"];
//         $MpesaCode= $MetaData[1]["Value"];
//         $record= FeePayment::find($MpesaTransaction->id);
//         $record->mpesa_code=$MpesaCode;
//         $record->mpesa_status=$ResultCode;
//         $record->payment_mode_id=43;
//         $record->status=1;
//         $record->description="Fee Payment ".$MpesaCode;
//         $record->save();


//         }
//         else{

//         //update status

//         $record= FeePayment::find($MpesaTransaction->id);
//         $record->mpesa_status=$ResultCode;
//         $record->description=$record->description." ==error occured".$ResultCode;
//         $record->save();


//     }
// }

}
