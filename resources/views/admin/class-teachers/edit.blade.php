 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.class-teachers._form',
      ["button"=>"Save Record","label"=>"Update Class Teacher","id"=>$ClassTeacher->id,"labels"=>"New"])

</div>
@endsection