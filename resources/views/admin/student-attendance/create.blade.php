 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.fee-payment._form',
      ["button"=>"Save Record","label"=>"Fee Payment","id"=>0,"labels"=>"New"])

</div>
@endsection