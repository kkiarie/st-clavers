@extends('layouts.user_type.auth')

@section('content')
<?php


$clients_list="";
foreach($StudentList as $item):
if(isset($Grade)&&$Grade->student_id==$item->id):
    
$clients_list.="<option selected value='".$item->id."'>$item->name </option>"; 
elseif(old('student_id')==$item->id):
$clients_list.="<option selected value='".$item->id."'>$item->name </option>";       
else:
$clients_list.="<option value='".$item->id."'>$item->name </option>"; 
endif;
endforeach; 
$clients_list.="";





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
if(isset($Grade)&&$Grade->class_id==$item->id):
    
$class_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('class_id')==$item->id):
$class_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$class_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$class_list.="";




$academic_level_list="";
foreach($AcademicList as $item):
if(isset($Grade)&&$Grade->academic_level==$item->id):
    
$academic_level_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('academic_level')==$item->id):
$academic_level_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$academic_level_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$academic_level_list.="";












?>
<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Parent Review Child Performance Report</h5>
                        </div>
                       
                    </div>
                </div>
                @include('layouts.feedback')
            <div style="padding:10px">
                
              <form action="{{action('App\Http\Controllers\Admin\StudentPerformanceController@studentReportProc')}}" method="POST" >
                {{ csrf_field() }}
                <div class="row">


<div class="col-xl-6">
<div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-client_id">{{ __('Student') }}</label>
<br/>
<select  name="student_id" 
id="select-item" class=" form-control-alternative{{ $errors->has('client_id') ? ' is-invalid' : '' }}">
 
{!!$clients_list!!}
</select>


</div>
</div>







<div class="col-xl-6">
<div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-client_id">{{ __('Grade') }}</label>

<br/>
<select  name="class_id" 
id="" class="select-item form-control-alternative{{ $errors->has('client_id') ? ' is-invalid' : '' }}">
<option value="0">All</option>   
{!!$class_list!!}
</select>

</div>
</div>



<div class="col-xl-6">
<div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-client_id">{{ __('Term') }}</label>

<br/>
<select  name="academic_level" 
id="" class="select-item form-control-alternative{{ $errors->has('client_id') ? ' is-invalid' : '' }}">
<option value="0">All</option>   
{!!$academic_level_list!!}
</select>

</div>
</div>



<div class="col-xl-6">
<div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-client_id">{{ __('Report Type') }}</label>

<br/>

<input type="radio" name="report_type" value="1" checked> Summary
<input type="radio" name="report_type" value="2"> Detailed
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