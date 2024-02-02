 @extends('layouts.user_type.auth')

@section('content')


<style type="text/css">
  .table td, .table th{
    white-space:normal !important;
  }
</style>
@if($kidsCount>0)



  <div class="row my-4" style="padding:20px">

    <div class="col-lg-12">
      <div class="scard">
        <div class="scard-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h2><i class="fa-solid fa-users"></i>  ({{$kidsCount}})</h2>
            </div>
          </div>
@if(!$kids->isEmpty())  
<div class="row">
	@foreach($kids as $item)
	<div class="col-xs-12 col-sm-6" style="padding:10px">
<div class="card" style="padding: 20px;">
        <div class="card-body p-3">
		<div class="jumbotron" >
			<div class="container">
				
				<?php if(strlen($item->StudentData->file) >2): ?>
          
         <center> <img src="{{ asset("uploads/".$item->StudentData->file) }}"
           alt="logo" width="50%" class="img-thumbnail"></center>
          <?php endif; ?>
				
				<h6>Name: {{$item->StudentData->name}}</h6>
				<h6>Admission No.: {{$item->StudentData->admission_no}}</h6>
				<h6>Gender : @if($item->StudentData->gender>0)
                           {{$item->StudentData->MetaData->title}}
                  @endif</h6>
				<h6><b><i class="fa-solid fa-clock-rotate-left"></i> Class History</b></h6>
				{!!classHistory($item->student_id)!!}

				<h6><b><i class="fa-solid fa-clock-rotate-left"></i> Fee Payment</b></h6>

				<a href="{{ URL::to("/parent-payment-history/".$item->StudentData->id) }}">
					<button class="btn btn-primary">
						<i class="fa-solid fa-clock-rotate-left"></i> See Payment History
					</button>
				</a>
				
			</div>
		</div>
		</div>
		</div>

	</div>
	@endforeach
</div>
@endif

        </div>
        
      </div>
    </div>

  </div>
@else

<p>No Kids have been attached linked to your account.</p>
@endif  
@endsection



<?php
//

use App\Models\StudentClass;



function classHistory($id=null)
{
	$html="";
	$data=StudentClass::where("student_id",$id)
	->orderby("id","desc")->get();
	if(count($data)>0)
	{

		foreach($data as $item)
		{
			$html.="<p>&rarr;".$item->ClassData->title." ".$item->StreamData->title." ".$item->year."</p>";
		}
	}
	else{

		$html.="No class has been assigned to child";
	}

	return $html;



}
?>