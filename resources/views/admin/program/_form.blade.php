<?php













$program_category="";
foreach($ProgramCategory as $item):
if(isset($Program)&&$Program->program_level==$item->id):
    
$program_category.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('program_level')==$item->id):
$program_category.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$program_category.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$program_category.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('program.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\ProgramController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">

<div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Program Name') }}</label>
                    <div class="@if($errors->has('name'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Program)){{$Program->name}}@else{{old('name')}}@endif" type="text" placeholder="Program Name" id="user-name" name="name">
                            @if($errors->has('name'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('name') }}</p>
                            @endif
                    </div>
                </div>
    </div>


<div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Period') }}</label>
                    <div class="@if($errors->has('period'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Program)){{$Program->period}}@else{{old('period')}}@endif" type="text" placeholder="Period" id="user-name" name="period">
                            @if($errors->has('period'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('period') }}</p>
                            @endif
                    </div>
                </div>
    </div>

    <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Program Cost') }}</label>
                    <div class="@if($errors->has('cost'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Program)){{$Program->cost}}@else{{old('cost')}}@endif" type="text" placeholder="Program Cost" id="cost" name="cost">
                            @if($errors->has('cost'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('cost') }}</p>
                            @endif
                    </div>
                </div>
    </div>





    <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Program Category') }}</label>
                    <div class="@if($errors->has('program_level'))border border-danger rounded-3 @endif">
                <select  name="program_level" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('program_level') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$program_category!!}
           </select>
                            @if($errors->has('program_level'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('program_level') }}</p>
                            @endif
                    </div>
                </div>
    </div>    

         <div class="col-xs-12 col-md-12">
                <div class="form-group">
                <label for="user-name" class="form-control-label">{{ __('Program Description') }}</label>
                    <div class="@if($errors->has('cost'))border border-danger rounded-3 @endif">
            

                        <textarea class="form-control" name="description" placeholder="Program Description">@if(isset($Program)){{$Program->description}}@else{{old('description')}}@endif</textarea>


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