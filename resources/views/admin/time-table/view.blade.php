@extends('layouts.user_type.auth')

@section('content')

<div style="padding:20px">

    <div class="row" >
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <div class="row">
                                <div class="col-xs-6">

<a href="{{ URL::to("/diary/") }}" >
<button class="btn btn-primary mt-4">&raquo; BACK </button>
</a>
                                    <h5 class="mb-0">Diary Title : {{$Diary->title}}</h5>
                                </div>


                                <div class="col-xs-6">
                                    <h5 class="mb-0">
                                        {{$Diary->ClassData->title}} :: 
                                        {{$Diary->StreamData->title}} ::
                                        {{$Diary->SubjectData->title}}
                                    </h5>
                                </div>
                                 <div class="col-xs-12">
                                    <h5 class="mb-0">Diary Description : {{$Diary->description}}</h5>
                                </div>

                            
                            </div>

@if($Diary->status==0)

        <a href="{{ URL::to("/diary/$Diary->id/edit") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-edit"></i> Edit </button>
          </a>
     
       
 
          <form action="{{action('App\Http\Controllers\Admin\DiaryController@destroy', $Diary->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button onclick="return confirm('Are your sure ?') " class="btn btn-danger mt-2"><i class="far fa-trash-alt"></i> Delete </button>
        </form>

@endif
                        </div>

                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
 
@endsection