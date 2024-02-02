 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.menu._form',
      ["button"=>"Save Record","label"=>"Menu","id"=>0,"labels"=>"New"])

</div>
@endsection