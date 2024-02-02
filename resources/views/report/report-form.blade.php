@extends('layouts.reportform')
@section('content')

<?php $StudentResults=$Results["lines"];?>

@for($x=0;$x<count($StudentResults);$x++)
<center>
<table>
    <tr>
        
  
          
              <th  align="center">
            <center>
            	  @if(strlen($setting->logo)>0)
              <img src="{{ public_path("uploads/".$setting->logo) }}" width="{{$setting->width}}" alt="{{$setting->title}}" style="position:absolute; " />  <br/><br/>

              @endif
                  <span class="span-one">{{strtoupper($setting->title)}}</span>
                    <span>
                           
        
            Tel: {!!$setting->phone_number!!}
            P.O BOX {{$setting->postal_address}}<br/>
            Email: {{$setting->email_address}}</b>
                    </span>
         </center>
            
        </th>
    </tr>
</table>   

<table border="1" style="border:solid 1px #000">
    <tr style="background:#ccc">
	<th>Name : {{$StudentResults[$x]["student_name"]}}</th>
	<th>Class : {{$StudentResults[$x]["student_class"]}}</th>
</tr>
<tr>
	<th colspan="2">{{$details}}</th>
</tr>
</table>



<table border="1" style="border:solid 1px #000">
<tr style="background:#ccc">
<th>Subject</th>
<th style="text-align: center;">Total Marks</th>
<th style="text-align: center;">Obtain Marks</th>
<th style="text-align: center;">Average</th>
<th style="text-align: center;">Grade</th>
<th style="text-align: center;">Comment</th>
</tr>
<?php
$rows=$StudentResults[$x]["rows"];
$count_obtained=0;
$count_total=0;
?>
@for($y=0;$y<count($rows);$y++)
<?php 
$count_total+=$rows[$y]["total_marks"];
$count_obtained+=$rows[$y]["obtain_mark"];
?>
<tr>
<th>{{$rows[$y]["subject_id"]}}</th>
<th style="text-align: center;">{{$rows[$y]["total_marks"]}}</th>
<th style="text-align: center;">{{$rows[$y]["obtain_mark"]}}</th>
<th style="text-align: center;">{{$rows[$y]["average"]}}</th>
<th style="text-align: center;">{{$rows[$y]["grade"]}}</th>
<th style="text-align: center;">{{$rows[$y]["comment"]}}</th>

</tr>

@endfor
<tr>
	<tr style="background:#ccc">
		<th>Totals</th>
		<th style="text-align: center;">{{$count_total}}</th>
		<th style="text-align: center;">{{$count_obtained}}</th>
		<th colspan="3"></th>
	</tr>
</tr>
	
</table>

<br/>
<table>
<tr>
	<th>Percentage Pass: {{$StudentResults[$x]["percentage_score"]}}%</th>
	<th>Overall Grade: {{$StudentResults[$x]["grade_value"]}}</th>
</tr>
<tr>
	<tr>
		<th>School will Open</th>
		<th>General Comment</th>
	</tr>
</tr>
</table>


<table>
<tr>
	<th>Class Teacher Signature</th>
	<th>Parent Signature</th>
	<th>School Manager Signature</th>

</tr>

</table>

<table border="1" style="border:solid 1px #000">
	<tr>
		<th colspan="3">GRADING SYSTEM DETAILS</th>
	</tr>
	<tr>
		<th>%Range</th>
		<th style="text-align: center;">Grade</th>
		<th style="text-align: center;">Remarks</th>
	</tr>
	@foreach($Grades as $grade)
<tr>
	<th>{{$grade->points_opening}} - {{$grade->points_closing}}</th>
	<th style="text-align: center;">
		@if($grade->grade_id>0)
		{{$grade->GradeData->description}}

		@else

		@endif
	</th>
	<th style="text-align: center;">
		@if($grade->grade_id>0)
		{{$grade->GradeData->title}}

		@else

		@endif
	</th>
	
</tr>

	@endforeach

</table>


<div style="page-break-before: always;"></div>

@endfor



@endsection