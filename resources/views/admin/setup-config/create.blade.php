 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.setup-config._form',
      ["button"=>"Save Record","label"=>"Setup Config","id"=>0,"labels"=>"New"])

</div>
@endsection