<?php

$InstitutionRole[]=["id"=>1,"title"=>"Level 1 - "];
$InstitutionRole[]=["id"=>2,"title"=>"Level 2 - "];


// dd($InstitutionRole[0]["title"]);


$institution_role_list="";
for($x=0; $x<count($InstitutionRole); $x++):
if(isset($Notification)&&$Notification->institution_role==$InstitutionRole[$x]["id"]):
    
$institution_role_list.="<option selected value='".$InstitutionRole[$x]['id']."'>".
$InstitutionRole[$x]['title']."</option>"; 
elseif(old('institution_role')==$InstitutionRole[$x]['id']):
$institution_role_list.="<option selected value='".$InstitutionRole[$x]['id']."'>".
$InstitutionRole[$x]['title']."</option>";       
else:
$institution_role_list.="<option value='".$InstitutionRole[$x]['id']."'>".
$InstitutionRole[$x]['title']."</option>"; 
endif;

endfor; 
$institution_role_list.="";









$role_list="";
foreach($Roles as $item):
if(isset($Notification)&&$Notification->user_role==$item->id):
    
$role_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('user_role')==$item->id):
$role_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$role_list.="<option value='".$item->id."'>$item->title </option>"; 
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

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('notification.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\NotificationController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
<input type="hidden" name="institution_role" value="0">
{{ csrf_field() }}




                <div class="row">

<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Notification Title') }}</label>
                    <div class="@if($errors->has('title'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Notification)){{$Notification->title}}@else{{old('title')}}@endif" type="text" placeholder="Notification Title" id="user-title" name="title">
                            @if($errors->has('title'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('title') }}</p>
                            @endif
                    </div>
                </div>
    </div>



    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Date') }}</label>
                    <div class="@if($errors->has('date'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Notification)){{$Notification->date}}@else{{old('date')}}@endif" type="text" placeholder="Notification Date" id="input-from_date" name="date">
                            @if($errors->has('date'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('date') }}</p>
                            @endif
                    </div>
                </div>
    </div>





    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Roles') }}</label>
                    <div class="@if($errors->has('user_role'))border border-danger rounded-3 @endif">
                <select  name="user_role" 
                id="select-item" class=" form-control-alternative{{ $errors->has('user_role') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$role_list!!}
           </select>
                            @if($errors->has('user_role'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('user_role') }}</p>
                            @endif
                    </div>
                </div>
    </div>  



<!--     <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Institution Level') }}</label>
                    <div class="@if($errors->has('institution_role'))border border-danger rounded-3 @endif">
                <select  name="institution_role" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('institution_role') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$institution_role_list!!}
           </select>
                            @if($errors->has('institution_role'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('institution_role') }}</p>
                            @endif
                    </div>
                </div>
    </div>  -->   

         <div class="col-xs-12 col-md-12">
                <div class="form-group">
                <label for="user-name" class="form-control-label">{{ __('Notification Description') }}</label>
                    <div class="@if($errors->has('description'))border border-danger rounded-3 @endif">
            

                        <textarea class="form-control" name="description" placeholder="Notification Description">@if(isset($Notification)){{$Notification->description}}@else{{old('description')}}@endif</textarea>


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