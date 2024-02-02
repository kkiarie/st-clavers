 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.notifications._form',
      ["button"=>"Save Record","label"=>"Notification","id"=>0,"labels"=>"New"])

</div>
@endsection