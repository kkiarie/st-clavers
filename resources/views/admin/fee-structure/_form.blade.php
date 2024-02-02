<?php




$program_list="";
foreach($ProgramList as $item):
if(isset($Notification)&&$Notification->program_id==$item->id):
    
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
if(isset($Notification)&&$Notification->class_program==$item->id):
    
$class_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('class_program')==$item->id):
$class_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$class_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$class_list.="";





$stage_list="";
foreach($StageList as $item):
if(isset($Notification)&&$Notification->academic_stage_id==$item->id):
    
$stage_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('academic_stage_id')==$item->id):
$stage_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$stage_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$stage_list.="";






$fee_item_list="";
foreach($FeeItems as $item):
if(isset($Notification)&&$Notification->fee_item==$item->id):
    
$fee_item_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('fee_item')==$item->id):
$fee_item_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$fee_item_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$fee_item_list.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('fee-structure.store')}}" enctype="multipart/form-data">
<input type="hidden" name="parent_id" value="{{$parent_id}}">    
@else
<form action="{{action('App\Http\Controllers\Admin\FeeStructureController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
<input type="hidden" name="program_id" value="1">
{{ csrf_field() }}




                <div class="row">
@if($parent_id>0)
<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">
                    {{ __('Amount') }}</label>
                    <div class="@if($errors->has('amount'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Notification)){{$Notification->amount}}@else{{old('amount')}}@endif" type="text" placeholder="Fee amount" id="user-amount" name="amount">
                            @if($errors->has('amount'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('amount') }}</p>
                            @endif
                    </div>
                </div>
    </div>


 <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Fee Item') }}</label>
                    <div class="@if($errors->has('fee_item'))border border-danger rounded-3 @endif">
                <select  name="fee_item" 
                id="select-item" class=" form-control-alternative{{ $errors->has('fee_item') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$fee_item_list!!}
           </select>
                            @if($errors->has('fee_item'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('fee_item') }}</p>
                            @endif
                    </div>
                </div>
    </div>     
@else




<!--  <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Program') }}</label>
                    <div class="@if($errors->has('program_id'))border border-danger rounded-3 @endif">
                <select  name="program_id" 
                id="" class="select-item form-control-alternative{{ $errors->has('program_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$program_list!!}
           </select>
                            @if($errors->has('program_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('program_id') }}</p>
                            @endif
                    </div>
                </div>
    </div> -->


 <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Grade') }}</label>
                    <div class="@if($errors->has('class_program'))border border-danger rounded-3 @endif">
                <select  name="class_program" 
                id="select-item" class=" form-control-alternative{{ $errors->has('class_program') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$class_list!!}
           </select>
                            @if($errors->has('class_program'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('class_program') }}</p>
                            @endif
                    </div>
                </div>
    </div> 

 <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('stage') }}</label>
                    <div class="@if($errors->has('academic_stage_id'))border border-danger rounded-3 @endif">
                <select  name="academic_stage_id" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('academic_stage_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$stage_list!!}
           </select>
                            @if($errors->has('academic_stage_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('academic_stage_id') }}</p>
                            @endif
                    </div>
                </div>
    </div> 

 @endif    

     



                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">
                        {{ $button }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>