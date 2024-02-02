<?php


$academic_level_list="";
foreach($AcademiceLevel as $item):
if(isset($Grade)&&$Grade->academic_level==$item->id):
    
$academic_level_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('academic_level')==$item->id):
$academic_level_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$academic_level_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$academic_level_list.="";





$remark_list="";
foreach($ClassList as $item):
if(isset($Grade)&&$Grade->class_id==$item->id):
    
$remark_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('class_id')==$item->id):
$remark_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$remark_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$remark_list.="";







$grade_list="";
foreach($StreamList as $item):
if(isset($Grade)&&$Grade->stream_id==$item->id):
    
$grade_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('stream_id')==$item->id):
$grade_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$grade_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$grade_list.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} {{$Title}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')



<form method="post" action="{{ route('assign-student-class.store')}}" enctype="multipart/form-data">
<input type="hidden" name="student_id" value="{{$student_id}}">
{{ csrf_field() }}




                <div class="row">



    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Class') }}</label>
                    <div class="@if($errors->has('class_id'))border border-danger rounded-3 @endif">
                <select  name="class_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('class_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$remark_list!!}
           </select>
                            @if($errors->has('class_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('class_id') }}</p>
                            @endif
                    </div>
                </div>
    </div>    


@if($option==0)
    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Stream') }}</label>
                    <div class="@if($errors->has('stream_id'))border border-danger rounded-3 @endif">
                <select  name="stream_id" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('stream_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$grade_list!!}
           </select>
                            @if($errors->has('stream_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('stream_id') }}</p>
                            @endif
                    </div>
                </div>
    </div> 

@endif



<!--         <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Academic Level') }}</label>
                    <div class="@if($errors->has('academic_level'))border border-danger rounded-3 @endif">
                <select  name="academic_level" 
                id="select-item-1" class="select-item form-control-alternative{{ $errors->has('academic_level') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$academic_level_list!!}
           </select>
                            @if($errors->has('academic_level'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('academic_level') }}</p>
                            @endif
                    </div>
                </div>
    </div>     -->

          











                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">
                        {{ $button }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>