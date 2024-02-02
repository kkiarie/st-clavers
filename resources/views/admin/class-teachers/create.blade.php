 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.class-teachers._form',
      ["button"=>"Save Record","label"=>"Class Teacher","id"=>0,"labels"=>"New"])

</div>
@endsection