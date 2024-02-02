 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.parent._form',
      ["button"=>"Save Record","label"=>"Parent","id"=>$Parent->id,"labels"=>"New"])

</div>
@endsection