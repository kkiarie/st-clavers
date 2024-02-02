<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentParent;
use App\Models\FeePayment;
use App\Models\StudentClass;
use App\Models\FeeStructure;
use App\Models\User;
use App\Models\Diary;
class ParentHubController extends BaseController
{
    public function childHub()
    {
        $kids=StudentParent::where("status",0)
        ->where("parent_id",Auth::id())
        ->get(["student_id"]);
        $kidsCount=StudentParent::where("status",0)
        ->where("parent_id",Auth::id())
        ->count("student_id");
        return view("admin.parent.childhub",compact("kids","kidsCount"));
    }

    public function hubDiary()
    {

        $StudentsList=StudentParent::where("parent_id",Auth::id())
        ->where("status",0)->get(["student_id"]);
        $diaryEntry=array();
        $data=array();
        if($StudentsList)
        {


            foreach($StudentsList as $item)
            {

                 $StudentClassList= StudentClass::where("status","!=",3)
                ->where("student_id",$item->student_id)
                 ->get(["year","class_id","stream_id"])->toArray();

                 for($x=0;$x<count($StudentClassList); $x++)
                 {
                    $academic_year=$StudentClassList[$x]["year"];
                    $class_id=$StudentClassList[$x]["class_id"];
                    $stream_id=$StudentClassList[$x]["stream_id"];
                    $results=Diary::where("class_id",$class_id)
                    ->where("academic_year",$academic_year)
                    ->where("stream_id",$stream_id)
                    ->orderby("id","desc")
                    ->get(); 

                    if($results)
                    {

                        foreach($results as $result)
                        {

                            $data[]=[
                                "title"=>$result->title,
                                "description"=>$result->description,
                                "created_at"=>$result->created_at,
                                "user"=>$item->StudentData->name,
                                "subject"=>$result->SubjectData->title,
                            ];
                        }
                    }
                 }
            }
        }
        $diaryEntry=[
            "lines"=>[$data]
        ];
        

        $Bells=$diaryEntry["lines"][0];
        return view("admin.diary.mydiary",compact("Bells"));


    }




     public function feeHistory($id=null)
    {


 $CheckStudent=StudentParent::where("parent_id",Auth::id())
        ->where("student_id",$id)
        ->where("status",0)->first();
        if($CheckStudent)
        {
 $FeePayments =FeePayment::sortable()->where("student_id",$id)->where("status",1)
        ->orderby("id","desc")
        ->get();
        $Student=User::findOrFail($id);
        $PaidAmount=FeePayment::where("student_id",$id)->where("status",1)->sum("amount");


        $PaymentsList= StudentClass::where("status","!=",3)
        ->where("student_id",$id)
        ->get(["year","class_id"])->toArray();
        $BalanceAmount=0;

       for($x=0;$x<count($PaymentsList);$x++)
        {
            $class_id=$PaymentsList[$x]["class_id"];
            $academic_year=$PaymentsList[$x]["year"];
            $results = FeeStructure::where("status",1)
            ->where("class_program",$class_id)
            ->where("academic_year",$academic_year)
            ->where("parent_id",0)
            ->get(["id"]);

            if($results)
            {

                foreach($results as $item)
                {
                    $BalanceAmount+=FeeStructure::where("status",1)
                    ->where("parent_id",$item->id)
                    ->sum("amount");
                }
            }

        }
       

        return view("admin.parent.history",compact("BalanceAmount","FeePayments","Student","PaidAmount"));
        }
        else{


            return redirect('/child-hub')->with('error','Invalid action.');

        }


       
    }
}
