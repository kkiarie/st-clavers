@extends('layouts.user_type.auth')

@section('content')

<div>
<div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h4>Teacher Import</h4>
  <a href="{{ asset("template/teacher_import.csv") }}">
    
    <button class="btn btn-primary">
      <i class="fa fa-file-excel"></i>  Download Import Template
    </button>
</a> 
     
     <h5>*NB All accounts imported will have the same password of  <b>secret123</b>, the account holders should login and change the password.</h5>           
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')



<form method="post" action="{{action('App\Http\Controllers\Admin\TeacherController@teacherImportProc')}}" enctype="multipart/form-data">

{{ csrf_field() }}




                <div class="row">

              

   

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