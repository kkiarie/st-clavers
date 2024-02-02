@extends('layouts.user_type.auth')

@section('content')
<?php






$remark_list="";
foreach($Grades as $item):
if(old('parent_id')==$item->id):
$remark_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$remark_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$remark_list.="";


?>
<div>
<div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h4>Student Import</h4>
  <a href="{{ asset("template/student_import.csv") }}">
    
    <button class="btn btn-primary">
      <i class="fa fa-file-excel"></i>  Download Import Template
    </button>
</a> 
                
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')



<form method="post" action="{{action('App\Http\Controllers\Admin\StudentController@studentsImportProc')}}" enctype="multipart/form-data">

{{ csrf_field() }}




                <div class="row">

              

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Choose Grade') }}</label>
                    <div class="@if($errors->has('grade'))border border-danger rounded-3 @endif">
                <select  name="grade" 
                id="select-item" class=" form-control-alternative{{ $errors->has('grade') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$remark_list!!}
           </select>
                            @if($errors->has('grade'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('grade') }}</p>
                            @endif
                    </div>
                </div>
    </div>    

<div class="col-xs-12 col-sm-4 ">
                <div class="form-group{{ $errors->has('logbook_document') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-logbook_document">{{ __('CSV File') }}</label>
            <input type="file" name="document" id="input-logbook_document" class="form-control form-control-alternative{{ $errors->has('logbook_document') ? ' is-invalid' : '' }}" >


            @if ($errors->has('logbook_document'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('logbook_document') }}</strong>
                </span>
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