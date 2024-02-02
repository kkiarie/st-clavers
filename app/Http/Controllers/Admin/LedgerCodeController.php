<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\LedgerCode;
use App\Models\LedgerCodeItem;

class LedgerCodeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $LedgerCodes =LedgerCode::sortable()->where("status",0)
        ->orderby("title","asc")->paginate(30);
        $LedgerCodesList= LedgerCode::where("status",0)->get();
        return view('admin.ledger-codes.index',compact("LedgerCodes","LedgerCodesList"));
    }

        public function ledgerQuery(Request $request)
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
         $results = LedgerCode::find($value);


        return redirect('/ledger-codes/'.$results->id."/edit")->with('status','Record found.'); 


        }

   
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.ledger-codes.create');
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
            'title' => 'required|unique:setups',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $record = new LedgerCode();
            $record->title= $this->cleanStr($request->input("title"));
            $record->code= $this->cleanStr($request->input("code"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
            if($record->save())
            {
                return redirect('/ledger-codes/'.$record->id)->with('status','Record created.'); 
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
        $LedgerCode =LedgerCode::find($id);
        $LedgerCodeItems = LedgerCodeItem::sortable()->where("status",0)
        ->where("ledger_code_id",$LedgerCode->id)
        ->orderby("title","asc")->paginate(30);

        return view("admin.ledger-codes.view",compact("LedgerCode","LedgerCodeItems"));
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
        $LedgerCode =LedgerCode::find($id);

        return view("admin.ledger-codes.edit",compact("LedgerCode"));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $record =LedgerCode::find($id);
            $record->title= $this->cleanStr($request->input("title"));
            $record->code= $this->cleanStr($request->input("code"));
            $record->updated_by= Auth::id();
            if($record->save())
            {
                return redirect('/ledger-codes')->with('status','Record updated.'); 
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

        $setup=LedgerCode::findOrFail($id);
        $setup->status=3;
        $setup->save();
        
        return redirect('/ledger-codes')->with('error','record deleted.');
    }
}
