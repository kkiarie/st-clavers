<?php




$subject_list="";
foreach($SubjectList as $item):
if(isset($SubjectTeacher)&&$SubjectTeacher->subject_id==$item->id):
    
$subject_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('subject_id')==$item->id):
$subject_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$subject_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$subject_list.="";




$class_list="";
foreach($ClassList as $item):
if(isset($SubjectTeacher)&&$SubjectTeacher->class_id==$item->id):
    
$class_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('class_id')==$item->id):
$class_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$class_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$class_list.="";







$stream_list="";
foreach($StreamList as $item):
if(isset($SubjectTeacher)&&$SubjectTeacher->stream_id==$item->id):
    
$stream_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('stream_id')==$item->id):
$stream_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$stream_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$stream_list.="";



$teacher_list="";
foreach($TeacherList as $item):
if(isset($SubjectTeacher)&&$SubjectTeacher->teacher_id==$item->id):
    
$teacher_list.="<option selected value='".$item->id."'>$item->name </option>"; 
elseif(old('teacher_id')==$item->id):
$teacher_list.="<option selected value='".$item->id."'>$item->name </option>";       
else:
$teacher_list.="<option value='".$item->id."'>$item->name </option>"; 
endif;
endforeach; 
$teacher_list.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('subject-teachers.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\SubjectTeacherController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">

    <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Teacher') }}</label>
                    <div class="@if($errors->has('teacher_id'))border border-danger rounded-3 @endif">
                <select  name="teacher_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('teacher_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$teacher_list!!}
           </select>
                            @if($errors->has('teacher_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('teacher_id') }}</p>
                            @endif
                    </div>
                </div>
    </div>  

    <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Class') }}</label>
                    <div class="@if($errors->has('class_id'))border border-danger rounded-3 @endif">
                <select  name="class_id" 
                id="" class="select-item form-control-alternative{{ $errors->has('class_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$class_list!!}
           </select>
                            @if($errors->has('class_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('class_id') }}</p>
                            @endif
                    </div>
                </div>
    </div> 




    <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Stream') }}</label>
                    <div class="@if($errors->has('stream_id'))border border-danger rounded-3 @endif">
                <select  name="stream_id" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('stream_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$stream_list!!}
           </select>
                            @if($errors->has('stream_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('stream_id') }}</p>
                            @endif
                    </div>
                </div>
    </div>    




    <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Subject') }}</label>
                    <div class="@if($errors->has('subject_id'))border border-danger rounded-3 @endif">
                <select  name="subject_id" 
                id="select-item-1" class="select-item form-control-alternative{{ $errors->has('subject_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$subject_list!!}
           </select>
                            @if($errors->has('subject_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('subject_id') }}</p>
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