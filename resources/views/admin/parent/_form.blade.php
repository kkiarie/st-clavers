<?php






$clients_list="";
foreach($GenderList as $item):
if(isset($Parent)&&$Parent->gender==$item->id):
    
$clients_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('gender')==$item->id):
$clients_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$clients_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$clients_list.="";





$parent_role_list="";
foreach($ParentRoleList as $item):
if(isset($Parent)&&$Parent->parental_role==$item->id):
    
$parent_role_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('parental_role')==$item->id):
$parent_role_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$parent_role_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$parent_role_list.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('parents.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\ParentController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">

<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Parent Name') }}</label>
                    <div class="@if($errors->has('name'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Parent)){{$Parent->name}}@else{{old('name')}}@endif" type="text" placeholder="Parent Name" id="user-name" name="name">
                            @if($errors->has('name'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('name') }}</p>
                            @endif
                    </div>
                </div>
    </div>


<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Phone Number') }}</label>
                    <div class="@if($errors->has('phone'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Parent)){{$Parent->phone}}@else{{old('phone')}}@endif" type="text" placeholder="Phone Number" id="user-name" name="phone">
                            @if($errors->has('phone'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('phone') }}</p>
                            @endif
                    </div>
                </div>
    </div>

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Date of Birth') }}</label>
                    <div class="@if($errors->has('dob'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Parent)){{$Parent->dob}}@else{{old('dob')}}@endif" type="text" placeholder="Date of Birth" id="input-from_date" name="dob">
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
                        <input class="form-control" value="@if(isset($Parent)){{$Parent->email}}@else{{old('email')}}@endif" type="text" placeholder="Email Address" id="user-name" name="email">
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

                                         @if(isset($Parent))<br/>

          <?php if(strlen($Parent->file) >2): ?>
          
          <img src="{{ asset("uploads/".$Parent->file) }}" alt="logo" width="100%">
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
                            @if($errors->has('phone_number'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('phone_number') }}</p>
                            @endif
                    </div>
                </div>
    </div>    





    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Parent Role') }}</label>
                    <div class="@if($errors->has('phone_number'))border border-danger rounded-3 @endif">
                <select  name="parental_role" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('parental_role') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$parent_role_list!!}
           </select>
                            @if($errors->has('parental_role'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('parental_role') }}</p>
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