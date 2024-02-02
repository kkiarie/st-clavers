@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <h5 class="mb-0">Program Name : {{$Program->name}}</h5>
                                </div>

                                 <div class="col-xs-6">
                                    <h5 class="mb-0">Program cost:: {{number_format($Program->cost,2)}}</h5>
                                </div>

                                 <div class="col-xs-6">
                                    <h5 class="mb-0">Program Period:: {{$Program->period}}</h5>
                                </div>
                            </div>
                     <a href="{{ URL::to("/program/$Program->id/edit") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-edit"></i> Edit {{$Program->title}}</button>
          </a>
     
          <a href="{{ URL::to("/program-subject/create/$Program->id") }}" >
            <button class="btn btn-success mt-4"><i class="fas fa-plus"></i> New Program Unit </button>
          </a>
 
          <form action="{{action('App\Http\Controllers\Admin\ProgramController@destroy', $Program->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button onclick="return confirm('Are your sure ?') " class="btn btn-danger mt-2"><i class="far fa-trash-alt"></i> Delete {{$Program->title}}</button>
        </form>


                        </div>

                    </div>
                </div>

@if(!$ProgramSubjects->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('program_unit_id','Program Unit')
                                       
                                    </th>

                                     <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('program_stage_id','Program Stage')
                                       
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('created_at','Creation Date')
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($ProgramSubjects as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->ProgamUnitData->title}}</p>
                                    </td>
                                
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->ProgramStageData->title}}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->created_at}}</p>
                                    </td>
                                   
                                    <td class="text-center">
                            <a href="{{ URL::to("/program-subject/".$item->id."/edit") }}" >
            <button class="btn btn-primary "><i class="far fa-eye"></i> View </button>
          </a>
<form action="{{action('App\Http\Controllers\Admin\ProgramSubjectController@destroy', $item->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button class="btn btn-danger mt-2"><i class="far fa-trash-alt"></i> Delete </button>
        </form>                      
                                    </td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>
 <div class="pagination">
          {{ $ProgramSubjects->links() }}
          </div>
@else

<p style="padding:20px">
    No items have been added.
</p>


@endif

            </div>
        </div>
    </div>
</div>
 
@endsection