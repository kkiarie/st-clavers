@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{$LedgerCode->title}}</h5>

                     <a href="{{ URL::to("/ledger-codes/$LedgerCode->id/edit") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-edit"></i> Edit 
                {{$LedgerCode->title}}</button>
          </a>
     
          <a href="{{ URL::to("/ledger-code-items/create/$LedgerCode->id") }}" >
            <button class="btn btn-success mt-4"><i class="fas fa-plus"></i> New 
                {{$LedgerCode->title}} Item </button>
          </a>
 
          <form action="{{action('App\Http\Controllers\Admin\LedgerCodeController@destroy', $LedgerCode->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button class="btn btn-danger mt-2"><i class="far fa-trash-alt"></i> Delete {{$LedgerCode->title}}</button>
        </form>


                        </div>

                    </div>
                </div>
@include('layouts.feedback')
<div style="padding:10px">
   <div class="row">
        <div class="col-xl-4">&nbsp;</div>
   </div>
</div>
@if(!$LedgerCodeItems->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('title','Name')
                                       
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('created_at','Ledger Code')
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($LedgerCodeItems as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>
                                
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->title}}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->code}}</p>
                                    </td>
                                   
                                    <td class="text-center">
                            <a href="{{ URL::to("/ledger-code-items/".$item->id."/edit") }}" >
            <button class="btn btn-primary "><i class="far fa-eye"></i> View </button>
          </a>
<form action="{{action('App\Http\Controllers\Admin\LedgerCodeItemController@destroy', $item->id)}}" method="POST" role="form">
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
          {{ $LedgerCodeItems->links() }}
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