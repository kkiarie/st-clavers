 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.time-table._form',
      ["button"=>"Save Record","label"=>"Time Table","id"=>0,"labels"=>"New"])

</div>
@endsection