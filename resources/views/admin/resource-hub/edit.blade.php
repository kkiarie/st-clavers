 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.resource-hub._form',
      ["button"=>"Save Record","label"=>"Resource Hub Material","id"=>$ResourceHubMaterial->id,"labels"=>"New"])

</div>
@endsection