 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.inventory._form',
      ["button"=>"Save Record","label"=>"Inventory","id"=>$Inventory->id,"labels"=>"New"])

</div>
@endsection