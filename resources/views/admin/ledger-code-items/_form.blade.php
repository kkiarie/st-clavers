    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('ledger-code-items.store')}}" enctype="multipart/form-data">
    <input type="hidden" name="ledger_code_id" value="{{Request::segment(3)}}" />
@else
<form action="{{action('App\Http\Controllers\Admin\LedgerCodeItemController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">



<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Title') }}</label>
                    <div class="@if($errors->has('title'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($SetupConfig)){{$SetupConfig->title}}@else{{old('title')}}@endif" type="text" placeholder="Title" id="user-name" name="title">
                            @if($errors->has('title'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('title') }}</p>
                            @endif
                    </div>
                </div>
    </div>

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('code') }}</label>
                    <div class="@if($errors->has('code'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($SetupConfig)){{$SetupConfig->code}}@else{{old('code')}}@endif" type="text" placeholder="code" id="code" name="code">
                            @if($errors->has('code'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('code') }}</p>
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