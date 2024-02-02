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
use App\Models\StudentClass;
use App\Models\StudentParent;
use App\Models\Setting;
use PDF;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Program;
use App\Models\StudentUnits;
use App\Models\SubjectCluster;
use App\Models\StudentSubject;

class StudentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



      public function studentsImport()
    {

        

         $Grades = SetupConfig::where("status",0)
         ->where("setup_id",7)
        ->orderby("title","asc")->get(["title","id"]);

        return view('admin.student.import',compact("Grades"));
    }

    public function studentsImportProc(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'grade'=>'required|not_in:0',
            'document' => 'required|mimes:csv',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{


              $image = $request->file('document');
            if ($image) {
            $image = $request->file('document');
            $filename = time()."_".$image->getClientOriginalName();
            $filename=preg_replace('/\s+/', '', $filename);
            $request->document->move(public_path('uploads'),$filename);
            $filepath = public_path("uploads" . "/" . $filename);
            // Reading file
            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;
            //Read the contents of the uploaded file 
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
            // Skip first row (Remove below comment if you want to skip the first row)
            if ($i == 0) {
            $i++;
            continue;
            }
            for ($c = 0; $c < $num; $c++) {
            $importData_arr[$i][] = $filedata[$c];
            }
            $i++;
            }
            fclose($file); //Close after reading
            $j = 0;

            // return $importData_arr;
           
            $grade = $request->input("grade");
            
            // $error
            $d=0;

            // return $importData_arr;
            foreach ($importData_arr as $importData) {
                $d++;
                // echo $im

                $data = new User();
                $data->name=$importData[0];
                $data->password=Hash::make($importData[1]);
                $data->user_role=3;
                $data->email=time()."@mail.com".$d;
                $data->status=0;
                $data->created_by=Auth::id();
                $data->updated_by=Auth::id();
                if($data->save())
                {

                        $record = new StudentClass();
                        $record->class_id= $grade;
                        $record->stream_id= 17;
                        $record->student_id= $data->id;
                        $record->academic_level= 0;
                        $record->year= date("Y");
                        $record->created_by= Auth::id();
                        $record->updated_by= Auth::id();
                        $record->status=0;
                        $record->save();


                }


            }


            return redirect('/students')->with('status','Import complete.'); 


        }
    }

}


    public function chooseCluster($id=null)
    {

        $SubjectClusters = SubjectCluster::where("parent_id",0)
        ->where("status",0)
        ->get();
        $Student = User::findOrFail($id);

        return view("admin.student.subjectcluster",compact("SubjectClusters","Student"));
    }

    public function  chooseClusterProc(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'cluster_id' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $student_id=$this->cleanStr($request->input("student_id"));
            $clusters = SubjectCluster::where("status",0)
            ->where("parent_id",$request->input("cluster_id"))
            ->get();
            if($clusters)
            {

                StudentSubject::where("academic_year",date("Y"))
                ->where("status",0)
                ->where("student_id",$student_id)
                ->update(["status"=>3]);
                foreach($clusters as $item)
                {
                    $record = new StudentSubject();
                    $record->student_id= $student_id;
                    $record->created_by= Auth::id();
                    $record->updated_by= Auth::id();
                    $record->cluster_id=$request->input("cluster_id");
                    $record->subject_id=$item->subject_id;
                    $record->academic_year=date("Y");
                    $record->status=0;
                    $record->save();
                }
            }
            else{


            }

            return redirect('/students/'.$record->student_id)->with('status','Subject Cluster updated.');


        }


    }
    public function index()
    {
        //


        $Students = User::sortable()->where("user_role",3)
        ->orderby("id","desc")->paginate(70);
        $Clients= User::where("status",0)->where("user_role",3)->get();
        return view('admin.student.index',compact("Students","Clients"));
    }


    public function parentUmerge($id=null)
    {

        $record= StudentParent::findOrFail($id);
        $record->status=3;
        if($record->save())
        {

              return redirect('/students/'.$record->student_id)->with('status','Record unmerged.'); 
        }
    }

    public function parentLink($id=null)
    {

        $Exclude= StudentParent::where("status",0)
        ->where("student_id",$id)
        ->get(["parent_id"])->toArray();


        $ParentList= StudentParent::where("status",0)
        ->where("student_id",$id)
        ->get(["parent_id"]);

        // return $Exclude;
        $Student = User::findOrFail($id);
         $Parents = User::where("status",0)
         ->whereNotIN("id",$Exclude)
         ->where("user_role",4)
        ->orderby("id","asc")->get();
        return view("admin.student.parentlink",compact("Student","Parents","ParentList"));
    }

    public function processParentLink(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'parent_id' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{



            $record = new StudentParent();
            $record->student_id= $this->cleanStr($request->input("student_id"));
            $record->parent_id= $this->cleanStr($request->input("parent_id"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
            if($record->save())
            {

                return redirect('/students/'.$record->student_id)->with('status','Record updated.'); 
            }
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
        $ProgramList= Program::where("status",0)->get(['id','name']);
        $GenderList= SetupConfig::where("status",0)->where("setup_id",2)->get();
        return view('admin.student.create',compact("GenderList","ProgramList"));

    }


    public function studentsQuery(Request $request)
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
         $results = User::find($value);


        return redirect('/students/'.$results->id)->with('status','Record found.'); 


        }

   
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




        $email=$request->input("email");

        // return strlen($email);

        if(strlen($email)>0)
        {
          $validator = Validator::make($request->all(), [
            'name' => 'required',
            'dob' => 'required',
            'physical_address' => 'required',
            'email'=>'email|unique:users,email',
            // 'program_id' => 'required|not_in:0',
        ]);
          
        }
        else{

            $validator = Validator::make($request->all(), [
            'name' => 'required',
            'dob' => 'required',
            // 'program_id' => 'required|not_in:0',
            ]);

        }

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = new User();
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

        if(strlen($email)>0)
        {
            $p=Str::random(9);
            $record->name= $this->cleanStr($request->input("name"));
            $record->physical_address= $this->cleanStr($request->input("physical_address"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=1;
            $record->with_email=0;
            $record->email= $email;
              $record->temp_password=$p;
            $record->password=Hash::make($p);
            $record->phone= $this->cleanStr($request->input("phone"));
            $record->user_role=3;
            $record->gender= $this->cleanStr($request->input("gender"));
            $record->program_id= $this->cleanStr($request->input("program_id"));
            $record->dob= $this->cleanStr($request->input("dob"));
        }
        else{
            $record->name= $this->cleanStr($request->input("name"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
             $record->program_id= $this->cleanStr($request->input("program_id"));
            $record->status=0;
            $record->phone= $this->cleanStr($request->input("phone"));
            $record->email=time()."@mail.com";
            $record->user_role=3;
            $record->physical_address= $this->cleanStr($request->input("physical_address"));
            $record->with_email=1;
            $record->gender= $this->cleanStr($request->input("gender"));
            $record->dob= $this->cleanStr($request->input("dob"));

        }



            if($record->save())
            {
               
                $data=User::find($record->id);
                $data->admission_no=$this->genSequence();
                if($data->save())
                {
                 $this->upSequence();
                }
                
                if(isset($record->email))
                {
                    dispatch(new \App\Jobs\MailOnboardingJob($record))
                    ->delay(Carbon::now()
                    ->addSeconds(20)); 
                }
                return redirect('/students')->with('status','Record updated.'); 
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function genSequence()
    {
        $Sequence = Setting::find(1);
        return $Sequence->admission_no+1;
    }
     public function upSequence()
    {
        $Sequence = Setting::find(1);
        $Sequence->admission_no=$Sequence->admission_no+1;
        $Sequence->save();
    }
    public function show($id)
    {
        //



        $Student = User::findOrFail($id);
        $StudentUnits=StudentUnits::where("status",0)->where("student_id",$Student->id)->get();
        if($Student->program_id>2)
        {
            $ClassDetails=0;
        }
        else{

                    $ClassData=StudentClass::where("status",0)
            ->where("student_id",$Student->id)
            ->orderby("id","desc")
            ->first();
        $ClassDetails=0;    
        if($ClassData)
        {
            $ClassDetails=$ClassData->ClassData->title. " ".$ClassData->StreamData->title;
        } 
        }
    $StudentSubjects=StudentSubject::sortable()->where("status",0)
    ->where("student_id",$id)->where("academic_year",date("Y"))
    ->paginate(30);
        $StudentClass = StudentClass::where("status",0)->where("student_id",$Student->id)->paginate(10);
        $Parents = StudentParent::where("status",0)->where("student_id",$Student->id)->get();
        return view("admin.student.view",compact("Student","StudentClass","Parents","ClassDetails","StudentUnits","StudentSubjects"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Student= User::findOrFail($id);
        $ProgramList= Program::where("status",0)->get(['id','name']);
        $GenderList= SetupConfig::where("status",0)->where("setup_id",2)->get();
        return view('admin.student.edit',compact("GenderList","Student","ProgramList"));
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
            'name' => 'required',
            'dob' => 'required',
            'physical_address' => 'required',
            // 'program_id' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = User::findOrFail($id);
            if ($request->hasFile('logo')) {

            $image = $request->file('logo');
            $filename = time()."_".$image->getClientOriginalName();
            $filename=preg_replace('/\s+/', '', $filename);

            $request->logo->move(public_path('uploads'),$filename);
            $record->file= $filename;
           
            }
            

$record->physical_address= $this->cleanStr($request->input("physical_address"));
            $record->name= $this->cleanStr($request->input("name"));
            $record->dob= $this->cleanStr($request->input("dob"));
 $record->gender= $this->cleanStr($request->input("gender"));
            $record->updated_by= Auth::id();
            $record->program_id= $this->cleanStr($request->input("program_id"));
 $record->phone= $this->cleanStr($request->input("phone"));
            if($record->save())
            {
                return redirect('/students')->with('status','Record updated.'); 
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


    public function classStudentReportSummary()
    {


        $ClassList= SetupConfig::where("status",0)->where("setup_id",7)->get();
        $StreamList= SetupConfig::where("status",0)->where("setup_id",8)->get();

        return view('admin.student.classreportsummary',compact("ClassList","StreamList"));
    }

    public function reportDataProcessSummary(Request $request)
    {

        

        $validator = Validator::make($request->all(), [
            // 'class_id' => 'required|not_in:0',


        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{


            $class_id=$this->cleanStr($request->input("class_id"));
            $stream_id=$this->cleanStr($request->input("stream_id"));
            $year=$this->cleanStr($request->input("year"));
            if($class_id==0&&$stream_id==0)
            {
            $results = StudentClass::where("status",0)
            ->where("year",$year)
            ->groupBy("class_id")
            ->get();
            $students = StudentClass::where("status",0)
            ->where("year",$year)
            ->count("id");

   
            }            
            elseif($class_id>0&&$stream_id>0)
            {
            $results = StudentClass::where("status",0)
            ->where("class_id",$class_id)
            ->where("stream_id",$stream_id)
            ->where("year",$year)
            ->groupBy("class_id")
            ->get();

            $students = StudentClass::where("status",0)
            ->where("class_id",$class_id)
            ->where("stream_id",$stream_id)
            ->where("year",$year)
            ->count("id");
 
            }
            else
            {
            $results = StudentClass::where("status",0)
            ->where("class_id",$class_id)
            ->where("year",$year)
            ->groupBy("class_id")
            ->get();

    
            $students = StudentClass::where("status",0)
            ->where("class_id",$class_id)
            ->where("year",$year)
            ->count("id");
        
            
            }





             if(count($results)>0)
            {
                $Data=array();
                if($results)
                {

                    foreach($results as $item)
                    {

                        $Data[]=[
                         "grade_details"=>[
                         "grade_name"=>$item->ClassData->title,
                         "results"=>["stream_data"=>$this->streamData($item->class_id,$year)],
                         ]
                      ];
                    }
                }


                // return $Data;
        $StreamsData =SetupConfig::where("status",0)->where("setup_id",8)->count("id");
            $setting= Setting::find(1);
            $title="Student Fee Class Report";
            $pdf = PDF::loadView('report.classreportsummary',compact('students','StreamsData','setting','title','Data','year'))->setPaper('A4', 'potrait');
            return $pdf->stream("Student_Fee_Class_Report".time().".pdf");
            }
            else{

                 return redirect('/class-student-report-summary')->with('error','No Data Found.');
            }






        }
    }

    public function streamData($class_id=null,$year=null)
    {

        $StreamsData =SetupConfig::where("status",0)->where("setup_id",8)->get(["id","title"]);
        $records=array();
        $x=0;
        foreach($StreamsData as $item)
        {
            $x++;
            $records[$x]=[

                    "stream_name"=>$item->title,
                    "stream_total"=> StudentClass::where("status",0)
                    ->where("year",$year)
                    ->where("class_id",$class_id)
                    ->where("stream_id",$item->id)
                    ->count("id")
             ];
            
        }
        

        return $records;

    }

    public function classStudentReport()
    {


        $ClassList= SetupConfig::where("status",0)->where("setup_id",7)->get();
        $StreamList= SetupConfig::where("status",0)->where("setup_id",8)->get();

        return view('admin.student.classreport',compact("ClassList","StreamList"));
    }

    public function reportDataProcess(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'class_id' => 'required|not_in:0',


        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{


            // return $request->all();
            $class_id=$this->cleanStr($request->input("class_id"));
            $stream_id=$this->cleanStr($request->input("stream_id"));
            $year=$this->cleanStr($request->input("year"));
            if($class_id>0&&$stream_id>0)
            {
            $results = StudentClass::where("status",0)
            ->where("class_id",$class_id)
            ->where("stream_id",$stream_id)
            ->where("year",$year)
            ->orderby("id","desc")->get();
            $ClassName = SetupConfig::find($class_id)->title;
            $StreamName = SetupConfig::find($stream_id)->title;
            $ClassDetails=$ClassName." ".$StreamName;
            }
            else
            {
            $results = StudentClass::where("status",0)
            ->where("class_id",$class_id)
            // ->where("stream_id",$stream_id)
            ->where("year",$year)
            ->orderby("id","desc")->get();
            $ClassDetails = SetupConfig::find($class_id)->title;
            
            }


            // return $results;

            if(count($results)>0)
            {
            $setting= Setting::find(1);

            $title="Student Fee Class Report";
            $pdf = PDF::loadView('report.classreport',compact('setting','title','results','ClassDetails'))->setPaper('A4', 'potrait');
            return $pdf->stream("Student_Class_Report".time().".pdf");

            }
            else{


                return redirect('/class-student-report')->with('error','No Data Found.');
            }


        }


    }
}


