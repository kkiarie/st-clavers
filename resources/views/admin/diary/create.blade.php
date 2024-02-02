 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.diary._form',
      ["button"=>"Save Record","label"=>"Diary","id"=>0,"labels"=>"New"])

</div>
@endsection