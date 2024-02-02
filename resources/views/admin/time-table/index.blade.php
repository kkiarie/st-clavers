@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Time Table</h5>
                        </div>
                       
                    </div>
                </div>
                @include('layouts.feedback')
           
@if(!$ClassList->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('title',' Grade')
                                       
                                    </th>

                                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('subject_id','Terms')
                                       
                                    </th>
                                
                                    
                               
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($ClassList as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>
                                
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->title}}</p>
                                    </td>

                        


                               @foreach($Terms as $term)
                                   
                                    <td class="text-center">
                                        <a href="{{ URL::to("/time-table/create/".$item->id."/".$term->id) }}" >
            <button class="btn btn-primary "><i class="far fa-eye"></i> {{$term->title}} </button>
          </a>
          @endforeach
                                       
                                    </td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>
 <div class="pagination">
          {{ $ClassList->links() }}
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