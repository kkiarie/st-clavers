 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.teacher._form',
      ["button"=>"Save Record","label"=>"Teacher","id"=>$Teacher->id,"labels"=>"New"])

</div>
@endsection