<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\SetupConfig;
use App\Models\ProgramSubject;

class ProgramSubjectController extends BaseController
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        //
         $ProgramID=$id;   
        $ProgramsLevel= SetupConfig::where("status",0)->where("setup_id",7)->get();
        $ProgramsStages= SetupConfig::where("status",0)->where("setup_id",9)->get();
        $ProgramUnits= SetupConfig::where("status",0)->where("setup_id",5)->get();
        return view('admin.program-unit.create',compact("ProgramsStages","ProgramID","ProgramUnits","ProgramsLevel"));

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
            'program_unit_id' => 'required',
            'program_stage_id' => 'required',
            'academic_level' => 'required',


        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = new ProgramSubject();
            $record->program_stage_id= $this->cleanStr($request->input("program_stage_id"));
            $record->program_unit_id= $this->cleanStr($request->input("program_unit_id"));
            $record->academic_level= $this->cleanStr($request->input("academic_level"));
            $record->program_id= $this->cleanStr($request->input("program_id"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
     
            if($record->save())
            {
                return redirect('/program/'.$record->program_id)->with('status','Record saved.'); 
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    //     $Program= Program::findOrFail($id);
    //     $ProgramSubjects= ProgramSubject::sortable()->where("status",0)->where("program_id",$Program->id)->get();
    //     return view('admin.program.view',compact("Program","ProgramSubjects"));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ProgramUnit= ProgramSubject::findOrFail($id);
         $ProgramsLevel= SetupConfig::where("status",0)->where("setup_id",7)->get();
        $ProgramsStages= SetupConfig::where("status",0)->where("setup_id",9)->get();
        $ProgramUnits= SetupConfig::where("status",0)->where("setup_id",5)->get();
        return view('admin.program-unit.edit',compact("ProgramsStages","ProgramUnits","ProgramUnit","ProgramsLevel"));
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
            'program_unit_id' => 'required',
            'program_stage_id' => 'required',
            'academic_level' => 'required',


        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = ProgramSubject::findOrFail($id);
          $record->program_stage_id= $this->cleanStr($request->input("program_stage_id"));
            $record->program_unit_id= $this->cleanStr($request->input("program_unit_id"));
            $record->academic_level= $this->cleanStr($request->input("academic_level"));
         
            // $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            if($record->save())
            {
                return redirect('/program/'.$record->program_id)->with('status','Record updated.'); 
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
}
