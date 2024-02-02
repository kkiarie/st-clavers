@extends('layouts.pdf')
@section('content')

<?php 
use App\Models\StudentPerformance;
use App\Models\Grade;
function columnData($class_id,$academic_level,$studentID,$program_unit_id){

 $marks =StudentPerformance::where("student_id",$studentID)
            ->where("class_id",$class_id)
            ->where("subject_id",$program_unit_id)
            ->where("academic_level",$academic_level)
            ->where("status","!=",3)->sum("marks");  

            return $marks; 
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
@foreach($Results as $items)
<tr>
    <td>{{$loop->iteration}}.</td>
    <td>{{$items->StudentData->name}}</td>
        
        <?php $counter=0; foreach($ProgramUnits as $item):
        $counter+=columnData($class_id,$academic_level,$items->student_id,$items->subject_id);
        ?>
            <td>{{

                
columnData($class_id,$academic_level,$items->student_id,$items->subject_id)
                

            }}</td>
        <?php endforeach;?>
        <td>{{$counter}}</td>
        <td>{{grading($counter)}}</td>

</tr>

 @endforeach



</table>


</div>



@endsection