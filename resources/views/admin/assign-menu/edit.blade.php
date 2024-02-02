 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.assign-menu._form',
      ["button"=>"Save Record","label"=>"Setup","id"=>$Setup->id,"labels"=>"New"])

</div>
@endsection