 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.subject-cluster._form',
      ["button"=>"Save Record","label"=>"Subject Clusters","id"=>0,"labels"=>"New"])

</div>
@endsection