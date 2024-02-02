 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.assign-student-class._form',
      ["button"=>"Save Record","label"=>"Assign ","id"=>0,"labels"=>"New"])

</div>
@endsection