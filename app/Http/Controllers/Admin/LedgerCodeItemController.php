<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\LedgerCode;
use App\Models\LedgerCodeItem;

class LedgerCodeItemController extends BaseController
{
    
    public function create($id=null)
    {
        //
         return view('admin.ledger-code-items.create');
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
            'title' => 'required|unique:setup_configs',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $record = new LedgerCodeItem();
            $record->title= $this->cleanStr($request->input("title"));
            $record->code= $this->cleanStr($request->input("code"));
      
            $record->ledger_code_id= $this->cleanStr($request->input("ledger_code_id"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
            if($record->save())
            {
                return redirect('/ledger-codes/'.$record->ledger_code_id)->with('status','Record created.'); 
            }


        }
    }


    public function edit($id)
    {
        
        $SetupConfig = LedgerCodeItem::find($id);

        return view("admin.ledger-code-items.edit",compact("SetupConfig"));
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
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $record = LedgerCodeItem::find($id);
            $record->title= $this->cleanStr($request->input("title"));
            $record->code= $this->cleanStr($request->input("code"));
      
            $record->updated_by= Auth::id();
            if($record->save())
            {
                return redirect('/ledger-codes/'.$record->ledger_code_id)->with('status','Record updated.'); 
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

        $setup= LedgerCodeItem::findOrFail($id);
        $setup->status=3;
        $setup->save();
        
        return redirect('/ledger-codes/'.$setup->ledger_code_id)->with('error','record deleted.');
    }
}
