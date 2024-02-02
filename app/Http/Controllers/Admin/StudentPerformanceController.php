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
use App\Models\SubjectCluster;
use App\Models\ExamsLock;
use App\Models\MarksLogs;
use App\Models\ClassTeacher;
use App\Models\SubjectTeacher;



use PDF;

class StudentPerformanceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function performanceProc(Request $request)
    {

        // return $request->all();

        $validator = Validator::make($request->all(), [
           
            'term' => 'required|not_in:0',
            'grade' => 'required|not_in:0',
            'subject' => 'required|not_in:0',
            'exam_record' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

         $term=$request->input('term');
         $grade=$request->input('grade');
         $subject=$request->input('subject');
         $exam_record=$request->input('exam_record');


         $data= ExamsLock::where("status",0)
            ->where("academic_year",date("Y"))
            ->where("exam_id",$exam_record)
            ->where("term_id",$term)
            ->where("close_date","<",date("Y-m-d"))
            ->first();

         if($data)
         {

            return redirect('/student-performance')
        ->with('error','The Exam entry period period has expired '.$data->close_date.', please contact administrator.');  
         }
         else
         {


        return redirect('/student-performance/create/'.$exam_record."/".$term."/".$grade."/".$subject)
        ->with('status','Record found.');        
         }



        

        }
    }
    public function index()
    {
        //
        if(Auth::user()->user_role==2)
        {

            //get list of class subjects
            $subjectsinclusion =SubjectTeacher::where("status",0)
            ->where("academic_year",date("Y"))
            ->where("teacher_id",Auth::id())
            ->groupBy('subject_id')
            ->get(['subject_id'])->toArray();

             $gradesinclusion =SubjectTeacher::where("status",0)
             ->where("teacher_id",Auth::id())
             ->where("academic_year",date("Y"))
             ->groupBy('class_id')
            ->get(['class_id'])->toArray();

            
        $Subjects =SetupConfig::where("status",0)->where("setup_id",5)
        ->whereIn("id",$subjectsinclusion)
        ->get();
        $Grades =SetupConfig::where("status",0)
        ->whereIn("id",$gradesinclusion)
        ->where("setup_id",7)->get();
        }
        elseif(Auth::user()->user_role==0)
        {
        $Subjects =SetupConfig::where("status",0)->where("setup_id",5)->get();
        $Grades =SetupConfig::where("status",0)->where("setup_id",7)->get();
        }


        $Setups=ExamConfiguration::where("parent_id",1)->where("status",0)->get();
        $Levels =SetupConfig::where("status",0)->where("setup_id",9)->get();
        

        // return $Subjects;

        return view('admin.exam-entry.index',compact("Levels","Setups","Subjects","Grades"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($exam_record=null,$term=null,$grade=null,$subject=null)
    {
        //

        // check if cluster exist

        $checkExistingCluster = SubjectCluster::where("class_id",$grade)
        ->where("status",0)
        ->where("parent_id",0)
        ->orderby('id','desc')
        ->first();
        $Score=ExamConfiguration::where('parent_id',1)
        ->where('item_id',$exam_record)
        ->where('status',0)
        ->orderby('id','desc')
        ->first();

        // $Clusters= StudentSubject::where("subject_id",$subject)
        // ->where()

        // dd($checkExistingCluster);
        if($checkExistingCluster)
        {
        $Inclusion =StudentSubject::where("status",0)
        ->where("cluster_id",$checkExistingCluster->id)
        ->where("subject_id",$subject)
        ->get(["student_id"])->toArray();
         $StudentList = StudentClass::where("status",0)
        ->where("year",date("Y"))
        ->where("class_id",$grade)
        ->whereIn("student_id",$Inclusion)
        ->get();
        }
        else{
         $StudentList = StudentClass::where("status",0)
        ->where("year",date("Y"))
        ->where("class_id",$grade)
        ->get();           
        }

        if(count($StudentList)>0)
        {
        $GradeName= SetupConfig::findOrFail($grade);
        $SubjectName= SetupConfig::findOrFail($subject);
        $GradeName= $GradeName->title;
        $SubjectName= $SubjectName->title;

        return view ('admin.exam-entry.create',compact('exam_record','term','StudentList','Score','grade','subject','GradeName','SubjectName'));
        }
        else{
                return redirect('/student-performance')
        ->with('error','This subject option is not applicable for this grade due to clustering of subjects.');  
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

         // return $request->all();

        $subject=$request->input('subject');
        $term=$request->input('term');
        $grade=$request->input('grade');
        $exam_record=$request->input('exam_record');
       
    
        $marks=$request->input('marks');
        $stid=$request->input('stid');
        $streamID=$request->input('stream_id');

        $Score=ExamConfiguration::where('parent_id',1)
        ->where('item_id',$exam_record)
        ->where('status',0)
        ->orderby('id','desc')
        ->first();
        $ScoreValue=(int)$Score->marks;

       

        StudentPerformance::where("status",0)
        ->where("class_id",$grade)
        ->where("exam_id",1)
        ->where("subject_id",$subject)
        ->where("academic_level",$term)
        ->where("exam_item_id",$exam_record)
        ->update(["status"=>3]);

        $examDatas= (int)$Score->marks;

        // return($examDatas);
        

        for($x=0;$x<count($stid);$x++)
        {
            $p=$stid[$x];
            $total=$marks[$p]/$examDatas*100;
            if($marks[$p]<=$ScoreValue)
            {
                $data = new StudentPerformance();
                $data->status=0;
                $data->marks=$marks[$p];
                $data->total=$total;
                $data->exam_id=1;
                $data->student_id=$p;
                $data->class_id=$grade;
                $data->subject_id=$subject;
                $data->exam_item_id=$exam_record;
                $data->stream_id=$streamID[$x];
                $data->academic_level=$term;
                $data->created_by=Auth::id();
                $data->academic_year=date("Y");
                $data->updated_by=Auth::id();
                $data->save();                
            }


        }


        return redirect('/student-performance')->with('status','Marks recorded.');


    }


    public function studentPerformanceReport()
    {
        $UserData = User::find(Auth::id());
        
        $ClassList=SetupConfig::where("setup_id",7)->where("status",0)->get();
        $AcademicList=SetupConfig::where("setup_id",9)->where("status",0)->get();

        $ProgramList = Program::where("status",0)->get();
        // return $UserData->user_role;

if($UserData->user_role==4)
{
    $inclusive = StudentAttendance::where("status",0)
    ->where("parent_id",Auth::id())
    ->get(['student_id'])->toArray();
$StudentList = User::where("user_role",3)
        ->get(["id","name","admission_no"]);
}
else{
   $StudentList = User::where("user_role",3)
        ->get(["id","name","admission_no"]); 
}

        if($UserData->user_role==3)
        {

            return view('admin.exam-entry.student',compact('StudentList','ProgramList','ClassList','AcademicList','UserData'));
        }
        elseif($UserData->user_role==4)
        {
            return view('admin.exam-entry.parent',compact('StudentList','ProgramList','ClassList','AcademicList'));
        }
        else{

           return view('admin.exam-entry.report',compact('StudentList','ProgramList','ClassList','AcademicList')); 
        }

        
    }


    public function columnData($program_id,$class_id,$academic_level,$studentID)
    {
           $ProgramUnits = ProgramSubject::where("status",0)
            ->where("program_id",$program_id)
            // ->where("program_unit_id",$subject_id)
            ->where("academic_level",$class_id)
            ->get(["program_unit_id"]);
            $data=array();
            foreach($ProgramUnits as $item)
            {
            $marks =StudentPerformance::where("program_id",$program_id)
            ->where("student_id",$studentID)
            ->where("class_id",$class_id)
            ->where("subject_id",$item->program_unit_id)
            ->where("academic_level",$academic_level)
            ->where("status","!=",3)->sum("marks");
                $data[]=[
                        "title"=>$item->ProgamUnitData->title,
                        "data"=>[
                            "subject"=>$item->ProgamUnitData->title,
                            "marks"=>$marks,
                        ]
                ];
            }

            return $data;
    }

    public function studentReportProc(Request $request)
    {


        // return $request->all();

$setting= Setting::find(1);

        $validator = Validator::make($request->all(), [
            // 'program_id' => 'required|not_in:0',
            'class_id' => 'required|not_in:0',
            'academic_level' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

        $student_id=$request->input('student_id');
        $program_id=$request->input('program_id');
        $class_id=$request->input('class_id');
        $academic_level=$request->input('academic_level');
        $report_type=$request->input('report_type');

        if($student_id>0)
        {
            $Results= StudentPerformance::where("student_id",$student_id)
            ->where("class_id",$class_id)
            ->where("academic_level",$academic_level)
            ->where("status","!=",3)
            ->groupBy(["student_id"])
            ->get();
        }
       
        else{
            $Results= StudentPerformance::where("class_id",$class_id)
            ->where("academic_level",$academic_level)
            ->where("status","!=",3)
            ->orderby("student_id")
            ->groupBy(["student_id"])
            ->get();

        }

        // return $Results;
        if(count($Results))
        {



    


            $title="Student Performance :: ";
            $ProgramUnits = SetupConfig::where("status",0)->where("setup_id",5)
            ->get();
            $Examstype=1;
            $Examstypes= ExamConfiguration::where("parent_id",$Examstype)
                ->where("status",0)
                ->orderby("id","asc")
            ->get();

    if($report_type==1)
    {
    $pdf = PDF::loadView('report.student-performance',
                compact('setting','ProgramUnits','title','Results','academic_level','class_id','Examstypes'))->setPaper('A3', 'landscape');
       return $pdf->stream("Program_Print".time().".pdf");
    }
    else{
    $pdf = PDF::loadView('report.student-performance-detailed',
                compact('setting','ProgramUnits','title','Results','academic_level','class_id','Examstypes'))->setPaper('A3', 'landscape');
       return $pdf->stream("Program_Print".time().".pdf");

    }


        }
        else{


            return redirect('/student-performance-report')->with('status','No data found');
        }

        }

    }


 public function reportForm()
    {
        $UserData = User::find(Auth::id());
        if($UserData->user_role==2)
        {

            //get list of class subjects
            $inclusion =ClassTeacher::where("status",0)
            ->where("academic_year",date("Y"))
            ->where("teacher_id",Auth::id())
            ->get(['class_id'])->toArray();

            
        $ClassList=SetupConfig::where("setup_id",7)->where("status",0)
        ->whereIn('id',$inclusion)
        ->get();
         $StreamList=SetupConfig::where("setup_id",8)->where("status",0)->get();
        }

        else{
             $ClassList=SetupConfig::where("setup_id",7)->where("status",0)->get();            
        $StreamList=SetupConfig::where("setup_id",8)->where("status",0)->get(); 
        }
        
        
        $AcademicList=SetupConfig::where("setup_id",9)->where("status",0)->get();
        $ExamList=SetupConfig::where("setup_id",14)->where("status",0)->get();
        

        $ProgramList = Program::where("status",0)->get();
        // return $UserData->user_role;

if($UserData->user_role==4)
{
    $inclusive = StudentAttendance::where("status",0)
    ->where("parent_id",Auth::id())
    ->get(['student_id'])->toArray();
$StudentList = User::where("user_role",3)
        ->get(["id","name","admission_no"]);
}
else{
   $StudentList = User::where("user_role",3)
        ->get(["id","name","admission_no"]); 
}

        // if($UserData->user_role==3)
        // {

        //     return view('admin.exam-entry.studentreportform',compact('StudentList','ProgramList','ClassList','AcademicList','UserData'));
        // }
        // elseif($UserData->user_role==4)
        // {
        //     return view('admin.exam-entry.parentreportform',compact('StudentList','ProgramList','ClassList','AcademicList'));
        // }
        // else{

        //    return view('admin.exam-entry.reportform',compact('StudentList','ProgramList','ClassList','AcademicList')); 
        // }


return view('admin.exam-entry.reportform',compact('StudentList','ProgramList','ClassList','AcademicList','ExamList','StreamList')); 

        
    }

    public function reportFormProc(Request $request)
    {

        $grade= $request->input("grade");
        $stream= $request->input("stream");
        $term= $request->input("term");
        $exam_type= $request->input("exam_type");
        $academic_year= $request->input("academic_year");
        $report_type= $request->input("report_type");

        if($report_type==1)
        {
        $validator = Validator::make($request->all(), [
            'grade' => 'required|not_in:0',
            'stream' => 'required|not_in:0',
            'term' => 'required|not_in:0',
            'exam_type' => 'required',
        ]);
        }
        else{

        $validator = Validator::make($request->all(), [
            'grade' => 'required|not_in:0',
            // 'stream' => 'required|not_in:0',
            'term' => 'required|not_in:0',
            'exam_type' => 'required',
        ]);

        }


        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

   if($exam_type==0)
   {

    if($stream==0)
    {
            $StudentData = StudentPerformance::where("status",0)
                ->where("academic_year",$academic_year)
                ->where("academic_level",$term)
                ->where("class_id",$grade)
                // ->where("stream_id",$stream)
                ->groupBy("student_id")
                ->get();

            $StudentDataEntries = StudentPerformance::where("status",0)
                ->where("academic_year",$academic_year)
                ->where("academic_level",$term)
                ->where("class_id",$grade)
                // ->where("stream_id",$stream)
                ->get();
    }
    else
    {
            $StudentData = StudentPerformance::where("status",0)
                ->where("academic_year",$academic_year)
                ->where("academic_level",$term)
                ->where("class_id",$grade)
                ->where("stream_id",$stream)
                ->groupBy("student_id")
                ->get();

            $StudentDataEntries = StudentPerformance::where("status",0)
                ->where("academic_year",$academic_year)
                ->where("academic_level",$term)
                ->where("class_id",$grade)
                ->where("stream_id",$stream)
                ->get();

    }

   }
   else{


    if($stream==0)
    {
                $StudentData = StudentPerformance::where("status",0)
                ->where("academic_year",$academic_year)
                ->where("academic_level",$term)
                ->where("class_id",$grade)
                // ->where("stream_id",$stream)
                ->where("exam_item_id",$exam_type)
                ->groupBy("student_id")
                ->get();

            $StudentDataEntries = StudentPerformance::where("status",0)
                ->where("academic_year",$academic_year)
                ->where("academic_level",$term)
                ->where("class_id",$grade)
                // ->where("stream_id",$stream)
                ->where("exam_item_id",$exam_type)
                ->get();
    }
    else{


                        $StudentData = StudentPerformance::where("status",0)
                ->where("academic_year",$academic_year)
                ->where("academic_level",$term)
                ->where("class_id",$grade)
                ->where("stream_id",$stream)
                ->where("exam_item_id",$exam_type)
                ->groupBy("student_id")
                ->get();

            $StudentDataEntries = StudentPerformance::where("status",0)
                ->where("academic_year",$academic_year)
                ->where("academic_level",$term)
                ->where("class_id",$grade)
                ->where("stream_id",$stream)
                ->where("exam_item_id",$exam_type)
                ->get();
    }

   }

$setting= Setting::find(1);
// dd($StudentDataEntries);
 
            $uid=time();   
             
            if($StudentDataEntries)
            {

                foreach ($StudentDataEntries as $entries) {

            if($stream==0)
            {
            $BulkMarks=StudentPerformance::where("status",0)
            ->where("academic_year",$academic_year)
            ->where("academic_level",$term)
            ->where("class_id",$grade)
            // ->where("stream_id",$stream)
            ->where("student_id",$entries->student_id)
            ->where("subject_id",$entries->subject_id)
            ->sum("marks");
            }
            else{
            $BulkMarks=StudentPerformance::where("status",0)
            ->where("academic_year",$academic_year)
            ->where("academic_level",$term)
            ->where("class_id",$grade)
            ->where("stream_id",$stream)
            ->where("student_id",$entries->student_id)
            ->where("subject_id",$entries->subject_id)
            ->sum("marks");

            }
                    
                   if($exam_type==0)
                   {
                        $record = new MarksLogs();
                        $record->student_id=$entries->student_id;
                        $record->class_id=$entries->class_id;
                        $record->stream_id=$entries->stream_id;
                        $record->subject_id=$entries->subject_id;
                        $record->marks=$BulkMarks;
                        $record->total=$BulkMarks;
                        $record->uid=$uid;
                        $record->save();    
                   }
                   else{
                        $record = new MarksLogs();
                        $record->student_id=$entries->student_id;
                        $record->class_id=$entries->class_id;
                        $record->stream_id=$entries->stream_id;
                        $record->subject_id=$entries->subject_id;
                        $record->marks=$entries->marks;
                        $record->total=$entries->total;
                        $record->uid=$uid;
                        $record->save();                  
                   }

                }
            }      
         $dataChecking = MarksLogs::where("uid",$uid)->count("id");   


        if($dataChecking>0)
        {

        $clusters = SubjectCluster::where("class_id",$grade)
        ->where("parent_id","!=",0)
        ->where("status",0)
        ->get();
        if(count($clusters)>0)
        {
        $subject_list=$clusters;
        $opt=1;
        }
        else{

        $subject_list=SetupConfig::where("status",0)->where("setup_id",5)
        ->get();
        $opt=2;
        }

        // dd($opt);

        $Results=array();

        if($report_type==1){

           foreach($StudentData as $student)
           {

                $total_marks=MarksLogs::where("uid",$uid)
                ->where("student_id",$student->StudentData->id)
                ->sum("total");

                $total_subjects=count($subject_list);
                $total_score=$total_subjects*100;

                $score=round($total_marks/$total_score*100);

                $dataLines[]=[

                    "student_name"=>$student->StudentData->name,
                    "total_subjects"=>$total_subjects,
                    "total_marks"=>$total_marks,
                    "percentage_score"=>$score,
                    "grade_value"=>$this->comment($score),
                    "student_class"=>$student->ClassData->title." ".$student->StreamData->title,
                    "uid"=>$uid,
                    "rows"=>$this->marksEntryList($subject_list,$uid,$student->StudentData->id,$student->ClassData->title."-".$student->StreamData->title,$opt)

                ];
           }


           $Results=[
                "lines"=>$dataLines
           ];


           // return $Results;

            
            $title="Report Form";
            if($exam_type==0)
            {
            $details=SetupConfig::findOrFail($term)->title." - Final Exam Combined";
            }
            else{
               $details=SetupConfig::findOrFail($term)->title." - ".SetupConfig::findOrFail($exam_type)->title;  
            }
           
            $Grades = Grade::where("status",0)->orderby("points_opening","desc")->get();
            $pdf = PDF::loadView('report.report-form',
                        compact('setting','title','Results','Grades','details'))->setPaper('A4', 'potrait');
               return $pdf->stream("Report_Form".time().".pdf");

               } 
            else{

                // 

                // dd("Class Perfomance Sheet");




                if($stream==0)
                {
                    $StreamList=SetupConfig::where("setup_id",8)->where("status",0)->get();
                }
                else{
                    $StreamList=SetupConfig::where("setup_id",8)
                    ->where("id",$stream)
                    ->where("status",0)->get();
                }

                foreach($StreamList as $StreamItem)
                {

                    $dataLines[]=[
                        "stream_name"=>$StreamItem->title,
                        "subjects"=>count($subject_list),
                        "uid"=>$uid,
                        "rows"=>$this->subjectMaker($subject_list,$uid,$StreamItem->id,$opt)
                    ];
                }


               

                $Results=[
                    "lines"=>$dataLines
                ];
                $GradeName=SetupConfig::findOrFail($grade)->title;
                // return $Results;

                $title="Class Performance";
                   $pdf = PDF::loadView('report.class-performance-report',
                        compact('setting','title','Results','GradeName'))->setPaper('A3', 'landscape');
               return $pdf->stream("Report_Form".time().".pdf");


                


                // $smart = MarksLogs::where("uid")->get();

                
               } 

          


        }   
        else{

            return redirect('/report-form')->with('error','No data found');
        }             




        }

    }

    public function subjectMaker($subject_list,$uid,$stream,$opt)
    {
        $data=array();

        if($subject_list){

            foreach($subject_list as $subject)
            {
                if($opt==1)
                {
                    $total_marks=MarksLogs::where("uid",$uid)
                    ->where("subject_id",$subject->subject_id)
                    ->where("stream_id",$stream)
                    ->sum("total");

                    $countStudents = MarksLogs::where("uid",$uid)
                    ->where("subject_id",$subject->subject_id)
                    ->where("stream_id",$stream)
                    ->groupBy("student_id")
                    ->count("total");


                    $averageScore = MarksLogs::where("uid",$uid)
                    ->where("subject_id",$subject->subject_id)
                    ->where("stream_id",$stream)
                    ->groupBy("student_id")
                    ->avg("total");
                

                    $data[]=[
                   "subject"=>SetupConfig::findOrFail($subject->subject_id)->title,
                    "score"=>$total_marks,
                    "stream_id"=>$stream,
                    "students"=>$countStudents,
                    "average_score"=>round($averageScore)
                    ];
                }
                else{

                $obtain_marks=MarksLogs::where("uid",$uid)
                ->where("subject_id",$subject->id)
                ->where("stream_id",$stream)
               ->sum("marks");

                 $countStudents=MarksLogs::where("uid",$uid)
                ->where("subject_id",$subject->id)
                ->where("stream_id",$stream)
                ->groupBy("student_id")
               ->count("marks");

               $averageScore=MarksLogs::where("uid",$uid)
                ->where("subject_id",$subject->id)
                ->where("stream_id",$stream)
                ->groupBy("student_id")
               ->avg("marks");

                $data[]=[
                    "subject"=>SetupConfig::findOrFail($subject->id)->title,
                    "score"=>$obtain_marks,
                    "stream_id"=>$stream,
                    "students"=>$countStudents,
                    "average_score"=>round($averageScore)
                ];

                }

            }


        }

        return $data;
    }


    public function comment($marks=null)
    {
        if($marks>0)
        {
                    $data=Grade::where("status",0)
            ->whereRaw('"'.$marks.'" between points_closing and points_opening')->first();
         if($data)
         {
            if($data->grade_id>0)
            {
                return $data->GradeData->title;
            }
            else{
                return " ";
            }
         }
         else{
            return " ";
         }
        }
        else{

            return "";
        }
  
    }
        public function commentDesc($marks=null)
    {
        if($marks>0)
        {
                    $data=Grade::where("status",0)
            ->whereRaw('"'.$marks.'" between points_closing and points_opening')->first();
         if($data)
         {
            if($data->grade_id>0)
            {
                return $data->GradeData->description;
            }
            else{
                return " ";
            }
         }
         else{
            return " ";
         }
        }
        else{

            return "";
        }
  
    }


    public function markAverage($subject=null,$uid=null)
    {
        return round(MarksLogs::where("uid",$uid)
        ->where("subject_id",$subject)
        ->avg("total"));
    }

    public function commentValue($marks=null)
    {
        if($marks>0)
        {
            $DataRange = Grade::where("status",0)->orderby("points_opening","desc")
            ->get(["points_opening"])
            ->pluck('points_opening')
            ->toArray();
            $data=Grade::where("status",0)
            ->whereRaw('"'.$marks.'" between points_closing and points_opening')->first();
         if($data)
         {
            if($data->grade_id>0)
            {
                $numbers =$DataRange;
                $numberToFind = $data->points_opening;
                $position = array_search($numberToFind, $numbers);
                if ($position !== false) {
                return $position + 1;
                } else {
                return "";
                }
            }
            else{
                return " ";
            }
         }
         else{
            return " ";
         }
        }
        else{

            return "";
        }
  
    }

    public function marksEntryList($subject_list,$uid,$studentID,$class,$opt)
    {

        $data=array();

        // $Results = MarksLogs::where("uid",$uid)

        if($subject_list){

            foreach($subject_list as $subject)
            {
                if($opt==1)
                {
                    $obtain_marks=MarksLogs::where("uid",$uid)
                    ->where("subject_id",$subject->subject_id)
                    ->where("student_id",$studentID)
                    ->first();
                    if($obtain_marks)
                    {
                        $obtain_marks=$obtain_marks->marks;
                    }
                    else{
                        $obtain_marks=0;
                    }

                    $total_marks=MarksLogs::where("uid",$uid)
                    ->where("subject_id",$subject->subject_id)
                    ->where("student_id",$studentID)
                    ->first();
                    if($total_marks)
                    {
                        $total_marks=$total_marks->total;
                    }
                    else{
                        $total_marks=0;
                    }
                    $data[]=[

                    
                    "student_id"=>$studentID,
                    "subject_id"=>SetupConfig::findOrFail($subject->subject_id)->title,
                    "total_marks"=>100,
                    "obtain_mark"=>$total_marks,
                    "average"=>$this->markAverage($subject->subject_id,$uid),
                    "grade"=>$this->commentDesc($total_marks),
                    "comment"=>$this->comment($total_marks)
                    ];
                }
                else{
                    
                    $obtain_marks=MarksLogs::where("uid",$uid)
                    ->where("subject_id",$subject->id)
                    ->where("student_id",$studentID)
                    ->first();
                    if($obtain_marks)
                    {
                        $obtain_marks=$obtain_marks->marks;
                    }
                    else{
                        $obtain_marks=0;
                    }

                    $total_marks=MarksLogs::where("uid",$uid)
                    ->where("subject_id",$subject->id)
                    ->where("student_id",$studentID)
                    ->first();
                    if($total_marks)
                    {
                        $total_marks=$total_marks->total;
                    }
                    else{
                        $total_marks=0;
                    }
                    $data[]=[

                    
                    "student_id"=>$studentID,
                    "subject_id"=>SetupConfig::findOrFail($subject->id)->title,
                    "total_marks"=>100,
                    "obtain_mark"=>$total_marks,
                    "average"=>$this->markAverage($subject->id,$uid),
                    "grade"=>$this->commentDesc($total_marks),
                    "comment"=>$this->comment($total_marks)
                    ];
                }
            }
        }



        return $data;



    }

   
}
