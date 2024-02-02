<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryMaster;
use App\Models\InventoryTransactions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\LedgerCodeItem;
use App\Models\Setting;
use App\Models\InventoryRequest;
use App\Models\InventoryUser;
use App\Models\Procurement;
use App\Models\CashiersFundTransaction;
use PDF;
use App\Models\Notification;
// use App\Models\Setting;
class InventoryRequestController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function pdf($id=null)
    {
        $setting= Setting::find(1);
        
        $record = InventoryRequest::findOrFail($id);
        $title="Inventory Request ".$record->id;
        $InventoryRequestList=InventoryRequest::where("status","!=",3)
        ->where("parent_id",$record->id)
        ->get();
        $InventoryRequestListTotal=InventoryRequest::where("status","!=",3)
        ->where("parent_id",$record->id)
        ->sum("amount");
         $pdf = PDF::loadView('report.inventory-request',compact('title','record','setting','record','InventoryRequestList','InventoryRequestListTotal'))->setPaper('A4', 'potrait');
       return $pdf->stream("Inventory_Request_Print".time().".pdf");
    }

    public function index()
    {
        //
        // $this->authorize('InventoryMember');
           $InventoryRequests = InventoryRequest::sortable()->where("status","!=",3)
        ->where("parent_id",0)
        ->where("created_by",Auth::id())
        ->orderby("id","asc")->paginate(30);
        return view('admin.inventory-request.index',compact("InventoryRequests")); 
        
        
    }

        public function approvaList()
    {
        //
        $this->authorize('inventoryAdmin');
        $InventoryRequests = InventoryRequest::sortable()->where("status",1)
        ->where("parent_id",0)

        ->orderby("id","asc")->paginate(30);
        return view('admin.inventory-request.approvallist',compact("InventoryRequests"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        //
        $LedgerCodeItemList= LedgerCodeItem::where("status",0)->get(["id","title","code"]);
    $InventoryMastersList = InventoryMaster::where("status","!=",3)
    ->orderby("id","asc")->get();
        if($id==0)
        {
            $record = new InventoryRequest();
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->requested_by= Auth::id();
            $record->request_date=date("Y-m-d H:i:s");
            $record->status=0;
            $record->parent_id=0;
            if($record->save())
            {


                return redirect('/inventory-request/create/'.$record->id)->with('status','Record created.');
            }
        }
        else{


            $parent_id=$id;
            return view('admin.inventory-request.create',compact("parent_id","InventoryMastersList","LedgerCodeItemList"));
        }
    }

public function store(Request $request)
    {
        //

        $quantity=$this->cleanStr(strtoupper($request->input("quantity")));
        $inventory_masters_id=$this->cleanStr(strtoupper($request->input("inventory_masters_id")));

        $field_amount=InventoryTransactions::where("status",1)
        ->where("inventory_masters_id",$inventory_masters_id)
        ->sum("stock");
         $validator = Validator::make($request->all(), [
            
            'inventory_masters_id' => 'required|not_in:0',
            // 'ledger_id' => 'required|not_in:0',
            'quantity' => 'required|not_in:0|numeric|max:'.(int)$field_amount,

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $value =$this->stockValue($inventory_masters_id)/$this->stockCount($inventory_masters_id);
            $record = new InventoryRequest();
            $record->inventory_masters_id= $inventory_masters_id;
            $record->source= $inventory_masters_id;
            // $record->destination= $this->cleanStr(strtoupper($request->input("ledger_id")));
            $record->quantity= $quantity;
            $record->parent_id= $this->cleanStr(strtoupper($request->input("parent_id")));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->requested_by= Auth::id();
            $record->request_date=date("Y-m-d H:i:s");
              $record->unit_price= $value;
            $record->amount= $quantity*$value;
            $record->status=0;
            if($record->save())
            {
             
                return redirect('/inventory-request/'.$record->parent_id)->with('status','Record created.'); 
            }


        }
    }

    public function show($id)
    {
        //
        $InventoryRequest = InventoryRequest::findOrFail($id);
        $InventoryRequestList = InventoryRequest::where("status","!=",3)
        ->where("parent_id",$InventoryRequest->id)->get();

         $Counter = InventoryRequest::where("status","!=",3)
        ->where("parent_id",$InventoryRequest->id)->sum("quantity");

        return view('admin.inventory-request.view',compact("InventoryRequest","InventoryRequestList","Counter"));
    

         
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
          $InventoryMastersList = InventoryMaster::where("status","!=",3)
    ->orderby("id","asc")->get();
        $InventoryRequest = InventoryRequest::findOrFail($id);

        return view('admin.inventory-request.edit',compact("InventoryRequest","InventoryMastersList"));
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
               $quantity=$this->cleanStr(strtoupper($request->input("quantity")));
        $inventory_masters_id=$this->cleanStr(strtoupper($request->input("inventory_masters_id")));

        $field_amount=InventoryTransactions::where("status",1)
        ->where("inventory_masters_id",$inventory_masters_id)
        ->sum("stock");
         $validator = Validator::make($request->all(), [
            
            'inventory_masters_id' => 'required|not_in:0',
            'quantity' => 'required|not_in:0|numeric|max:'.(int)$field_amount,

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $value =$this->stockValue($item->id)/$this->stockCount($item->id);
            $record = InventoryRequest::findOrFail($id);
            $record->inventory_masters_id= $inventory_masters_id;
            $record->unit_price= $value;
            $record->amount= $quantity*$value;
            $record->quantity= $quantity;
            $record->updated_by= Auth::id();
            $record->status=0;
            if($record->save())
            {
             
                return redirect('/inventory-request/'.$record->parent_id)->with('status','Record updated.'); 
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

        $record = InventoryRequest::find($id);
        $record->status=3;
            if($record->save())
            {
    
                 return redirect('/inventory-request/'.$record->parent_id)->with('status','Record updated.');  
            }
    }

    public function requestSubmit($id=null)
    {

        // $this->authorize('InventoryMember');
        $record = InventoryRequest::findOrFail($id);
        $record->status=1;
        if($record->save())
        {
            $results=InventoryRequest::where("status",0)
            ->where("parent_id",$record->id)
            ->get();

            if($results)
            {

                foreach($results as $item)
                {
                    $data = InventoryRequest::find($item->id);
                    $data->status=1;
                    $data->save();
                }
            }
        }

        // $InventoryUsers = InventoryUser::where("user_role",1)
        // ->where("status",0)
        // ->get();

        // if($InventoryUsers)
        // {

        //     foreach($InventoryUsers as $item)
        //     {

        //     $notification= new Notification();
        //     $notification->status=0;
        //     $notification->user=$item->user_id;
        //     $notification->type=2;
        //     $notification->transaction_source="inventory-request";
        //     $notification->transaction_id=$record->id;
        //     $notification->created_by=Auth::id();
        //     $notification->action="inventory-request/".$record->id;
        //     $notification->description="There is an inventory request pending approval.";
        //     $notification->save();
        //     }
        // }


  

                return redirect('/inventory-request/')->with('status','Request submitted for approval.'); 


    }




    public function requestApprove($id=null)
    {
        
        // $this->authorize('inventoryAdmin');
        $record = InventoryRequest::findOrFail($id);
        $record->status=2;
        $record->approved_by= Auth::id();
        $record->approval_date=date("Y-m-d H:i:s");
        if($record->save())
        {
            $results=InventoryRequest::where("status",1)
            ->where("parent_id",$record->id)
            ->get();

            if($results)
            {

                foreach($results as $item)
                {
                    $data = InventoryRequest::find($item->id);
                    $data->status=2;
                    $data->approved_by= $record->approved_by;
                    $data->approval_date=$record->approval_date;
                    $data->save();
                }
            }
        }

        // $notification= new Notification();
        //     $notification->status=0;
        //     $notification->user=$record->created_by;
        //     $notification->type=1;
        //     $notification->transaction_source="inventory-request-collection";
        //     $notification->transaction_id=$record->id;
        //     $notification->action="inventory-request/".$record->id;
        //     $notification->description="Your inventory request has been approved, you need to collect them.";
        //     if($notification->save())
        //     {


        //     Notification::where("status",0)
        // ->where("transaction_id",$record->id)
        // ->where("transaction_source","inventory-request")
        // ->update(["status" =>1,"notes"=>"Inventory manager has appproved request , collection is to take place next.","updated_by"=>Auth::id()]);

     
            // }

     return redirect('/inventory-request/')->with('status','Request submitted for approval.'); ;
 
    }

public function stockValue($id=null)
{


    $In= InventoryTransactions::where("inventory_masters_id",$id)
    ->where("transaction_type",20)
    ->where("status",1)
    ->sum("amount");

    $Out= InventoryTransactions::where("inventory_masters_id",$id)
    ->where("transaction_type",1)
    ->where("status",1)
    ->sum("amount");
    $data=$In-$Out;
if($data)
{
  return $In-$Out;
}
else{

  return 1;
}


}



public function stockCount($id=null)
{


    $In= InventoryTransactions::where("inventory_masters_id",$id)
    // ->where("transaction_type",20)
    ->where("status",1)
    ->sum("stock");


    $data=$In;
if($data)
{
  return $In;
}
else{

  return 1;
}


}


    public function requestCollection($id=null)
    {
        // $this->authorize('InventoryMember');
        $record = InventoryRequest::findOrFail($id);
        if($record->status==2)
        {

            $record->status=4;
            $record->received_by= Auth::id();
            $record->received_date=date("Y-m-d H:i:s");
            if($record->save())
            {
            $results=InventoryRequest::where("status",2)
            ->where("parent_id",$record->id)
            ->get();

            if($results)
            {

                foreach($results as $item)
                {
                    $data = InventoryRequest::find($item->id);
                    $data->status=4;
                    $data->received_by= $record->received_by;
                    $data->received_date=$record->received_date;
                    if($data->save())
                    {

                        $transaction = new InventoryTransactions();
                        $transaction->transaction_type=1;
                        $transaction->procurements_id=$record->parent_id;
                        $transaction->inventory_masters_id=$data->inventory_masters_id;
                        $transaction->stock=$data->quantity*-1;
                        $transaction->created_at=$data->created_at;
                        $transaction->created_by=$data->created_by;
                        $transaction->status=1;
                        $transaction->unit_price= $data->unit_price;
                        $transaction->amount= $data->amount;
                        $transaction->save();
                        // if($transaction->save())
                        // {

                        //     $credit=$this->InventoryMasterDetails($item->source);
                        //     $debit=$this->LedgerCodeItemDetails($item->destination);
                        //     $results = new CashiersFundTransaction();
                        //     $results->cashier_id=$record->source;
                        //     $results->created_by= Auth::id();
                        //     $results->updated_by= Auth::id();
                        //     $results->allocation_type= 5;
                        //     $results->description= "Inventory to Ledgers - ". InventoryMaster::find($data->inventory_masters_id)->title;
                        //     $results->source= $item->source;
                        //     $results->destination= $item->destination;
                        //     $results->amount= $item->amount;
                        //     $results->status=1;
                        //     $results->transaction_id=$record->parent_id;
                        //     $results->nature=2;
                        //     $results->transaction_date=date("Y-m-d");
                        //     $results->source_tag="inventory";
                        //     $results->destination_tag="ledger";
                        //     $results->debit=$debit;
                        //     $results->credit=$credit;
                        //     $results->save();
                        // }
                    }
                }

        // Notification::where("status",0)
        // ->where("transaction_id",$record->id)
        // ->where("transaction_source","inventory-request-collection")
        // ->update(["status" =>1,"notes"=>"Inventory request complete, and item collected.","updated_by"=>Auth::id()]);



            }

            }

        }

        return redirect('/inventory-request/'.$record->id)->with('status','Record updated.'); 
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

}
