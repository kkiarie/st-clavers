@extends('layouts.user_type.auth')

@section('content')
<?php







$stream_list="";
foreach($StreamList as $item):
if(isset($Grade)&&$Grade->stream==$item->id):
    
$stream_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('stream')==$item->id):
$stream_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$stream_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$stream_list.="";





$program_list="";
foreach($ProgramList as $item):
if(isset($Grade)&&$Grade->program_id==$item->id):
    
$program_list.="<option selected value='".$item->id."'>$item->name </option>"; 
elseif(old('program_id')==$item->id):
$program_list.="<option selected value='".$item->id."'>$item->name </option>";       
else:
$program_list.="<option value='".$item->id."'>$item->name </option>"; 
endif;
endforeach; 
$program_list.="";




$class_list="";
foreach($ClassList as $item):
if(isset($Grade)&&$Grade->grade==$item->id):
    
$class_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('grade')==$item->id):
$class_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$class_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$class_list.="";




$academic_level_list="";
foreach($AcademicList as $item):
if(isset($Grade)&&$Grade->term==$item->id):
    
$academic_level_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('term')==$item->id):
$academic_level_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$academic_level_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$academic_level_list.="";





$exam_type_list="";
foreach($ExamList as $item):
if(isset($Grade)&&$Grade->exam==$item->id):
    
$exam_type_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('exam')==$item->id):
$exam_type_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$exam_type_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$exam_type_list.="";












?>
<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Exams Reports</h5>
                        </div>
                       
                    </div>
                </div>
                @include('layouts.feedback')
            <div style="padding:10px">
                
              <form action="{{action('App\Http\Controllers\Admin\StudentPerformanceController@reportFormProc')}}" method="POST" >
                {{ csrf_field() }}
                <div class="row">






<div class="col-xl-4">
<div class="form-group{{ $errors->has('grade') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-grade">{{ __('Grade') }}</label>

<br/>
<select  name="grade" 
id="" class="select-item form-control-alternative{{ $errors->has('grade') ? ' is-invalid' : '' }}">
<option value="0">All</option>   
{!!$class_list!!}
</select>

</div>
</div>

<div class="col-xl-4">
<div class="form-group{{ $errors->has('stream') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-stream">{{ __('Stream') }}</label>

<br/>
<select  name="stream" 
id="" class="select-item form-control-alternative{{ $errors->has('stream') ? ' is-invalid' : '' }}">
<option value="0">All</option>   
{!!$stream_list!!}
</select>

</div>
</div>



<div class="col-xl-4">
<div class="form-group{{ $errors->has('term') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-term">{{ __('Term') }}</label>

<br/>
<select  name="term" 
id="" class="select-item form-control-alternative{{ $errors->has('term') ? ' is-invalid' : '' }}">
<option value="0">All</option>   
{!!$academic_level_list!!}
</select>

</div>
</div>



<div class="col-xl-4">
<div class="form-group{{ $errors->has('exam_type') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-exam_type">{{ __('Exam Type') }}</label>

<br/>
<select  name="exam_type" 
id="" class="select-item form-control-alternative{{ $errors->has('exam_type') ? ' is-invalid' : '' }}">
<option value="0">Combined</option>   
{!!$exam_type_list!!}
</select>

</div>
</div>



<div class="col-xl-4">
<div class="form-group{{ $errors->has('exam_type') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-exam_type">{{ __('Academic Year') }}</label>

<br/>
<select  name="academic_year" 
id="" class="select-item form-control-alternative{{ $errors->has('exam_type') ? ' is-invalid' : '' }}">
@for($x=2023;$x<2050;$x++)

<option value="{{$x}}">{{$x}}</option>
@endfor
</select>

</div>
</div>


<div class="col-xl-4" style="display: none;">
<div class="form-group{{ $errors->has('exam_type') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-exam_type">{{ __('Report Type') }}</label>

<br/>
<input type="radio" name="report_type" value="1" checked> Student Report Form<br/>
<input type="radio" name="report_type" value="2" > Grade Performance<br/>

</div>
</div>



<div class="col-xl-12">
 <button class="btn btn-primary "><i class="fa-solid fa-magnifying-glass"></i> Search</button>
</div>







              </form>
              
              </div>


            </div>
        </div>
    </div>
</div>
 
@endsection