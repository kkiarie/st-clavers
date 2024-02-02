@extends('layouts.pdf')
@section('content')

<?php 
use App\Models\StudentPerformance;
use App\Models\Grade;
function columnData($class_id,$academic_level,$studentID,$program_unit_id,$exam_item_id){

// return $exam_item_id;
 $Data =StudentPerformance::where("status",0)
            ->where("student_id",$studentID)
            ->where("class_id",$class_id)
            ->where("exam_item_id",$exam_item_id)
            ->where("subject_id",$program_unit_id)
            ->where("academic_level",$academic_level)
             ->where("academic_year",date("Y"))
            ->orderby("id","desc")
            ->first();
              

            return $Data; 
}


function grading($marks)
{

    $data=Grade::where("status",0)
            ->whereRaw('"'.$marks.'" between `points_opening` and `points_closing`')->first();
     if($data)
     {
        return $data->GradeData->title;
     }
     else{
        return "not defined";
     }       
}


?>



<div>

	
<h3><b>{{$title}} </b></h3>


 <table class="table align-items-center mb-0 table-striped" border="1">
	<!-- <tr style="background:#ccc" border=1>
		<td>#</td>

	</tr> -->
<tr style="background:#ccc" border=1>
    <td>#</td>
    <td>Student</td>
    @foreach($ProgramUnits as $item)
    <td>{{$item->title}}</td>
    @endforeach
    <td>Total Marks</td>
    <td>Grade</td>
</tr>

<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    @foreach($ProgramUnits as $item)
    <td>
        <table border="0">
        <tr>
            <?php foreach($Examstypes as $Examstype):?>
                <td>{{$Examstype->ExamItem->title}}</td>
            <?php endforeach;?>
        </tr>
        </table>
    </td>

    @endforeach
    <td>Total Marks</td>
    <td>Grade</td>
</tr>

<?php $grand_counter=0;?>
@foreach($Results as $items)
<tr>
 <td>{{$loop->iteration}}.</td>
 <td>{{$items->StudentData->name}}</td>

         <?php  $counter=0; foreach($ProgramUnits as $item):?>
            <td>
                     <table border="0">
        <tr>
            <?php
            
             foreach($Examstypes as $Examstype):
                // $grand_counter=0;
// $counter+=columnData($class_id,$academic_level,$items->student_id,$items->subject_id,$Examstype->ExamItem->id);
// $grand_counter+=columnData($class_id,$academic_level,$items->student_id,$items->subject_id,$Examstype->ExamItem->id);
                ?>
                <td>
          

{{columnData($class_id,$academic_level,$items->student_id,$items->subject_id,$Examstype->item_id)}}
                    <?php 

                   // echo $class_id."=".$academic_level."=".$items->student_id."=".$items->subject_id."=".$Examstype->item_id;

                    ?>
                </td>
            <?php endforeach;?>
        </tr>
        </table>
            </td>



        <?php endforeach;?>
        <td>{{$counter}}</td>
        <td>{{grading($counter)}}</td>



</tr>    

 @endforeach

</table>


</div>



@endsection