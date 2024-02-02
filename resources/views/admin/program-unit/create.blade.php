 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.program-unit._form',
      ["button"=>"Save Record","label"=>"Program Unit","id"=>0,"labels"=>"New"])

</div>
@endsection