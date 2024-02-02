 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.fee-structure._form',
      ["button"=>"Save Record","label"=>"FeeStructure","id"=>$FeeStructure->id,"labels"=>"New"])

</div>
@endsection