@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Setups</h5>
                        </div>
                        <a href="{{ URL::to("/setup/create") }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Setup</a>
                    </div>
                </div>
@include('layouts.feedback')
<div style="padding:10px">
   <div class="row">
        <div class="col-xl-4">&nbsp;</div>
   </div>
</div>
@if(!$Setups->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('title','Name')
                                       
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('created_at','Creation Date')
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($Setups as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>
                                
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->title}}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->created_at}}</p>
                                    </td>
                                   
                                    <td class="text-center">
                                        <a href="{{ URL::to("/setup/".$item->id) }}" >
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
          {{ $Setups->links() }}
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