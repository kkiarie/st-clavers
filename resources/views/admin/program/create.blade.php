 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.program._form',
      ["button"=>"Save Record","label"=>"Program","id"=>0,"labels"=>"New"])

</div>
@endsection