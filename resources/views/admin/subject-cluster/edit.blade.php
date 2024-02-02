 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.subject-cluster._form',
      ["button"=>"Save Record","label"=>"Subeject Cluster ","id"=>$SubjectCluster->id,"labels"=>"New"])

</div>
@endsection