@extends('layouts.pdf')
@section('content')
<?php 
use App\Models\FeeStructure;
use App\Models\FeePayment;
use App\Models\SetupConfig;

function title($id=null)
{

	$data = SetupConfig::find($id);
	if($data)
	{
		return $data->title;
	}
	else{

		return "";
	}
}

function feePayable($class_program)
{
	$value=0;
	$data = FeeStructure::where("status",1)->where("parent_id",0)
			->where("academic_year",date("Y"))
			->where("class_program",$class_program)
			->first();

			if($data)
			{
				$sum = FeeStructure::where("status","!=",3)
				->where("parent_id",$data->id)
				->sum("amount");
				$value=$sum;
			}
			else{
				$value=0;
			}

			return $value;
}


function feePaid($class_program=null,$student_id=null)
{
	$value=0;
	$data = FeePayment::where("status",1)
			->where("academic_year",date("Y"))
			->where("student_id",$student_id)
			->where("class_id",$class_program)
			->sum("amount");

	

			return $data;
}

?>
<div>

	
<h3><b>{{$title}}</b></h3>
<h3><b>{{$ClassDetails}} </b></h3>

 <table class="table align-items-center mb-0 table-striped">
	<tr style="background:#ccc" border=1>
		<td>#</td>
		<td>Student Name</td>
		<td>Class</td>
		<td>Stream</td>
		<td>Gender</td>
		<td>Fee Payable</td>
		<td>Fee Paid</td>
		<td>Fee Balance</td>
	</tr>

	@foreach($results as $item)

	<tr>
		<td>{{$loop->iteration}}.</td>
		<td>{{$item->StudentData->name}}</td>
		<td>{{$item->ClassData->title}}</td>
		<td>{{$item->StreamData->title}}</td>
		<td>{{title($item->StudentData->gender)}}</td>
		<td>{{number_format(feePayable($item->ClassData->id),2)}}</td>
		<td>{{number_format(feePaid($item->ClassData->id,$item->StudentData->id),2)}}</td>
		<td>{{number_format(feePayable($item->ClassData->id)-feePaid($item->ClassData->id,$item->StudentData->id),2)}}</td>
	</tr>
	@endforeach
</table>


</div>
@endsection