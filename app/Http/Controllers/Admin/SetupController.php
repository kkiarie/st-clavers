<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Setup;
use App\Models\SetupConfig;
class SetupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Setups = Setup::sortable()->where("status",0)
        ->orderby("title","asc")->paginate(30);
        return view('admin.setup.index',compact("Setups"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.setup.create');
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

            $record = new Setup();
            $record->title= $this->cleanStr($request->input("title"));
            $record->description= $this->cleanStr($request->input("description"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
            if($record->save())
            {
                return redirect('/setup/'.$record->id)->with('status','Record created.'); 
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
        $Setup = Setup::find($id);
        $SetupConfig = SetupConfig::sortable()->where("status",0)
        ->where("setup_id",$Setup->id)
        ->orderby("title","asc")->paginate(30);

        return view("admin.setup.view",compact("Setup","SetupConfig"));
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
        $Setup = Setup::find($id);

        return view("admin.setup.edit",compact("Setup"));
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

            $record = Setup::find($id);
            $record->title= $this->cleanStr($request->input("title"));
            $record->description= $this->cleanStr($request->input("description"));
            $record->updated_by= Auth::id();
            if($record->save())
            {
                return redirect('/setup')->with('status','Record created.'); 
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

        $setup= Setup::findOrFail($id);
        $setup->status=3;
        $setup->save();
        
        return redirect('/setup')->with('error','record deleted.');
    }
}
