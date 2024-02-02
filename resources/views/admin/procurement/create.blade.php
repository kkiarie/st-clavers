
 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.procurement._form',
      ["button"=>"Save Record","label"=>"Procurement Item","id"=>0,"labels"=>"New"])

</div>
@endsection