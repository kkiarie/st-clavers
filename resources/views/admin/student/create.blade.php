 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.student._form',
      ["button"=>"Save Record","label"=>"Student","id"=>0,"labels"=>"New"])

</div>
@endsection