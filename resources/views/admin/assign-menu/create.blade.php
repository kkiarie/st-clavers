 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.assign-menu._form',
      ["button"=>"Save Record","label"=>"Assign Roles","id"=>0,"labels"=>"New"])

</div>
@endsection