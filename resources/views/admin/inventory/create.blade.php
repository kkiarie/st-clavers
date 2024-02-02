 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.inventory._form',
      ["button"=>"Save Record","label"=>"Inventory Item","id"=>0,"labels"=>"New"])

</div>
@endsection