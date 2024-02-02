<?php






$clients_list="";
foreach($GenderList as $item):
if(isset($Student)&&$Student->gender==$item->id):
    
$clients_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('gender')==$item->id):
$clients_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$clients_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$clients_list.="";




$program_list="";
foreach($ProgramList as $item):
if(isset($Student)&&$Student->program_id==$item->id):
    
$program_list.="<option selected value='".$item->id."'>$item->name </option>"; 
elseif(old('program_id')==$item->id):
$program_list.="<option selected value='".$item->id."'>$item->name </option>";       
else:
$program_list.="<option value='".$item->id."'>$item->name </option>"; 
endif;
endforeach; 
$program_list.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('students.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\StudentController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}

<input type="hidden" name="program_id" value="0">


                <div class="row">

<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Student Name') }}</label>
                    <div class="@if($errors->has('name'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Student)){{$Student->name}}@else{{old('name')}}@endif" type="text" placeholder="Student Name" id="user-name" name="name">
                            @if($errors->has('name'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('name') }}</p>
                            @endif
                    </div>
                </div>
    </div>


{{-- <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Admission No.') }}</label>
                    <div class="@if($errors->has('admission_no'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Student)){{$Student->admission_no}}@else{{old('admission_no')}}@endif" type="text" placeholder=" Admission No." id="user-name" name="admission_no">
                            @if($errors->has('admission_no'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('admission_no') }}</p>
                            @endif
                    </div>
                </div>
    </div> --}}

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Date of Birth') }}</label>
                    <div class="@if($errors->has('dob'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Student)){{$Student->dob}}@else{{old('dob')}}@endif" type="text" placeholder="Date of Birth" id="input-from_date" name="dob">
                            @if($errors->has('dob'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('dob') }}</p>
                            @endif
                    </div>
                </div>
    </div>
        <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Email Address') }}</label>
                    <div class="@if($errors->has('email'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Student)){{$Student->email}}@else{{old('email')}}@endif" type="text" placeholder="Email Address" id="user-name" name="email">
                            @if($errors->has('email'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('email') }}</p>
                            @endif
                    </div>
            </div>
    </div>

        <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Passport Photo') }}</label>
                    <div class="@if($errors->has('logo'))border border-danger rounded-3 @endif">
<input class="form-control" type="file" name="logo">
                            @if($errors->has('logo'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('logo') }}</p>
                            @endif
                    </div>

                                         @if(isset($Student))<br/>

          <?php if(strlen($Student->file) >2): ?>
          
          <img src="{{ asset("uploads/".$Student->file) }}" alt="logo" width="100%">
          <?php endif; ?>

         @endif
                </div>
    </div>    

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Gender') }}</label>
                    <div class="@if($errors->has('gender'))border border-danger rounded-3 @endif">
                <select  name="gender" 
                id="select-item" class=" form-control-alternative{{ $errors->has('client_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$clients_list!!}
           </select>
                            @if($errors->has('gender'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('gender') }}</p>
                            @endif
                    </div>
                </div>
    </div>  



<!--         <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Program') }}</label>
                    <div class="@if($errors->has('program_id'))border border-danger rounded-3 @endif">
                <select  name="program_id" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('client_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$program_list!!}
           </select>
                            @if($errors->has('program_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('program_id') }}</p>
                            @endif
                    </div>
                </div>
    </div>  -->   

     



<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Phone Number') }}</label>
                    <div class="@if($errors->has('phone'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Student)){{$Student->phone}}@else{{old('phone')}}@endif" type="text" placeholder="Phone Number" id="user-name" name="phone">
                            @if($errors->has('phone'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('phone') }}</p>
                            @endif
                    </div>
                </div>
    </div>





    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Physical Address') }}</label>
                    <div class="@if($errors->has('physical_address'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Student)){{$Student->physical_address}}@else{{old('physical_address')}}@endif" type="text" placeholder="Physical Address" id="user-name" name="physical_address">
                            @if($errors->has('physical_address'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('physical_address') }}</p>
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