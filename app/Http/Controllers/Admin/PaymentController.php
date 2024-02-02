<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Payment;
use App\Models\AccountTransaction;
use App\Models\CashierUser;
use App\Models\CashiersFunds;
use App\Models\User;
use App\Models\Entity;
use App\Models\InventoryTransactions;
use App\Models\Procurement;
use App\Models\LedgerCodeItem;

use App\Models\Notification;
class PaymentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        //
        // $this->authorize('cashierMember');
        $PaymentsList = Payment::sortable()
        ->where("created_by",Auth::id())
        // ->orderby("cashier_id","asc")
        ->paginate(30);

        return view("admin.payment.index",compact("PaymentsList"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    // $this->authorize('cashierMember');
        $LedgerCodeItemList= LedgerCodeItem::where("status",0)->get(["id","title","code"]);
        $Suppliers = Entity::where("status",0)->where("entity_type",2)->get();
        return view('admin.payment.create',compact("LedgerCodeItemList","Suppliers"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            
            'source' => 'required|not_in:0',
            'transaction_date' => 'required',
            'destination' => 'required|not_in:0|different:source',
            'amount' => 'required|numeric|between:0,9999999999.99',
            'document'=>'mimes:jpeg,png,jpg,gif,pdf,xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{


        if ($request->hasFile('document')) {

        $image = $request->file('document');
        $filename = time()."_".$image->getClientOriginalName();
        $filename=preg_replace('/\s+/', '', $filename);

        $request->document->move(public_path('uploads'),$filename);

        }
        else{

        $filename=0;
        }



            $record = new Payment();
            $record->description=$this->cleanStr($request->input("description"));
            // $record->ledger_code_id=$this->cleanStr($request->input("ledger_code_id"));
            $record->supplier_id=$this->cleanStr($request->input("supplier_id"));
            $record->transaction_date=$this->cleanStr($request->input("transaction_date"));
            $record->amount=$this->cleanStr($request->input("amount"));
            $record->file=$filename;
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
            $record->source_tag="ledger";
            $record->destination_tag="ledger";
            $record->source=$this->cleanStr($request->input("source"));
            $record->destination=$this->cleanStr($request->input("destination"));
            $record->allocation_type=$this->allocationData($request->destination);
            if($record->save())
            {

                  return redirect('/payment/'.$record->id."/edit")->with('status','Record created.'); 
            }



        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function edit($id)
    {
        //
        // $this->authorize('cashierMember');
        $Payment = Payment::findOrFail($id);
        if($Payment->status==0)
        {

        $LedgerCodeItemList= LedgerCodeItem::where("status",0)->get(["id","title","code"]);
        $Suppliers = Entity::where("status",0)->where("entity_type",2)->get();
        return view('admin.payment.edit',compact("LedgerCodeItemList","Suppliers","Payment"));
        }
        else{

            return redirect('/payment/')->with('error','Action invalid.'); 
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
         $validator = Validator::make($request->all(), [
            
            'transaction_date' => 'required',
            'source' => 'required|not_in:0',
            'destination' => 'required|not_in:0|different:source',
            'amount' => 'required|numeric|between:0,9999999999.99',
            'document'=>'mimes:jpeg,png,jpg,gif,pdf,xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{


        if ($request->hasFile('document')) {

        $image = $request->file('document');
        $filename = time()."_".$image->getClientOriginalName();
        $filename=preg_replace('/\s+/', '', $filename);

        $request->document->move(public_path('uploads'),$filename);

        }
        else{

        $filename=0;
        }



            $record = Payment::findOrFail($id);
            $record->description=$this->cleanStr($request->input("description"));
            // $record->ledger_code_id=$this->cleanStr($request->input("ledger_code_id"));
            $record->supplier_id=$this->cleanStr($request->input("supplier_id"));
            $record->amount=$this->cleanStr($request->input("amount"));
            $record->file=$filename;
             $record->transaction_date=$this->cleanStr($request->input("transaction_date"));
            // $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            // $record->status=0;
            $record->source_tag="ledger";
            $record->destination_tag="ledger";
            $record->source=$this->cleanStr($request->input("source"));
            $record->destination=$this->cleanStr($request->input("destination"));
            $record->allocation_type=$this->allocationData($request->destination);
            if($record->save())
            {

                  return redirect('/payment/'.$record->id."/edit")->with('status','Record updated.'); 
            }



        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


     public function submission($id=null)
    {

       // $this->authorize('cashierMember');
        $record = Payment::findOrFail($id);
        if($record->status==2)
        {
           return redirect('/payment/')->with('error','Transaction already completed.');  
        }
        
        

        $record->status=2;
        $record->approval_date=date("Y-m-d H:i:s");
        $record->approved_by=Auth::id();
        if($record->save())
        {
           
                    $source=$record->source;
                    $destination=$record->destination;  
                    $credit=$this->LedgerCodeItemDetails($record->source);
                    $debit=$this->LedgerCodeItemDetails($record->destination);     
                    $transaction = new AccountTransaction();
                    $transaction->cashier_id=Auth::id();
                    $transaction->created_by= Auth::id();
                    $transaction->updated_by= Auth::id();
                    $transaction->allocation_type= 6;
                    $transaction->description= $record->description;
                    $transaction->source= $source;
                    $transaction->destination= $destination;
                    $transaction->amount= $record->amount;
                    $transaction->status=1;
                    $transaction->transaction_date=$record->transaction_date;
                     $transaction->created_at=$record->transaction_date;
                    $transaction->transaction_id=$record->id;
                    $transaction->nature=2;
                    $transaction->source_tag="ledger";
                    $transaction->destination_tag="ledger";
                    $transaction->debit=$debit;
                    $transaction->credit=$credit;
                    $transaction->save();

                
                   


            return redirect('/payment/')->with('status','Payment approved.'); 
        }

        



    }




public function LedgerCodeItemDetails($id=null)
{

  $record=LedgerCodeItem::find($id);

  if($record)
  {

    return $record->code;
  }
  else{

    return 0;
  }
}


public function allocationData($id=null)
{
return 1;
}
public function cashierDetails($id=null)
{

  $record=CashierUser::find($id);

  if($record)
  {

    return $this->LedgerCodeItemDetails($record->ledger_id);
  }
  else{

    return 0;
  }
} 


}
