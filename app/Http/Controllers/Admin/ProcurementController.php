<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Procurement;
use App\Models\InventoryMaster;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\ProcuremetQuote;
use App\Models\CashiersFunds;
use App\Models\CashierUser;
use App\Models\User;
use App\Models\CashiersFundTransaction;
use App\Models\InventoryTransactions;
use App\Models\LedgerCodeItem;
use App\Models\Notification;


class ProcurementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
    $ProcurementsList = Procurement::where("status","!=",3)->where("parent_id",0)
    ->orderby("id","desc")->get();
    
        $Procurements = Procurement::sortable()->where("status","!=",3)->where("parent_id",0)
        ->orderby("id","desc")->paginate(30);
        return view('admin.procurement.index',compact("Procurements","ProcurementsList"));
    }


    public function pending()
    {
        //

    $ProcurementsList = Procurement::where("status","!=",3)->where("parent_id",0)
    ->orderby("id","asc")->get();
    $Procurements = Procurement::sortable()->where("status",1)->where("parent_id",0)
        ->orderby("id","asc")->paginate(30);
        return view('admin.procurement.pending',compact("Procurements","ProcurementsList"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function existing()
    {
        $data= Procurement::where("created_by",Auth::id())
        ->where("parent_id",0)
        ->where("status","!=",3)
        ->orderby("id","desc")
        ->first();
        if($data)
        {
            $items = Procurement::where("parent_id",$data->id)->count("id");
            if($items>0)
            {
                return false;
            }
            else{

                
                return $data->id;
            }
        }
        else{

            return false;
        }
        

    }
    public function create($id=null)
    {
        //
        // $this->authorize('InventoryMember');
   $child= $this->existing();
   

     $Exclusion = Procurement::where("status",0)
    ->where("parent_id",$id)->get(["inventory_masters_id"])->toArray();      
    $InventoryMastersList = InventoryMaster::where("status","!=",3)
    ->whereNotIn("id",$Exclusion)
    ->orderby("id","asc")->get();
        if($id==0)
        {

            if($child>0)
            {
                return redirect('/procurement/create/'.$child)->with('status','Record created.');
            }
            else{
            $record = new Procurement();
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
            $record->parent_id=0;
            if($record->save())
            {

                $data = Procurement::find($record->id);
                $data->rfp_code="RFQ/".$this->code($record->id)."/".date("m")."/".date("Y");
                $data->save();
                return redirect('/procurement/create/'.$record->id)->with('status','Record created.');
            }


            }


        }
        else{


            $parent_id=$id;
            return view('admin.procurement.create',compact("parent_id","InventoryMastersList"));
        }
   

    
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
            
            'inventory_masters_id' => 'required|not_in:0',
            'quantity' => 'required|not_in:0',
            'unit_price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $amount=$this->cleanStr(strtoupper($request->input("unit_price")))*$this->cleanStr(strtoupper($request->input("quantity")));
            $record = new Procurement();
            $record->unit_price= $this->cleanStr(strtoupper($request->input("unit_price")));
            $record->amount= $amount;
            $record->parent_id= $this->cleanStr(strtoupper($request->input("parent_id")));
            $record->quantity= $this->cleanStr(strtoupper($request->input("quantity")));
            $record->inventory_masters_id= $this->cleanStr(strtoupper($request->input("inventory_masters_id")));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
            if($record->save())
            {
             $this->quantitySum($request->input("parent_id"));
                return redirect('/procurement/'.$record->parent_id)->with('status','Record created.'); 
            }


        }
    }


    public function quantitySum($id=null)
    {

        $sum = Procurement::where("status",0)->where("parent_id",$id)->sum("quantity");
        $record = Procurement::find($id);
        $record->quantity=$sum;
        $record->save();
        
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
        // 
        $Procurement = Procurement::findOrFail($id);

        if($Procurement)
        {
$ProcurementCount = Procurement::where("status","!=",3)->where("parent_id",$Procurement->id)->sum("quantity");

            $ProcurementsList = Procurement::where("status","!=",3)->where("parent_id",$Procurement->id)->get();

            $ProcuremetQuoteList = ProcuremetQuote::where("status","!=",3)
            ->where("procurements_id",$Procurement->id)->get();
            return view('admin.procurement.view',compact("ProcurementCount","Procurement","ProcurementsList","ProcuremetQuoteList"));
        }

         
    }

    public function cashierProcAllocate($id=null)
    {
        $record = Procurement::findOrFail($id);
        if($record->status==2)
        {
                    $Amount=CashiersFundTransaction::where("status",1)
                    ->where("cashier_id",Auth::id())->sum("amount");

                    $ProcurementAmount = Procurement::where("status",2)->where("parent_id",$id)->sum("amount");

            if($Amount>$ProcurementAmount)
            {

                $record->status=11;
                $record->allocation_amount=$ProcurementAmount;
                $record->allocation_date=date("Y-m-d H:i:s");
                $record->allocation_status=1;
                if($record->save())
                {
                $child = Procurement::where("status",2)
                 ->where("parent_id",$record->id)->update(["status" =>$record->status]);

            $notification= new Notification();
            $notification->status=0;
            $notification->user=$record->created_by;
            $notification->transaction_id=$record->id;
            $notification->transaction_source="procurement-collection-funds";
            $notification->type=1;
            $notification->action="procurement-collection-funds";
            $notification->description="You have been Allocated funds, please proceed and collect the amount.";
            $notification->save();

            return redirect('/procurement')->with('success','Request complete');

                }


            }   
            else{

                 return redirect('/procurement')->with('error','Your cashier balance ('.number_format($Amount,2).') is less than procurement amount of '.number_format($ProcurementAmount,2));
            }     

        }
        else{

            return redirect('/procurement')->with('error','Invalid action.');      
        }

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
        
 $Procurement = Procurement::findOrFail($id);
 $InventoryMastersList = InventoryMaster::where("status","!=",3)
    ->orderby("id","asc")->get();
        $parent_id=$id;
            return view('admin.procurement.edit',compact("parent_id","InventoryMastersList","Procurement"));
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
         $validator = Validator::make($request->all(), [
            
            'inventory_masters_id' => 'required|not_in:0',
            'quantity' => 'required|not_in:0',
            'unit_price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
             $amount=$this->cleanStr(strtoupper($request->input("unit_price")))*$this->cleanStr(strtoupper($request->input("quantity")));
            $record = Procurement::findOrFail($id);
            $record->quantity= $this->cleanStr(strtoupper($request->input("quantity")));
            $record->inventory_masters_id= $this->cleanStr(strtoupper($request->input("inventory_masters_id")));
            $record->updated_by= Auth::id();
            $record->unit_price= $this->cleanStr(strtoupper($request->input("unit_price")));
            $record->amount= $amount;
            // $record->status=0;
            if($record->save())
            {
          
                return redirect('/procurement/'.$record->parent_id)->with('status','Record created.'); 
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

        $record = Procurement::find($id);
        $record->status=3;
            if($record->save())
            {
            $this->quantitySum($record->parent_id);
                return redirect('/procurement/'.$record->parent_id)->with('status','Record created.'); 
            }
    }

    public function submission($id)
    {
        //

        $record = Procurement::find($id);
        $record->status=1;
        $record->approved_by=Auth::id();
        $record->approval_date=date("Y-m-d H:i:s");
            if($record->save())
            {
                    $results = Procurement::where("status",0)
                    ->where("parent_id",$record->id)
                    ->get();
                    if($results)
                    {
                        foreach($results as $item)
                        {
                            $data= Procurement::find($item->id);
                            $data->status=$record->status;
                            $data->approved_by=$record->approved_by;
                            $data->approval_date=$record->approval_date;
                            $data->save();

                        }
                    }

        // $CashierUsers = CashierUser::where("user_role",1)
        // ->where("status",0)
        // ->get();

        // if($CashierUsers)
        // {

        //     foreach($CashierUsers as $item)
        //     {

        //     $notification= new Notification();
        //     $notification->status=0;
        //     $notification->user=$item->user_id;
        //     $notification->type=2;
        //     $notification->transaction_id=$record->id;
        //     $notification->transaction_source="procurement";
        //     $notification->action="procurement/".$record->id;
        //     $notification->description="Cashier Manager Procurement Approval.";
        //     $notification->save();
        //     }
        // }

            return redirect('/procurement/')->with('status','Request submitted for approval.'); 
            }
    }


    public function cancelRequest($id)
    {
        //

        $record = Procurement::find($id);
        $record->status=5;
        $record->updated_by=Auth::id();
        $record->cancellation_reason="Request cancled by Cashier Manager";
        $record->approval_date=date("Y-m-d H:i:s");
        if($record->save())
            {
                    $results = Procurement::where("status",1)
                    ->where("parent_id",$record->id)
                    ->get();
                    if($results)
                    {
                        foreach($results as $item)
                        {
                            $data= Procurement::find($item->id);
                            $data->status=$record->status;
                            $data->approved_by=$record->approved_by;
                            $data->approval_date=$record->approval_date;
                            $data->save();

                        }
                    }

        //     Notification::where("status",0)
        // ->where("transaction_id",$record->id)
        // ->where("transaction_source","procurement")
        // ->update(["status" =>1,"notes"=>"Cancellation By Cashier Manager","updated_by"=>Auth::id()]);        

        //     $notification= new Notification();
        //     $notification->status=0;
        //     $notification->user=$record->created_by;
        //     $notification->type=1;
        //     $notification->transaction_id=$record->id;
        //     $notification->transaction_source="procurement";
        //     $notification->action="procurement/".$record->id;
        //     $notification->description="Cashier Manager has canceled Procurement request .";
 return redirect('/procurement/')
 ->with('status','Procurement request canceled.');      

            }
    }


    public function cancelRequestCashier($id)
    {
        //

        $record = Procurement::find($id);
        $record->status=5;
        $record->updated_by=Auth::id();
        $record->cancellation_reason="Request cancled by Cashier ";
        $record->approval_date=date("Y-m-d H:i:s");
            if($record->save())
            {
                    $results = Procurement::where("status",1)
                    ->where("parent_id",$record->id)
                    ->get();
                    if($results)
                    {
                        foreach($results as $item)
                        {
                            $data= Procurement::find($item->id);
                            $data->status=$record->status;
                            $data->approved_by=$record->approved_by;
                            $data->approval_date=$record->approval_date;
                            $data->save();

                        }
                    }
            $notification= new Notification();
            $notification->status=0;
            $notification->user=$record->created_by;
            $notification->type=1;
            $notification->transaction_id=$record->id;
            $notification->transaction_source="procurement-cancel-cashier";
            $notification->action="procurement/".$record->id;
            $notification->description="Your request has been canceled please start again";
            if($notification->save())
            {
                    return redirect('/procurement')->with('error','Procurement request canceled.'); 
            }

      
            }
    }    





    public function complete($id)
    {
        //

        $record = Procurement::find($id);
        $record->status=12;
        $record->approved_by=Auth::id();
        $record->approval_date=date("Y-m-d H:i:s");
            if($record->save())
            {
                    $results = Procurement::where("status",1)
                    ->where("parent_id",$record->id)
                    ->get();
                    if($results)
                    {
                        foreach($results as $item)
                        {
                            $data= Procurement::find($item->id);
                            $data->status=$record->status;
                            $data->approved_by=$record->approved_by;
                            $data->approval_date=$record->approval_date;
                            $data->save();

                        }
                    }

        // $CashierUsers = CashierUser::where("status",0)
        // ->get();

        // if($CashierUsers)
        // {

        //     foreach($CashierUsers as $item)
        //     {

        //     $notification= new Notification();
        //     $notification->status=0;
        //     $notification->user=$item->user_id;
        //     $notification->created_by=Auth::id();
        //     $notification->type=2;
        //      $notification->transaction_id=$record->id;
        //     $notification->transaction_source="procurement";
        //     $notification->action="procurement/".$record->id;
        //     $notification->description="Cashier Users to allocate give funds for procurement purchase.";
        //     $notification->save();
        //     }
        // }


        // Notification::where("status",0)
        // ->where("transaction_id",$record->id)
        // ->where("transaction_source","procurement")
        // ->update(["status" =>1,"notes"=>"Approval By Cashier Manager Complete","updated_by"=>Auth::id()]);


                return redirect('/procurement/')->with('status','Record created.'); 
            }
    }




    public function searchProcess(Request $request)
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

         $value = strtoupper($this->cleanStr($request->input("value")));
         $results = Procurement::find($value);


        return redirect('/procurement/'.$results->id)->with('status','Record found.'); 


        }

   
    } 


    public function code($id)
    {
        $no_of_digit = 4;
        $number = $id;
        $length = strlen((string)$number);
            for($i = $length;$i<$no_of_digit;$i++)
            {
                $number = '0'.$number;
            }
            return $number;
    }

    public function pdf($id=null)
    {
        $record = Procurement::findOrFail($id);
        $ProcurementsList = Procurement::where("status","!=",3)->where("parent_id",$record->id)->get();
        $ProcuremenTotal = Procurement::where("status","!=",3)
        ->where("parent_id",$record->id)->sum("amount");
        $setting= Setting::find(1);
        $title="RQF";
        // $CashierFunds=CashierFunds::find($record->cashier_funds_id);
        $CashierFunds=[];
        $pdf = PDF::loadView('report.rfq',compact('record','setting','ProcurementsList','CashierFunds','ProcuremenTotal','title'))->setPaper('A4', 'potrait');

       return $pdf->stream("RFQ_Print".time().".pdf");
    }


    public function procurementRequest()
    {


            $InventoryMastersList = InventoryMaster::where("status","!=",3)
    ->orderby("title","asc")->get();
        return view("admin.procurement.internalpay",compact("InventoryMastersList"));

    }


    public function cashierManagerList()
    {

        $CashierGroup = CashierUser::where("status",0)
        ->where("user_id",Auth::id())
        ->first();

        if($CashierGroup)
        {
         $UserGroup =User::findOrFail(Auth::id())->group;

           if($CashierGroup->user_role==1)
            {
                // manager
     $ProcurementsList = Procurement::where("status",1)->where("parent_id",0)
    ->orderby("id","asc")->get();
    
        $Procurements = Procurement::sortable()->where("status",1)->where("parent_id",0)
        ->orderby("id","asc")->paginate(30);
        return view('admin.procurement.managerlist',compact("Procurements","ProcurementsList"));                  

            }


        }
        else{

        return redirect()->back()->with('error','Access Restricted'); 
        }




    }





        public function cashierList()
    {

        $CashierGroup = CashierUser::where("status",0)
        ->where("user_id",Auth::id())
        ->first();

        if($CashierGroup)
        {
         $UserGroup =User::findOrFail(Auth::id())->group;

          $ProcurementsList = Procurement::where("status",2)->where("parent_id",0)
    ->orderby("id","asc")->get();
    
        $Procurements = Procurement::sortable()->where("status",2)->where("parent_id",0)
        ->orderby("id","asc")->paginate(30);
        return view('admin.procurement.cashierlist',compact("Procurements","ProcurementsList")); 


        }
        else{

        return redirect()->back()->with('error','Access Restricted'); 
        }




    }

    public function internalPay($id=null)
    {
        
        $ProcurementsList = Procurement::where("status",12)->where("parent_id",$id)->get();

        $ProcurementAmount = Procurement::where("status",12)->where("parent_id",$id)->sum("amount");
        $Procurement = Procurement::findOrFail($id);
        $Amount=0;
        // $Amount=CashiersFundTransaction::where("status",1)
        // ->where("cashier_id",Auth::id())->sum("amount");
        $transaction_id=$id;
        return view("admin.procurement.internalpay",compact("ProcurementsList","Procurement","Amount","transaction_id","ProcurementAmount"));
    }

    public function internalPayProccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'description' => 'required|not_in:0',
            'document'=>'mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $transaction_id=$request->input("transaction_id");
            $ProcurementAmount = Procurement::where("status",2)
            ->where("parent_id",$transaction_id)
            ->sum("amount");
            $Amount=700000000;
              if($Amount>$ProcurementAmount)
              {
      if ($request->hasFile('document')) {

        $image = $request->file('document');
        $filename = time()."_".$image->getClientOriginalName();
        $filename=preg_replace('/\s+/', '', $filename);

        $request->document->move(public_path('uploads'),$filename);

        }
        else{

        $filename=0;
        }


            $purchase =Procurement::find($request->transaction_id);
            $purchase->status=4;
            $purchase->file=$filename;
            $purchase->description=$this->cleanStr($request->input("description"));
            if($purchase->save())
             {
                $results=Procurement::where("status",12)
                    ->where("parent_id",$purchase->id)
                    ->get();

                 if($results)
                 {


                    foreach($results as $item)
                    {

                        $data = new InventoryTransactions();
                        $data->procurements_id=$item->parent_id;
                        $data->inventory_masters_id=$item->inventory_masters_id;
                        $data->stock=$item->quantity;
                        $data->status=1;
                        $data->transaction_type=20;
                        $data->unit_price=$item->unit_price;
                        $data->amount=$item->amount;
                        $data->approved_by=Auth::id();
                        $data->created_by=Auth::id();
                        $data->updated_by=Auth::id();
                        $data->approval_date=date("Y-m-d H:i:s");
                        $data->save();
                       

                    }


                

                 }   
             }   
                
  return redirect('/procurement/'.$purchase->id)->with('status','Record updated.'); 
              }
              else{

                 return redirect()->back()->with('error','Your cashier balance of '.number_format($Amount).' if below the procurement amount of '.number_format($ProcurementAmount).' .'); 
              }




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

 public  function InventoryMasterDetails($id=null)
{

  $record=InventoryMaster::find($id);

  if($record)
  {

    return $this->LedgerCodeItemDetails($record->ledger_code_id);
  }
  else{

    return 0;
  }
}



    public function procurementCollectionFunds()
    {

    $Procurements = Procurement::sortable()->where("status",11)
    ->where("created_by",Auth::id())
    ->where("parent_id",0)
        ->orderby("id","asc")->paginate(30);
        return view('admin.procurement.collectionfunds',compact("Procurements")); 
    }


    public function procurementCollectionFund($id=null)
    {

        $record = Procurement::findOrFail($id);
        if($record->status==11)
        {


                $record->status=12;
                $record->collection_by=Auth::id();
                $record->collection_date=date("Y-m-d H:i:s");
                $record->allocation_status=2;
                if($record->save())
                {
                $child = Procurement::where("status",11)
                 ->where("parent_id",$record->id)->update(["status" =>$record->status]);

             }


              Notification::where("status",0)
        ->where("transaction_id",$record->id)
        ->where("transaction_source","procurement-collection-funds")
        ->update(["status" =>1,"notes"=>"Funds collected from cashier","updated_by"=>Auth::id()]);

             return redirect('/procurement')->with('success','Request complete');

        }
        else{

             return redirect("/procurement")->with('error','Invalid action');
        }
    }
    
    

}
