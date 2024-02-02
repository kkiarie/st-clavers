 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.setting._form',
      ["button"=>"Save Record","label"=>"Settings","id"=>1,"labels"=>"New"])

</div>
@endsection