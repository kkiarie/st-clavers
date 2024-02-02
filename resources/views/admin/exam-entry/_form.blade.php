<?php

use App\Models\StudentPerformance;


function tray($class_id,$student_id,$subject_id,$exam_item_id,$academic_level)
{

    $data = StudentPerformance::where("status","!=",3)
    ->where("class_id",$class_id)
    ->where("student_id",$student_id)
    ->where("subject_id",$subject_id)
    ->where("exam_item_id",$exam_item_id)
    ->where("academic_level",$academic_level)
    // ->where("program_id",$program_id)
    ->orderby("id","desc")
    ->first();
    if($data)
    {
        return $data->marks;
    }
    else{

        return 0;
    }


}



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
                <h5 class="mb-0">Grade :: {{$GradeName}}</br/>
                Subject : {{$SubjectName}}<br/> 
              
                    Exam type :: {{$Score->ExamItem->title}}
                </h5>
                <h5>
                    Maximum Score :: {{$Score->marks}}
                </h5>


            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

<form method="post" action="{{ route('student-performance.store')}}" enctype="multipart/form-data"> 
{{ csrf_field() }}
<input type="hidden" name="subject" value="{{$subject}}">
<input type="hidden" name="term" value="{{$term}}">
<input type="hidden" name="grade" value="{{$grade}}">
<input type="hidden" name="exam_record" value="{{$exam_record}}">

<div class="row">
<div class="col-xs-12">
   <table class="table ">
    <tr>
        <th>#</th>
        <th>Student Name</th>
        <th>Stream</th>
        <th>Marks</th>
    </tr>
<?php $x=0; foreach($StudentList as $item): $x++;?>
    <input type="hidden" name="stid[]" value="{{$item->StudentData->id}}">
    <input type="hidden" name="stream_id[]" value="{{$item->StreamData->id}}">
<tr>
    <td>{{$x}}.</td>
    <td>{{$item->StudentData->name}}</td>
    <td>{{$item->StreamData->title}}</td>
    <td>
        <input type="text" name="marks[{{$item->StudentData->id}}]" class="form-control" value="{{tray($grade,$item->StudentData->id,$subject,$exam_record,$term)}}">
    </td>
</tr>   
  

<?php endforeach;?> 
       
   </table>
</div>
</div>
                    <div class="d-flex justify-content-end">
                        <button onclick="return confirm('Are you sure ?')" type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">
                        {{ $button }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>