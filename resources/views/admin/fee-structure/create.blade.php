 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.fee-structure._form',
      ["button"=>"Save Record","label"=>"Fee Structure","id"=>0,"labels"=>"New"])

</div>
@endsection