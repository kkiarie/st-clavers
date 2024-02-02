 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.grades._form',
      ["button"=>"Save Record","label"=>"Grades","id"=>0,"labels"=>"New"])

</div>
@endsection