<?php






$remark_list="";
foreach($Remarks as $item):
if(isset($Grade)&&$Grade->remark_id==$item->id):
    
$remark_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('remark_id')==$item->id):
$remark_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$remark_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$remark_list.="";







$grade_list="";
foreach($Grades as $item):
if(isset($Grade)&&$Grade->grade_id==$item->id):
    
$grade_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('grade_id')==$item->id):
$grade_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$grade_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$grade_list.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('grades.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\GradeController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">

<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Points Opening') }}</label>
                    <div class="@if($errors->has('points_opening'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Grade)){{$Grade->points_opening}}@else{{old('points_opening')}}@endif" type="text" placeholder="Points Opening" id="user-points_opening" name="points_opening">
                            @if($errors->has('points_opening'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('points_opening') }}</p>
                            @endif
                    </div>
                </div>
    </div>


<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Points Closing') }}</label>
                    <div class="@if($errors->has('points_closing'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Grade)){{$Grade->points_closing}}@else{{old('points_closing')}}@endif" type="text" placeholder="Points Closing" id="user-name" name="points_closing">
                            @if($errors->has('points_closing'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('points_closing') }}</p>
                            @endif
                    </div>
                </div>
    </div>

<!--     <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Points') }}</label>
                    <div class="@if($errors->has('points'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Grade)){{$Grade->points}}@else{{old('points')}}@endif" type="text" placeholder="Points" id="points" name="points">
                            @if($errors->has('points'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('points') }}</p>
                            @endif
                    </div>
                </div>
    </div> -->


    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Remark') }}</label>
                    <div class="@if($errors->has('remark_id'))border border-danger rounded-3 @endif">
                <select  name="remark_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('remark_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$remark_list!!}
           </select>
                            @if($errors->has('remark_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('remark_id') }}</p>
                            @endif
                    </div>
                </div>
    </div>    



    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Grade') }}</label>
                    <div class="@if($errors->has('grade_id'))border border-danger rounded-3 @endif">
                <select  name="grade_id" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('grade_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$grade_list!!}
           </select>
                            @if($errors->has('grade_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('grade_id') }}</p>
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