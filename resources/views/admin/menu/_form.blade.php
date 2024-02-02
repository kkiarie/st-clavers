    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{$label}} </h6>
            </div>
            <div class="card-body pt-4 p-3">


@if($id==null)
                <?php 
$level=Request::segment(3);
$parent=Request::segment(4);

?>
<form method="post" action="{{ route('menu-setup.store')}}" autocomplete="off">
@else

<?php 
$level=$Menu->level;
$parent=$Menu->parent;

?>
<form action="{{action('App\Http\Controllers\Admin\MenuController@update', $id)}}" method="POST">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}


<?php if($level==0):?>
<input type="hidden" name="level" value="{{$level}}">
<input type="hidden" name="parent" value="{{$parent}}">
<?php elseif($level==1):?>
<input type="hidden" name="level" value="1">
<input type="hidden" name="parent" value="{{$parent}}">
<?php else:?>
<input type="hidden" name="level" value="2">
<input type="hidden" name="parent" value="{{$parent}}">
 <?php endif; ?>  

                <div class="row">
<div class="col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Menu Title') }}</label>
                    <div class="@if($errors->has('title'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Menu)){{$Menu->title}}@else{{old('title')}}@endif" type="text" placeholder="Menu Title" id="user-name" name="title">
                            @if($errors->has('title'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('title') }}</p>
                            @endif
                    </div>
                </div>
    </div>



@if($level!=2)
    <div class="col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Menu Icon') }}</label>
                    <div class="@if($errors->has('icon'))border border-danger rounded-3 @endif">
                    <input class="form-control" value="@if(isset($Menu)){{$Menu->icon}}@else{{old('icon')}}@endif" type="text" placeholder="Menu Icon" id="user-name" name="icon">
                            @if($errors->has('icon'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('icon') }}</p>
                            @endif
                    </div>
                </div>
    </div>
 @endif 


 @if($level==2)
    <div class="col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Menu action') }}</label>
                    <div class="@if($errors->has('action'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Menu)){{$Menu->action}}@else{{old('action')}}@endif" type="text" placeholder="Menu action" id="user-name" name="action">
                            @if($errors->has('action'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('action') }}</p>
                            @endif
                    </div>
                </div>
    </div>
 @endif   






                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">
                        {{ $button }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>