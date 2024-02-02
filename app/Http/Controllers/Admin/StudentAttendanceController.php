<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;
use App\Models\Menu;
use App\Models\StudentAttendance;
use PDF;
use Illuminate\Support\Str;
class StudentAttendanceController extends BaseController
{
    public function studentAttendProc(Request $request)
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

            $record=$request->input("value");
            return redirect('/student-attendance-choice/'.$record)->with('status','Proceed.'); 
        }
    }
    public function index()
    {
        //
        
        $StudentLists = User::where("status","!=",3)->where("user_role",3)
        ->orderby("id","asc")->get(["id","name","admission_no"]);
        return view('admin.student-attendance.index',compact("StudentLists"));
    }



    public function choice($id=null)
    {

        $Student = User::findOrFail($id);
        $record = new StudentAttendance();
        $record->student_id=$id;
        $record->created_by=Auth::id();
        $record->updated_by=Auth::id();
        $record->attendance=date("Y-m-d H:i:s");
        $record->status=0;
        if($record->save())
        {

            $data= StudentAttendance::findOrFail($record->id);
            $data->uid=Str::uuid().$record->id;
            $data->save();
        }



        return view("admin.student-attendance.choice",compact("Student","data"));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
