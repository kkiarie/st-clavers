 @extends('layouts.user_type.auth')

@section('content')
<div>






  @include('admin.fee-payment._form',
      ["button"=>"Save Record","label"=>"Fee Payment","id"=>$FeePayment->id,"labels"=>"New"])

</div>
@endsection