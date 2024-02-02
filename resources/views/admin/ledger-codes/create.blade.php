 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.ledger-codes._form',
      ["button"=>"Save Record","label"=>"Ledger Code","id"=>0,"labels"=>"New"])

</div>
@endsection