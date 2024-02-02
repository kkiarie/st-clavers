 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.subject-teachers._form',
      ["button"=>"Save Record","label"=>"Subject Teacher","id"=>0,"labels"=>"New"])

</div>
@endsection