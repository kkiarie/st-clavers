<?php

$role_list="";
foreach($SubjectLists as $item):
if(isset($Diary)&&$Diary->subject_id==$item->subject_id):
    
$role_list.="<option selected value='".$item->id."'>".$item->ClassData->title." - ".$item->StreamData->title." - ".$item->SubjectData->title."</option>"; 
elseif(old('subject_id')==$item->id):
$role_list.="<option selected value='".$item->id."'>".$item->ClassData->title." - ".$item->StreamData->title." - ".$item->SubjectData->title."</option>";       
else:
$role_list.="<option value='".$item->id."'>".$item->ClassData->title." - ".$item->StreamData->title." - ".$item->SubjectData->title."</option>"; 
endif;
endforeach; 
$role_list.="";


?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">
@if(isset($Diary))

<a href="{{ URL::to("/diary-complete/".$Diary->id) }}" onclick="return confirm('Are you sure ?')">
<button class="btn btn-primary mt-4">&raquo; Publish </button>
</a>
@endif
@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('diary.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\DiaryController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">

<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Title') }}</label>
                    <div class="@if($errors->has('title'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Diary)){{$Diary->title}}@else{{old('title')}}@endif" type="text" placeholder="Title" id="user-title" name="title">
                            @if($errors->has('title'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('title') }}</p>
                            @endif
                    </div>
                </div>
    </div>





    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Subject') }}</label>
                    <div class="@if($errors->has('subject_id'))border border-danger rounded-3 @endif">
                <select  name="subject_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('subject_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$role_list!!}
           </select>
                            @if($errors->has('subject_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('subject_id') }}</p>
                            @endif
                    </div>
                </div>
    </div>  


   

         <div class="col-xs-12 col-md-12">
                <div class="form-group">
                <label for="user-name" class="form-control-label">{{ __(' Description') }}</label>
                    <div class="@if($errors->has('description'))border border-danger rounded-3 @endif">
            

                        <textarea class="form-control" name="description" placeholder=" Description">@if(isset($Diary)){{$Diary->description}}@else{{old('description')}}@endif</textarea>


                            @if($errors->has('description'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('description') }}</p>
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