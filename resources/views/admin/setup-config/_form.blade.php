    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{$label}} </h6>
            </div>
            <div class="card-body pt-4 p-3">


@if($id==null)

<form method="post" action="{{ route('setup-config.store')}}" autocomplete="off">
       <input type="hidden" name="setup_id" value="{{Request::segment(3)}}" />
@else
<form action="{{action('App\Http\Controllers\Admin\SetupConfigController@update', $id)}}" method="POST">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">
<div class="col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Title') }}</label>
                    <div class="@if($errors->has('title'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($SetupConfig)){{$SetupConfig->title}}@else{{old('title')}}@endif" type="text" placeholder=" Title" id="user-name" name="title">
                            @if($errors->has('title'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('title') }}</p>
                            @endif
                    </div>
                </div>
    </div>




<div class="col-md-6">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __(' Description') }}</label>
                    <div class="@if($errors->has('description'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($SetupConfig)){{$SetupConfig->description}}@else{{old('description')}}@endif" type="text" placeholder="Description" id="user-name" name="description">
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