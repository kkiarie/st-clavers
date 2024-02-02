<?php






$exam_list="";
foreach($ExamList as $item):
if(isset($ExamLock)&&$ExamLock->exam_id==$item->id):
    
$exam_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('exam_id')==$item->id):
$exam_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$exam_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$exam_list.="";







$term_list="";
foreach($TermList as $item):
if(isset($ExamLock)&&$ExamLock->term_id==$item->id):
    
$term_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('term_id')==$item->id):
$term_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$term_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$term_list.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('exams-lock.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\ExamsLockController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">



<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Close date') }}</label>
                    <div class="@if($errors->has('close_date'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($ExamLock)){{$ExamLock->close_date}}@else{{old('close_date')}}@endif" type="text" placeholder="Close date" id="input-close_date" name="close_date">
                            @if($errors->has('close_date'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('close_date') }}</p>
                            @endif
                    </div>
                </div>
    </div>




    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Exam List') }}</label>
                    <div class="@if($errors->has('exam_id'))border border-danger rounded-3 @endif">
                <select  name="exam_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('exam_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$exam_list!!}
           </select>
                            @if($errors->has('exam_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('exam_id') }}</p>
                            @endif
                    </div>
                </div>
    </div>    



    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Term') }}</label>
                    <div class="@if($errors->has('term_id'))border border-danger rounded-3 @endif">
                <select  name="term_id" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('term_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$term_list!!}
           </select>
                            @if($errors->has('term_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('term_id') }}</p>
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