<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\StudentParent;
use App\Models\FeePayment;
use App\Models\StudentClass;
use App\Models\FeeStructure;
use App\Models\User;
use App\Models\Diary;
use Illuminate\Support\Facades\Auth;

class ParentDiary extends Component
{
 public function render()
    {
        $data=$this->hubDiary();
        return view('livewire.diary',compact('data'));
    }

      public function hubDiary()
    {

        $StudentsList=StudentParent::where("parent_id",Auth::id())
        ->where("status",0)->get(["student_id"]);
        $diaryEntry=0;
        // $data=array();
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
                    ->count("id"); 
                    $diaryEntry+=$results;
                   
                 }
            }
        }
        
        

        // $Bells=$diaryEntry["lines"][0];
        return $diaryEntry;


    }
}
