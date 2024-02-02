 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.setup-config._form',
      ["button"=>"Save Record","label"=>"Setup","id"=>$SetupConfig->id,"labels"=>"New"])

</div>
@endsection