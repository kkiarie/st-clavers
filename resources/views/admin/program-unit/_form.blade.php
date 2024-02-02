<?php




$academic_level_list="";
foreach($ProgramsLevel as $item):
if(isset($ProgramUnit)&&$ProgramUnit->academic_level==$item->id):
    
$academic_level_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('academic_level')==$item->id):
$academic_level_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$academic_level_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$academic_level_list.="";




$remark_list="";
foreach($ProgramsStages as $item):
if(isset($ProgramUnit)&&$ProgramUnit->program_stage_id==$item->id):
    
$remark_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('program_stage_id')==$item->id):
$remark_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$remark_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$remark_list.="";







$grade_list="";
foreach($ProgramUnits as $item):
if(isset($ProgramUnit)&&$ProgramUnit->program_unit_id==$item->id):
    
$grade_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('program_unit_id')==$item->id):
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
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('program-subject.store')}}" enctype="multipart/form-data">
    <input type="hidden" name="program_id" value="{{$ProgramID}}">
@else
<form action="{{action('App\Http\Controllers\Admin\ProgramSubjectController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">


    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Program Unit') }}</label>
                    <div class="@if($errors->has('program_unit_id'))border border-danger rounded-3 @endif">
                <select  name="program_unit_id" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('program_unit_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$grade_list!!}
           </select>
                            @if($errors->has('program_unit_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('program_unit_id') }}</p>
                            @endif
                    </div>
                </div>
    </div>    

          




    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Program Stage') }}</label>
                    <div class="@if($errors->has('program_stage_id'))border border-danger rounded-3 @endif">
                <select  name="program_stage_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('program_stage_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$remark_list!!}
           </select>
                            @if($errors->has('program_stage_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('program_stage_id') }}</p>
                            @endif
                    </div>
                </div>
    </div> 




        <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Program Level') }}</label>
                    <div class="@if($errors->has('academic_level'))border border-danger rounded-3 @endif">
                <select  name="academic_level" 
                id="select-item2" class="select-item form-control-alternative{{ $errors->has('academic_level') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$academic_level_list!!}
           </select>
                            @if($errors->has('academic_level'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('academic_level') }}</p>
                            @endif
                    </div>
                </div>
    </div>    















                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">
                        {{ $button }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>