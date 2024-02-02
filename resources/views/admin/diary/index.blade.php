@extends('layouts.user_type.auth')

@section('content')
<?php


$clients_list="";
foreach($DiaryLists as $item):
$clients_list.="<option value='".$item->id."'>". $item->title ." "
.$item->ClassData->title." - "
.$item->StreamData->title." - "
.$item->SubjectData->title."
</option>"; 
endforeach; 
$clients_list.="";


?>
<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Diary</h5>
                        </div>
                        <a href="{{ URL::to("/diary/create") }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Diary Entry</a>
                    </div>
                </div>
                @include('layouts.feedback')
            <div style="padding:10px">
                
              <form action="{{action('App\Http\Controllers\Admin\DiaryController@diaryQuery')}}" method="POST">
                {{ csrf_field() }}
                <div class="row">


                  <div class="col-xl-4">
                       <div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-client_id">{{ __('Diary Entry') }}</label>
            <br/>
               <select  name="value" 
                id="select-item" class=" form-control-alternative{{ $errors->has('client_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$clients_list!!}
           </select>


    </div>
                </div>
<div class="col-xl-12">
 <button class="btn btn-primary "><i class="fa-solid fa-magnifying-glass"></i> Search</button>
</div>







              </form>
              
              </div>
@if(!$DiaryList->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('title',' Title')
                                       
                                    </th>

                                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('subject_id','Group')
                                       
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('created_at','Date')
                                       
                                    </th>
                                    
                               
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($DiaryList as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>
                                
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->title}}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">

                                           {{$item->ClassData->title}} :: 
                                        {{$item->StreamData->title}} ::
                                        {{$item->SubjectData->title}}

                                        </p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->created_at}}</p>
                                    </td>
                        


                               
                                   
                                    <td class="text-center">
                                        <a href="{{ URL::to("/diary/".$item->id) }}" >
            <button class="btn btn-primary "><i class="far fa-eye"></i> View </button>
          </a>
                                       
                                    </td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>
 <div class="pagination">
          {{ $DiaryList->links() }}
          </div>
@else

<p style="padding:20px">
    No Notification(s) added.
</p>


@endif

            </div>
        </div>
    </div>
</div>
 
@endsection