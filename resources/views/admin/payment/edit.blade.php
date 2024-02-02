@extends('layouts.user_type.auth')

@section('content')
    
    <div class="container-fluid mt--7">
       <div class="row">
        @include('admin.payment._form',
      ["button"=>"Update Record","label"=>"Accounting Transactions","id"=>$Payment->id,"labels"=>"Edit"])
      </div>

    </div>
@endsection

