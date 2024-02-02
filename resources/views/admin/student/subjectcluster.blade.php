@extends('layouts.user_type.auth')

@section('content')
<?php






$remark_list="";
foreach($SubjectClusters as $item):

    

$remark_list.="<option value='".$item->id."'>$item->title </option>"; 

endforeach; 
$remark_list.="";


?>
<div>
<div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h4>Student Name :: {{$Student->name}}</h4>
                <h4>Student Admission No. :: {{$Student->admission_no}}</h4>
            


                
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')



<form method="post" action="{{action('App\Http\Controllers\Admin\StudentController@chooseClusterProc')}}" enctype="multipart/form-data">
<input type="hidden" name="student_id" value="{{$Student->id}}">
{{ csrf_field() }}




                <div class="row">

                <h4>Choose Subject Cluster Option</h4>

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Choose Cluster') }}</label>
                    <div class="@if($errors->has('cluster_id'))border border-danger rounded-3 @endif">
                <select  name="cluster_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('cluster_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$remark_list!!}
           </select>
                            @if($errors->has('cluster_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('cluster_id') }}</p>
                            @endif
                    </div>
                </div>
    </div>    








                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">
                       Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>


@endsection