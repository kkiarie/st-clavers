<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Menu;
use App\Models\SetupConfig;
use App\Models\ResourceHubMaterial;

use App\Models\Setting;
use PDF;

class ResourceHubMaterialController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myResourceHub()
    {
        $ResourceHubMaterials = ResourceHubMaterial::sortable()->where("status",1)
        ->orderby("id","asc")->paginate(50);

        return view("admin.resource-hub.myhub",compact("ResourceHubMaterials"));
    }
    public function ResourceHubQuery(Request $request)
    {

    }
    public function index()
    {
        //

        $ResourceHubMaterials = ResourceHubMaterial::sortable()->where("status","!=",3)
        ->orderby("id","asc")->paginate(50);
        $ResourceMaterialList = ResourceHubMaterial::sortable()->where("status","!=",3)
        ->orderby("id","asc")->get();
        return view('admin.resource-hub.index',compact("ResourceHubMaterials","ResourceMaterialList"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $SubjectList = SetupConfig::where("status",0)->where("setup_id",5)
        ->orderby("id","asc")
        ->get(["id","title"]);
        $ClassList =SetupConfig::where("status",0)->where("setup_id",7)
        ->orderby("id","asc")
        ->get(["id","title"]);

        return view('admin.resource-hub.create',compact("SubjectList","ClassList"));
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
            // 'title' => 'required',
             'program_unit_id' => 'required|not_in:0',
             'program_stage_id' => 'required|not_in:0',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = new ResourceHubMaterial();
            if ($request->hasFile('logo')) {

            $image = $request->file('logo');
            $filename = time()."_".$image->getClientOriginalName();
            $filename=preg_replace('/\s+/', '', $filename);

            $request->logo->move(public_path('uploads'),$filename);
            $record->file= $filename;
           
            }
            else{

            $record->file= 0;

            }


            // $record->title= $this->cleanStr($request->input("title"));
            $record->description= $this->cleanStr($request->input("description"));
            $record->program_unit_id= $this->cleanStr($request->input("program_unit_id"));
            $record->program_stage_id= $this->cleanStr($request->input("program_stage_id"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->institution_role=0;
            $record->status=0;



            if($record->save())
            {
                return redirect('/resources-hub')->with('status','Record created successfully.'); 
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
        $ResourceHubMaterial= ResourceHubMaterial::findOrFail($id);
        return view('admin.resource-hub.view',compact("ResourceHubMaterial"));
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
        $SubjectList = SetupConfig::where("status",0)->where("setup_id",5)
        ->orderby("id","asc")
        ->get(["id","title"]);
        $ClassList =SetupConfig::where("status",0)->where("setup_id",7)
        ->orderby("id","asc")
        ->get(["id","title"]);
        $ResourceHubMaterial= ResourceHubMaterial::findOrFail($id);

        return view('admin.resource-hub.edit',compact("SubjectList","ClassList","ResourceHubMaterial"));
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
            // 'title' => 'required',
             'program_unit_id' => 'required|not_in:0',
             'program_stage_id' => 'required|not_in:0',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = ResourceHubMaterial::findOrFail($id);
            if ($request->hasFile('logo')) {

            $image = $request->file('logo');
            $filename = time()."_".$image->getClientOriginalName();
            $filename=preg_replace('/\s+/', '', $filename);

            $request->logo->move(public_path('uploads'),$filename);
            $record->file= $filename;
            $record->description= $this->cleanStr($request->input("description"));
            $record->program_unit_id= $this->cleanStr($request->input("program_unit_id"));
            $record->program_stage_id= $this->cleanStr($request->input("program_stage_id"));
            $record->updated_by= Auth::id();
            $record->institution_role=0;
            $record->status=0;
           
            }
            else{

            $record->description= $this->cleanStr($request->input("description"));
            $record->program_unit_id= $this->cleanStr($request->input("program_unit_id"));
            $record->program_stage_id= $this->cleanStr($request->input("program_stage_id"));
            $record->updated_by= Auth::id();
            $record->institution_role=0;
            $record->status=0;

            }


            // $record->title= $this->cleanStr($request->input("title"));




            if($record->save())
            {
                return redirect('/resources-hub')->with('status','Record created successfully.'); 
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

        $record= ResourceHubMaterial::findOrFail($id);
        $record->status=3;
        if($record->save())
        {
        return redirect('/resources-hub')->with('status','Record created successfully.'); 
        }
    }

    public function ResourcePublish($id=null)
    {

        $record= ResourceHubMaterial::findOrFail($id);
        $record->status=1;
        if($record->save())
        {
        return redirect('/resources-hub/'.$record->id)->with('status','Record created successfully.'); 
        }
    }
}
