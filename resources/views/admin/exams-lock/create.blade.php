 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.exams-lock._form',
      ["button"=>"Save Record","label"=>"Exam Lock","id"=>0,"labels"=>"New"])

</div>
@endsection