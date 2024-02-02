<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Diary;
use App\Models\SetupConfig;
use App\Models\SubjectTeacher;

class DiaryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $DiaryList = Diary::sortable()->where("teacher_id",Auth::id())
            ->where("status","!=",3)
            ->paginate(50);
        $DiaryLists = Diary::sortable()->where("teacher_id",Auth::id())
            ->where("status","!=",3)
            ->get();
        return view('admin.diary.index',compact("DiaryList","DiaryLists"));
    }


     public function diaryQuery(Request $request)
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
         $results = Diary::find($value);


        return redirect('/diary/'.$results->id."/edit")->with('status','Record found.'); 


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

        $SubjectLists= SubjectTeacher::where("status",0)
        ->where("academic_year",date("Y"))
        ->where("teacher_id",Auth::id())
        ->get(["id","class_id","subject_id","stream_id"]);
        return view('admin.diary.create',compact("SubjectLists"));
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
            'description' => 'required',
            'subject_id' =>  'required|not_in:0',


        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $Meta = SubjectTeacher::findOrFail($request->subject_id);
            $record = new Diary();
            $record->title= $this->cleanStr($request->input("title"));
            $record->description= $this->cleanStr($request->input("description"));
            $record->subject_id= $Meta->subject_id;
            $record->class_id= $Meta->class_id;
            $record->academic_year= $Meta->academic_year;
            $record->stream_id= $Meta->stream_id;
            $record->teacher_id= Auth::id();
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
     
            if($record->save())
            {

                  return redirect('/diary/'.$record->id.'/edit')->with('status','Record created.'); 
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
        $Diary = Diary::findOrFail($id);

        return view("admin.diary.view",compact("Diary"));
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

        $Diary = Diary::findOrFail($id);
        if($Diary->status==0)
        {
            $SubjectLists= SubjectTeacher::where("status",0)
            ->where("academic_year",date("Y"))
            ->where("teacher_id",Auth::id())
            ->get(["id","class_id","subject_id","stream_id"]);
            return view("admin.diary.edit",compact("Diary","SubjectLists"));
        }
        else{
            return view("admin.diary.view",compact("Diary"));           
        }

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
            'description' => 'required',
            'subject_id' =>  'required|not_in:0',


        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $Meta = SubjectTeacher::findOrFail($request->subject_id);
            $record = Diary::findOrFail();
            $record->title= $this->cleanStr($request->input("title"));
            $record->description= $this->cleanStr($request->input("description"));
            $record->subject_id= $Meta->subject_id;
            $record->class_id= $Meta->class_id;
            $record->academic_year= $Meta->academic_year;
            $record->stream_id= $Meta->stream_id;
            $record->teacher_id= Auth::id();
            $record->updated_by= Auth::id();
 
            if($record->save())
            {

                return redirect('/diary/'.$record->id.'/edit')->with('status','Record updated.'); 
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function complete($id)
    {
        //

        $record = Diary::findOrFail($id);
        $record->status=1;
        if($record->save())
        {
              return redirect('/diary/'.$record->id)->with('status','Diary Published.'); 
        }
    }


    public function destroy($id)
    {
        //

        $record = Diary::findOrFail($id);
        $record->status=3;
        if($record->save())
        {
              return redirect('/diary')->with('status','Record removed.'); 
        }
    }
}
