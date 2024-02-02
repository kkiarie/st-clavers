@extends('layouts.user_type.auth')

@section('content')
<?php


$levels_list="";
foreach($Levels as $item): 
if(old('item_id')==$item->id):
$levels_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$levels_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$levels_list.="";




$subjects_list="";
foreach($Subjects as $item): 
if(old('item_id')==$item->id):
$subjects_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$subjects_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$subjects_list.="";



$grade_list="";
foreach($Grades as $item): 
if(old('item_id')==$item->id):
$grade_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$grade_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$grade_list.="";






?>
<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Marks Entry</h5>
                        </div>
                       
                    </div>
                </div>
                @include('layouts.feedback')
            <div style="padding:10px">
                
              <form action="{{action('App\Http\Controllers\Admin\StudentPerformanceController@performanceProc')}}" method="POST">
                {{ csrf_field() }}
                <div class="row">


<div class="col-xl-3">
<div class="form-group{{ $errors->has('subject') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-subject">{{ __('Subject') }}</label>
<br/>
<select  name="subject" 
id="select-item" class=" form-control-alternative{{ $errors->has('subject') ? ' is-invalid' : '' }}">
<option value="0">All</option>   
{!!$subjects_list!!}
</select>


</div>
</div>

<div class="col-xl-3">
<div class="form-group{{ $errors->has('term') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-term">{{ __('Terms') }}</label>
<br/>
<select  name="term" 
id="select-item" class="select-item{{ $errors->has('term') ? ' is-invalid' : '' }}">
<option value="0">All</option>   
{!!$levels_list!!}
</select>


</div>
</div>
<div class="col-xl-3">
<div class="form-group{{ $errors->has('grade') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-grade">{{ __('Grade') }}</label>
<br/>
<select  name="grade" 
id="select-item" class="select-item{{ $errors->has('grade') ? ' is-invalid' : '' }}">
<option value="0">All</option>   
{!!$grade_list!!}
</select>


</div>
</div>


<div class="col-xl-3">
<div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
<label class="form-control-label" for="input-client_id">{{ __('Exam Type') }}</label>
<br/>
<?php 
$html="";
$x=0;
foreach($Setups as $item)
{
    $x++;
    if($x==1)
    {
        $html.="<input  class='form-control-label' checked type='radio' value=".$item->item_id." name='exam_record'> ".$item->ExamItem->title."<br/>";
    }
    else{
        $html.="<input class='form-control-label' type='radio' value=".$item->item_id." name='exam_record'> ".$item->ExamItem->title."<br/>";
    }
    
}

echo $html;

?>


</div>
</div>

<div class="col-xl-12">
 <button class="btn btn-primary "><i class="fa-solid fa-magnifying-glass"></i> Proceed</button>
</div>







              </form>
              
              </div>


            </div>
        </div>
    </div>
</div>
 
@endsection