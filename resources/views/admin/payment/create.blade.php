@extends('layouts.user_type.auth')

@section('content')
    
    <div class="container-fluid mt--7">
       <div class="row">
        @include('admin.payment._form',
      ["button"=>"Save Record","label"=>"Accounting Transactions","id"=>0,"labels"=>"Edit"])
      </div>

       
    </div>
@endsection
