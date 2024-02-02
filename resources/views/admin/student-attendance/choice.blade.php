@extends('layouts.user_type.auth')

@section('content')
<style type="text/css">
    .qr-image{

        padding:20px;
    }
</style>
<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                  <div>
                            <h3 class="mb-0">School Attendance</h3>
                            <h4>Student Name :: {{$Student->name}}</h4>
                            <h4>Admission No. :: {{$Student->admission_no}}</h4>
                        </div>   
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="qr-image">
            {!! 
                QrCode::eye('circle')
                ->style('round')
                ->size(250)
                ->generate(URL::to("/students-attendance-gen/".$data->uid)); 

                !!}

            </div>
            </div>
        </div>

                       
                    </div>
                </div>
                @include('layouts.feedback')



            </div>
        </div>
    </div>
</div>
 
 
@endsection