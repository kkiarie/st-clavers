<?php











$grade_list="";
foreach($Examstype as $item):
if(isset($Grade)&&$Grade->item_id==$item->id):
    
$grade_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('item_id')==$item->id):
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

<form method="post" action="{{ route('exams-configuration.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\ExamConfigurationController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}

<input type="hidden" name="parent_id" value="{{$Record->id}}">


                <div class="row">

<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Marks') }}</label>
                    <div class="@if($errors->has('marks'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Grade)){{$Grade->marks}}@else{{old('marks')}}@endif" type="text" placeholder="marks" id="user-marks" name="marks">
                            @if($errors->has('marks'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('marks') }}</p>
                            @endif
                    </div>
                </div>
    </div>







    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Type Of Exam') }}</label>
                    <div class="@if($errors->has('item_id'))border border-danger rounded-3 @endif">
                <select  name="item_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('item_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$grade_list!!}
           </select>
                            @if($errors->has('item_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('item_id') }}</p>
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