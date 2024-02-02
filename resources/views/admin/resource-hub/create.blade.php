 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.resource-hub._form',
      ["button"=>"Save Record","label"=>"Resource Hub Material","id"=>0,"labels"=>"New"])

</div>
@endsection