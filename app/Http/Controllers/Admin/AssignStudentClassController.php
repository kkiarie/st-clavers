<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentClass;
use App\Models\SetupConfig;
use App\Models\StudentUnits;
use App\Models\ProgramSubject;


class AssignStudentClassController extends BaseController
{


    public function index()
    {


        return StudentClass::all();
    }
    public function create($id=null)
    {
        //
        // StudentClass::truncate();
        $name = User::find($id)->program_id;
        if($name>2)
        {
            $Title=" Details";
            $option=1;
        }
        else{
            $Title=" Class";
            $option=0;
        }
        $student_id=$id;
        $ClassList= SetupConfig::where("status",0)->where("setup_id",7)->get();
        $StreamList= SetupConfig::where("status",0)->where("setup_id",8)->get();
        $AcademiceLevel= SetupConfig::where("status",0)->where("setup_id",9)->get();
        return view('admin.assign-student-class.create',compact("ClassList","StreamList","student_id","Title","option","AcademiceLevel"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tk($Program_id,$class_id,$academic_level,$student_id)
    {

    $collection =ProgramSubject::where("status",0)
            ->where("program_id",$Program_id)
            ->where("academic_level",$class_id)
            ->where("program_stage_id",$academic_level)
            ->get(["program_unit_id","academic_level","program_stage_id"]);

            if($collection){


                StudentUnits::where("student_id",$student_id)
                ->update(["status"=>3]);

                foreach ($collection as $value) {
                    
                    $data = new StudentUnits();
                    $data->subject_id=$value->program_unit_id;
                    $data->academic_level=$value->program_stage_id;
                    $data->class_id=$class_id;
                    $data->program_id=$Program_id;
                    $data->student_id=$student_id;
                    $data->created_by=Auth::id();
                    $data->updated_by=Auth::id();
                    $data->status=0;
                    $data->save();
                }
            }
    }
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'class_id' => 'required|not_in:0',
            // 'stream_id' => 'required|not_in:0',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $class_id=$this->cleanStr($request->input("class_id"));
            $stream_id=$this->cleanStr($request->input("stream_id"));
            $academic_level=$this->cleanStr($request->input("academic_level"));
            $student_id=$this->cleanStr($request->input("student_id"));
            $Program = User::find($request->student_id);
            $year=date("Y");

            $Existing = StudentClass::where("status",0)
            ->where("student_id",$student_id)
            // ->where("stream_id",$stream_id)
            ->where("class_id",$class_id)
            ->where("year",$year)
            ->first();

            $CurrentYear=StudentClass::where("status",0)
            ->where("student_id",$student_id)
            ->where("year",$year)
            ->first();


                                            // return $collection;

                       

            if($Existing)
            {

                $data=StudentClass::findOrFail($Existing->id);
                $data->stream_id=$stream_id;
                if($data->save())
                {
                    

                if($Program->program_id>2)
                {
                    $this->tk($Program->program_id,$class_id,$academic_level,$data->student_id);
                }
                return redirect('/students/'.$data->student_id)->with('status','Record updated.'); 
                }
            }
            else{

                if($CurrentYear)
                {
                    return redirect('/students/'.$CurrentYear->student_id)->with('error','You cannot move a student to a different class in the same year.');
                }
                else{

                        $record = new StudentClass();
                        $record->class_id= $class_id;
                        $record->stream_id= $stream_id;
                        $record->student_id= $student_id;
                        $record->academic_level= $academic_level;
                        $record->year= $year;
                        $record->created_by= Auth::id();
                        $record->updated_by= Auth::id();
                        $record->status=0;
                        if($record->save())
                        {

                          
                if($Program->program_id>2)
                {
                   $this->tk($Program->program_id,$class_id,$academic_level,$record->student_id);
                }

                        return redirect('/students/'.$record->student_id)->with('status','Record updated.'); 
                        }
                }

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
