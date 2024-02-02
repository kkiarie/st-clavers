<?php

$subjects_list="";
foreach($SubjectList as $item):
if(isset($ResourceHubMaterial)&&$ResourceHubMaterial->program_unit_id==$item->id):
    
$subjects_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('program_unit_id')==$item->id):
$subjects_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$subjects_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$subjects_list.="";





$class_lists="";
foreach($ClassList as $item):
if(isset($ResourceHubMaterial)&&$ResourceHubMaterial->program_stage_id==$item->id):
    
$class_lists.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('program_stage_id')==$item->id):
$class_lists.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$class_lists.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$class_lists.="";







?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('resources-hub.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\ResourceHubMaterialController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">



{{-- <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="title" class="form-control-label">{{ __('Resource Title') }}</label>
                    <div class="@if($errors->has('title'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($ResourceHubMaterial)){{$ResourceHubMaterial->title}}@else{{old('title')}}@endif" type="text" placeholder="Resource Title" id="title" name="title">
                            @if($errors->has('title'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('title') }}</p>
                            @endif
                    </div>
                </div>
    </div> --}}
        <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Subject') }}</label>
                    <div class="@if($errors->has('program_unit_id'))border border-danger rounded-3 @endif">
                <select  name="program_unit_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('client_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$subjects_list!!}
           </select>
                            @if($errors->has('program_unit_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('program_unit_id') }}</p>
                            @endif
                    </div>
                </div>
    </div> 

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Level') }}</label>
                    <div class="@if($errors->has('program_stage_id'))border border-danger rounded-3 @endif">
                <select  name="program_stage_id" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('client_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$class_lists!!}
           </select>
                            @if($errors->has('program_stage_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('program_stage_id') }}</p>
                            @endif
                    </div>
                </div>
    </div> 

        <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('File') }}</label>
                    <div class="@if($errors->has('logo'))border border-danger rounded-3 @endif">
<input class="form-control" type="file" name="logo">
                            @if($errors->has('logo'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('logo') }}</p>
                            @endif
                    </div>

                </div>
    </div>    

   

 
 <div class="col-xs-12 col-md-12">
                <div class="form-group">
                    <label for="description" class="form-control-label">{{ __('Resource Description') }}</label>
                    <div class="@if($errors->has('description'))border border-danger rounded-3 @endif">
                    <textarea class="form-control" placeholder="Resource description" id="description" name="description">@if(isset($ResourceHubMaterial)){{$ResourceHubMaterial->description}}@else{{old('description')}}@endif</textarea>

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




                                         @if(isset($ResourceHubMaterial))<br/>

          <?php if(strlen($ResourceHubMaterial->file) >2): ?>
          
          <a href="{{ asset("uploads/".$ResourceHubMaterial->file) }}" target="_blank">
            <button class="btn btn-primary"><i class="fa fa-file-pdf"></i> Download</button>
          </a>
          <?php endif; ?>

         @endif

            </div>
        </div>
    </div>