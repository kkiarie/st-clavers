<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryMaster;
use App\Models\InventoryTransactions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\LedgerCodeItem;

class InventoryMasterController extends BaseController
{
   public function index()
    {
        //
    $InventoryMastersList = InventoryMaster::where("status","!=",3)
    ->orderby("title","asc")->get();
    $InventoryMasters = InventoryMaster::sortable()->where("status","!=",3)
        ->orderby("id","asc")->paginate(30);
        return view('admin.inventory.index',compact("InventoryMasters","InventoryMastersList"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $LedgerCodeItemList= LedgerCodeItem::where("status",0)->get(["id","title","code"]);
         return view('admin.inventory.create',compact("LedgerCodeItemList"));
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
            'title' => 'required',
            'reorder_level' => 'required|not_in:0',
            'ledger_code_id' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $record = new InventoryMaster();
            $record->title= $this->cleanStr(strtoupper($request->input("title")));
            $record->reorder_level= $this->cleanStr(strtoupper($request->input("reorder_level")));
 
$record->ledger_code_id= $this->cleanStr(strtoupper($request->input("ledger_code_id")));
            $record->stock_level= 0;
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
            if($record->save())
            {
                $data = InventoryMaster::find($record->id);
                $data->inventory_code="INV/".$this->code($record->id)."/".date("m")."/".date("Y");
                $data->save();
                return redirect('/inventory-master-list')->with('status','Record created.'); 
            }


        }
    }


        public function code($id)
    {
        $no_of_digit = 5;
        $number = $id;
        $length = strlen((string)$number);
            for($i = $length;$i<$no_of_digit;$i++)
            {
                $number = '0'.$number;
            }
            return $number;
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

                $InventoryMaster= InventoryMaster::findOrFail($id);
        $InventoryTransactions = InventoryTransactions::sortable()
        ->where("inventory_masters_id",$InventoryMaster->id)
        ->where("status",1)
        ->orderby("id","asc")
        ->paginate(60);


        return view("admin.inventory.view",compact("InventoryMaster","InventoryTransactions"));
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
        $Inventory = InventoryMaster::findOrFail($id);
         $LedgerCodeItemList= LedgerCodeItem::where("status",0)->get(["id","title","code"]);
        return view("admin.inventory.edit",compact("Inventory","LedgerCodeItemList"));
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
            'title' => 'required',
            'reorder_level' => 'required|not_in:0',
            'ledger_code_id' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $record =  InventoryMaster::find($id);
            $record->ledger_code_id= $this->cleanStr(strtoupper($request->input("ledger_code_id")));
            $record->title= $this->cleanStr(strtoupper($request->input("title")));
                  $record->reorder_level= $this->cleanStr(strtoupper($request->input("reorder_level")));
            $record->updated_by= Auth::id();
            // $record->status=0;
            if($record->save())
            {
                return redirect('/inventory-master-list')->with('status','Record created.'); 
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



            public function inventoryQuery(Request $request)
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
         $results = InventoryMaster::find($value);
                  

        return redirect('/inventory-master-list/'.$results->id."/edit")->with('status','Record found.'); 


        }

   
    } 
}
