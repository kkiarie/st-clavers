 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.teacher._form',
      ["button"=>"Save Record","label"=>"Teacher","id"=>0,"labels"=>"New"])

</div>
@endsection