 @extends('layouts.user_type.auth')

@section('content')
<div>
  @include('admin.diary._form',
      ["button"=>"Save Record","label"=>"Diary","id"=>$Diary->id,"labels"=>"New"])

</div>
@endsection