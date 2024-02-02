 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.exam-config._form',
      ["button"=>"Save Record","label"=>"Exam Configuration","id"=>0,"labels"=>"New"])

</div>
@endsection