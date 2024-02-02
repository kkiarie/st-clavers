<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SubjectTeacher;
use App\Models\SetupConfig;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubjectTeacherController extends BaseController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $SubjectTeachers= SubjectTeacher::sortable()->where("status",0)
        ->orderby("id","desc")->paginate(50);

        return view("admin.subject-teachers.index",compact("SubjectTeachers"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $ClassList=SetupConfig::where("status",0)->where("setup_id",7)
        ->get(["id","title"]);
        $StreamList=SetupConfig::where("status",0)->where("setup_id",8)
        ->get(["id","title"]);
        $TeacherList=User::where("status","!=",3)->where("user_role",2)
        ->get(["id","name"]);
            $SubjectList=SetupConfig::where("status",0)->where("setup_id",5)
        ->get(["id","title"]);
        return view('admin.subject-teachers.create',compact("ClassList","StreamList","TeacherList","SubjectList"));
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
            'stream_id' => 'required|not_in:0',
            'teacher_id' => 'required|not_in:0',
            'class_id' => 'required|not_in:0',
            'subject_id' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

$checkExisting=SubjectTeacher::where("status",0)
->where("stream_id",$request->input("stream_id"))
->where("class_id",$request->input("class_id"))
->where("subject_id",$request->input("subject_id"))
->where("academic_year",date("Y"))
->orderby("id","desc")
->first();

        if($checkExisting)
        {
             return redirect('/subject-teachers/'.$checkExisting->id."/edit")->with('status','Record already exist you can update the record');
        }
        else{
                    $record = new SubjectTeacher();
                    $record->stream_id= $this->cleanStr($request->input("stream_id"));
                    $record->teacher_id= $this->cleanStr($request->input("teacher_id"));
                    $record->class_id= $this->cleanStr($request->input("class_id"));
                      $record->subject_id= $this->cleanStr($request->input("subject_id"));
                    $record->created_by= Auth::id();
                    $record->updated_by= Auth::id();
                    $record->academic_year=date("Y");
                    $record->status=0;
                    if($record->save())
                    {
                        return redirect('/subject-teachers')->with('status','Record updated.'); 
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

    public function checkExisting()
    {

    }
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
        $SubjectTeacher= SubjectTeacher::findOrFail($id);
        $ClassList=SetupConfig::where("status",0)->where("setup_id",7)
        ->get(["id","title"]);
        $StreamList=SetupConfig::where("status",0)->where("setup_id",8)
        ->get(["id","title"]);
        $TeacherList=User::where("status","!=",3)->where("user_role",2)
        ->get(["id","name"]);
    $SubjectList=SetupConfig::where("status",0)->where("setup_id",5)
        ->get(["id","title"]);

        return view('admin.subject-teachers.edit',compact("ClassList","StreamList","TeacherList","SubjectTeacher","SubjectList"));
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
            'stream_id' => 'required|not_in:0',
            'teacher_id' => 'required|not_in:0',
            'class_id' => 'required|not_in:0',
            'subject_id' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

                $data=SubjectTeacher::where("status",0)
                ->where("id",$id)->update(["status"=>1]);
                        $record = new SubjectTeacher();
                        $record->stream_id= $this->cleanStr($request->input("stream_id"));
                        $record->subject_id= $this->cleanStr($request->input("subject_id"));
                        $record->teacher_id= $this->cleanStr($request->input("teacher_id"));
                        $record->class_id= $this->cleanStr($request->input("class_id"));
                        $record->created_by= Auth::id();
                        $record->updated_by= Auth::id();
                        $record->academic_year=date("Y");
                        $record->status=0;
                        if($record->save())
                        {
                            return redirect('/subject-teachers')->with('status','Record updated.'); 
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

        $record = SubjectTeacher::findOrFail($id);
        $record->status=3;
        if($record->save())
        {
              return redirect('/subject-teachers')->with('status','Record removed.'); 
        }
    }
}
