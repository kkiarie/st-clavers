<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ClassTeacher;
use App\Models\SetupConfig;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ClassTeacherController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ClassTeachers= ClassTeacher::sortable()->where("status",0)
        ->orderby("id","desc")->paginate(50);

        return view("admin.class-teachers.index",compact("ClassTeachers"));
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
        return view('admin.class-teachers.create',compact("ClassList","StreamList","TeacherList"));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

$checkExisting=ClassTeacher::where("status",0)
->where("stream_id",$request->input("stream_id"))
->where("class_id",$request->input("class_id"))
->where("academic_year",date("Y"))
->orderby("id","desc")
->first();

        if($checkExisting)
        {
             return redirect('/class-teachers/'.$checkExisting->id."/edit")->with('status','Record already exist you can update the record');
        }
        else{
                    $record = new ClassTeacher();
                    $record->stream_id= $this->cleanStr($request->input("stream_id"));
                    $record->teacher_id= $this->cleanStr($request->input("teacher_id"));
                    $record->class_id= $this->cleanStr($request->input("class_id"));
                    $record->created_by= Auth::id();
                    $record->updated_by= Auth::id();
                    $record->academic_year=date("Y");
                    $record->status=0;
                    if($record->save())
                    {
                        return redirect('/class-teachers')->with('status','Record updated.'); 
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
        $ClassTeacher= ClassTeacher::findOrFail($id);
        $ClassList=SetupConfig::where("status",0)->where("setup_id",7)
        ->get(["id","title"]);
        $StreamList=SetupConfig::where("status",0)->where("setup_id",8)
        ->get(["id","title"]);
        $TeacherList=User::where("status","!=",3)->where("user_role",2)
        ->get(["id","name"]);

        return view('admin.class-teachers.edit',compact("ClassList","StreamList","TeacherList","ClassTeacher"));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

    $checkExisting=ClassTeacher::where("status",0)
    ->where("stream_id",$request->input("stream_id"))
    ->where("class_id",$request->input("class_id"))
    ->where("academic_year",date("Y"))
    ->orderby("id","desc")
    ->first();

            if($checkExisting)
            {
                 return redirect('/class-teachers/'.$checkExisting->id."/edit")->with('status','Record already exist you can update the record');
            }
            else{
                $data=ClassTeacher::where("status",0)
                ->where("id",$id)->update(["status"=>1]);
                        $record = new ClassTeacher();
                        $record->stream_id= $this->cleanStr($request->input("stream_id"));
                        $record->teacher_id= $this->cleanStr($request->input("teacher_id"));
                        $record->class_id= $this->cleanStr($request->input("class_id"));
                        $record->created_by= Auth::id();
                        $record->updated_by= Auth::id();
                        $record->academic_year=date("Y");
                        $record->status=0;
                        if($record->save())
                        {
                            return redirect('/class-teachers')->with('status','Record updated.'); 
                        }

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

        $record = ClassTeacher::findOrFail($id);
        $record->status=3;
        if($record->save())
        {
              return redirect('/class-teachers')->with('status','Record removed.'); 
        }
    }
}
