

 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.ledger-code-items._form',
      ["button"=>"Save Record","label"=>"Ledger Code Items","id"=>0,"labels"=>"New"])

</div>
@endsection