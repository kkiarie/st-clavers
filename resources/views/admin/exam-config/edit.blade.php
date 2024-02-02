 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.grades._form',
      ["button"=>"Save Record","label"=>"Grade","id"=>$Grade->id,"labels"=>"New"])

</div>
@endsection