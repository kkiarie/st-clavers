    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{$label}} </h6>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('setting.store')}}" autocomplete="off">
@else
<form action="{{action('App\Http\Controllers\Admin\SettingController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">

<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Title') }}</label>
                    <div class="@if($errors->has('title'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Setting)){{$Setting->title}}@else{{old('title')}}@endif" type="text" placeholder="Title" id="user-name" name="title">
                            @if($errors->has('title'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('title') }}</p>
                            @endif
                    </div>
                </div>
    </div>


<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' KRA PIN') }}</label>
                    <div class="@if($errors->has('kra_pin'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Setting)){{$Setting->kra_pin}}@else{{old('kra_pin')}}@endif" type="text" placeholder="KRA PIN" id="user-name" name="kra_pin">
                            @if($errors->has('kra_pin'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('kra_pin') }}</p>
                            @endif
                    </div>
                </div>
    </div>

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Email Address') }}</label>
                    <div class="@if($errors->has('email_address'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Setting)){{$Setting->email_address}}@else{{old('email_address')}}@endif" type="text" placeholder="Email Address" id="user-name" name="email_address">
                            @if($errors->has('email_address'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('email_address') }}</p>
                            @endif
                    </div>
                </div>
    </div>
    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Phone Number') }}</label>
                    <div class="@if($errors->has('phone_number'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Setting)){{$Setting->phone_number}}@else{{old('phone_number')}}@endif" type="text" placeholder="Phone Number" id="user-name" name="phone_number">
                            @if($errors->has('phone_number'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('phone_number') }}</p>
                            @endif
                    </div>
                </div>
    </div>    

        <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Postal Address') }}</label>
                    <div class="@if($errors->has('postal_address'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Setting)){{$Setting->postal_address}}@else{{old('postal_address')}}@endif" type="text" placeholder="Postal Address" id="user-name" name="postal_address">
                            @if($errors->has('postal_address'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('postal_address') }}</p>
                            @endif
                    </div>
                </div>
    </div>



    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Physical Address') }}</label>
                    <div class="@if($errors->has('physical_address'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Setting)){{$Setting->physical_address}}@else{{old('physical_address')}}@endif" type="text" placeholder="Physical Address" id="user-name" name="physical_address">
                            @if($errors->has('physical_address'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('physical_address') }}</p>
                            @endif
                    </div>
                </div>
    </div>    




    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Logo Width') }}</label>
                    <div class="@if($errors->has('width'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Setting)){{$Setting->width}}@else{{old('width')}}@endif" type="text" 
                        placeholder="Logo Width" id="user-name" name="width">
                            @if($errors->has('width'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('width') }}</p>
                            @endif
                    </div>
                </div>
    </div>    

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' School Motto') }}</label>
                    <div class="@if($errors->has('school_motto'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Setting)){{$Setting->school_motto}}@else{{old('school_motto')}}@endif" type="text" 
                        placeholder="School Motto" id="user-name" name="school_motto">
                            @if($errors->has('school_motto'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('school_motto') }}</p>
                            @endif
                    </div>
                </div>
    </div>



        <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('School Admission No.') }}</label>
                    <div class="@if($errors->has('admission_no'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Setting)){{$Setting->admission_no}}@else{{old('admission_no')}}@endif" type="text" 
                        placeholder="School Admission No." id="user-name" name="admission_no">
                            @if($errors->has('admission_no'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('admission_no') }}</p>
                            @endif
                    </div>
                </div>
    </div>

                    </div>



                    <div class="row">
                            <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Logo') }}</label>
                    <div class="@if($errors->has('logo'))border border-danger rounded-3 @endif">
<input class="form-control" type="file" name="logo">
                            @if($errors->has('logo'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('logo') }}</p>
                            @endif
                    </div>

                                         @if(isset($Setting))<br/>

          <?php if(strlen($Setting->logo) >2): ?>
          
          <img src="{{ asset("uploads/".$Setting->logo) }}" width="100%" alt="logo" >
          <?php endif; ?>

         @endif
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