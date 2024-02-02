<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentPerformance;
use App\Models\User;
use App\Models\Grade;
use App\Models\Program;
use App\Models\ProgramSubject;
use App\Models\Menu;
use App\Models\SetupConfig;
use App\Models\StudentUnits;
use App\Models\ExamConfiguration;
use App\Models\StudentClass;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\StudentSubject;
use App\Models\ExamsLock;

use PDF;

class ExamsLockController extends BaseController
{
    public function index()
    {
        //
        
        $ExamsLocks =ExamsLock::sortable()->where("status",0)->paginate(30);

        // return $Subjects;

        return view('admin.exams-lock.index',compact("ExamsLocks"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $TermList= SetupConfig::where("status",0)->where("setup_id",9)->get();
        $ExamList= SetupConfig::where("status",0)->where("setup_id",14)->get();
        return view('admin.exams-lock.create',compact("TermList","ExamList"));
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

            'term_id' => 'required|not_in:0',
            'exam_id' => 'required|not_in:0',
            'close_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $data= ExamsLock::where("status",0)
            ->where("academic_year",date("Y"))
            ->where("exam_id",$request->input("exam_id"))
            ->where("term_id",$request->input("term_id"))
            ->first();
            if($data)
            {
                return redirect('/exams-lock/'.$data->id."/edit")->with('status','Record already exist.'); 
            }
            else{
                $record = new ExamsLock();
                $record->close_date= $this->cleanStr($request->input("close_date"));
                $record->exam_id= $this->cleanStr($request->input("exam_id"));
                $record->term_id= $this->cleanStr($request->input("term_id"));
                $record->academic_year=date("Y");
                $record->created_by= Auth::id();
                $record->updated_by= Auth::id();
                $record->status=0;
                if($record->save())
                {

                      return redirect('/exams-lock')->with('status','Record created.'); 
                }                
            }






        }
    }


    public function edit($id)
    {
        //
        $ExamLock= ExamsLock::findOrFail($id);
        $TermList= SetupConfig::where("status",0)->where("setup_id",9)->get();
        $ExamList= SetupConfig::where("status",0)->where("setup_id",14)->get();
        return view('admin.exams-lock.edit',compact("TermList","ExamList","ExamLock"));
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

            'close_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

        $record = ExamsLock::findOrFail($id);
        $record->close_date= $this->cleanStr($request->input("close_date"));
        $record->updated_by= Auth::id();
        if($record->save())
                {

                      return redirect('/exams-lock')->with('status','Record updated.'); 
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
