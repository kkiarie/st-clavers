 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.subject-teachers._form',
      ["button"=>"Save Record","label"=>"Update Subject Teacher","id"=>$SubjectTeacher->id,"labels"=>"New"])

</div>
@endsection