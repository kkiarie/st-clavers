







        @extends('layouts.user_type.auth')

        @section('content')
        <div>

        <div class="container-fluid py-4">
        <div class="card">
        <div class="card-header pb-0 px-3">
        <h3 class="mb-0">Profile </h3>
        </div>
        @include('layouts.feedback')


        <div class="row">


        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="card-body pt-4 p-3">


        <form method="post" 
        action="{{action('App\Http\Controllers\ProfileController@password')}}" 

        autocomplete="off">
   {{ csrf_field() }}
     
        <input type="hidden" name="status" value="0">
        <h6 class="heading-small text-muted mb-4">{{ __('Password') }}</h6>

        @if (session('password_status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('password_status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif

        <div class="pl-lg-4">
        <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-current-password">{{ __('Current Password') }}</label>
        <input type="password" name="old_password" id="input-current-password" class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>

        @if ($errors->has('old_password'))
        <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('old_password') }}</strong>
        </span>
        @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-password">{{ __('New Password') }}</label>
        <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>

        @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
        </div>
        <div class="form-group">
        <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
        <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirm New Password') }}" value="" required>
        </div>

        <div class="text-center">
        <button type="submit" class="btn btn-success mt-4">{{ __('Change password') }}</button>
        </div>
        </div>
        </form>


        </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="display: none;">
        <div class="card-body pt-4 p-3">


        <form method="post" action="{{ route('profile.update') }}" autocomplete="off">
        @csrf
        @method('put')

        <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>

        @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif


        <div class="pl-lg-4">
        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
        <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" required autofocus>

        @if ($errors->has('name'))
        <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
        <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required>

        @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
        </div>

        <div class="text-center">
        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
        </div>
        </div>
        </form>


        </div>
        </div>
        </div>            



        </div>
        </div>



        </div>
        @endsection