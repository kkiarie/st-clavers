 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.ledger-codes._form',
      ["button"=>"Save Record","label"=>"Ledger Code","id"=>$LedgerCode->id,"labels"=>"New"])

</div>
@endsection