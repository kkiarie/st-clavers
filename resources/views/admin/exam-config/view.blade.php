@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{$ExamConfiguration->title}}</h5>

                            <h6>
                                Exams Total : {{$ExamTotal}}
                            </h6>

                    
     
          <a href="{{ URL::to("/exams-configuration/create/$ExamConfiguration->id") }}" >
            <button class="btn btn-success mt-4"><i class="fas fa-plus"></i> New Item </button>
          </a>
 
       


                        </div>

                    </div>
                </div>

@if(!$ExamConfigurationList->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('title','Name')
                                       
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('created_at','Marks')
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($ExamConfigurationList as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>
                                
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->ExamItem->title}}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->marks}}</p>
                                    </td>
                                   
                                    <td class="text-center">
                            
<form action="{{action('App\Http\Controllers\Admin\ExamConfigurationController@destroy', $item->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button class="btn btn-danger mt-2" onclick="return confirm('Are you sure ?')"><i class="far fa-trash-alt"></i> Delete </button>
        </form>                      
                                    </td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>

@else

<p style="padding:20px">
    No Configuration have been added.
</p>


@endif

            </div>
        </div>
    </div>
</div>
 
@endsection