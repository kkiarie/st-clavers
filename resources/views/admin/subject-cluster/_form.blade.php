<?php

use App\Models\SubjectCluster;

function checked($id=null,$parent_id=null)
{
    $data = SubjectCluster::where("status",0)
    ->where("subject_id",$id)
    ->where("parent_id",$parent_id)
    ->first();

    if($data)
    {
        echo "checked";
    }
    else{

        echo "";
    }
}


function Title($id=null)
{
    $data = SubjectCluster::findOrFail($id);
    if($data)
    {
        return $data->title;
    }
    else{

        return false;
    }
}



function counter($id=null)
{

    $data = SubjectCluster::where("status",0)
    ->where("parent_id",$id)
    ->count("id");

    return $data;
}









$class_list="";
foreach($ClassList as $item):
if(isset($SubjectCluster)&&$SubjectCluster->class_id==$item->id):
    
$class_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('class_id')==$item->id):
$class_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$class_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$class_list.="";



?> 

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">

                  <a href="{{ URL::to("/subject-clusters/") }}" >
            <button class="btn btn-primary "><i class="fa fa-chevron-left"></i> Back </button>
          </a>
                @if(isset($SubjectCluster))

<h6 class="mb-0">{{$label}} </h6>

                @else



                @if(Request::segment(3)>0)
                <h6 class="mb-0">Subject Clusters &raquo; {{Title(Request::segment(3))}} </h6>
                <h6>Total Subject(s) in cluster {{counter(Request::segment(3))}}</h6>
                @else

                <h6 class="mb-0">{{$label}} </h6>
                @endif

                @endif
            </div>
            <div class="card-body pt-4 p-3">


@if($id==null)

<form method="post" action="{{ route('subject-clusters.store')}}" autocomplete="off">
<input type="hidden" name="parent_id" value="{{ Request::segment(3) }}">
@else
<form action="{{action('App\Http\Controllers\Admin\SubjectClusterController@update', $id)}}" method="POST">
<input name="_method" type="hidden" value="PATCH">

@endif  


{{ csrf_field() }}
<div class="row">

@if(isset($SubjectCluster))
<div class="col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Title') }}</label>
                    <div class="@if($errors->has('title'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($SubjectCluster)){{$SubjectCluster->title}}@else{{old('title')}}@endif" type="text" placeholder="Title" id="user-name" name="title">
                            @if($errors->has('title'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('title') }}</p>
                            @endif
                    </div>
                </div>
    </div>

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Choose Class') }}</label>
                    <div class="@if($errors->has('class_id'))border border-danger rounded-3 @endif">
                <select  name="class_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('class_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$class_list!!}
           </select>
                            @if($errors->has('class_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('class_id') }}</p>
                            @endif
                    </div>
                </div>
    </div> 
@else

@if(Request::segment(3)==0)    
<div class="col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Title') }}</label>
                    <div class="@if($errors->has('title'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($SubjectCluster)){{$SubjectCluster->title}}@else{{old('title')}}@endif" type="text" placeholder="Title" id="user-name" name="title">
                            @if($errors->has('title'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('title') }}</p>
                            @endif
                    </div>
                </div>
    </div>
    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Choose Class') }}</label>
                    <div class="@if($errors->has('class_id'))border border-danger rounded-3 @endif">
                <select  name="class_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('class_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$class_list!!}
           </select>
                            @if($errors->has('class_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('class_id') }}</p>
                            @endif
                    </div>
                </div>
    </div> 
@else
<div class="col-md-12">
<h6>Select Cluster Subjects Options</h6>
</div>

@foreach($SubjectList as $item)
<div class="col-md-3">
<input type="checkbox" <?php echo checked($item->id,Request::segment(3)); ?> name="subject_id[]" value="{{$item->id}}"> {{$item->title}}
</div>
@endforeach



@endif




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