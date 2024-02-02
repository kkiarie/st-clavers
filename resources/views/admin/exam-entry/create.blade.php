 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.exam-entry._form',
      ["button"=>"Save Record","label"=>"Marks Entry","id"=>0,"labels"=>"New"])

</div>
@endsection