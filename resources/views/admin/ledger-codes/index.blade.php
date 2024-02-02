@extends('layouts.user_type.auth')

@section('content')
<?php


$clients_list="";
foreach($LedgerCodesList as $item):
$clients_list.="<option value='".$item->id."'>".$item->title ." - ".$item->code."</option>"; 
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
                            <h5 class="mb-0">All Ledger Codes</h5>
                        </div>
                        <a href="{{ URL::to("/ledger-codes/create") }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Ledger Code</a>
                    </div>
                </div>
                @include('layouts.feedback')
            <div style="padding:10px">
                
              <form action="{{action('App\Http\Controllers\Admin\LedgerCodeController@ledgerQuery')}}" method="POST">
                {{ csrf_field() }}
                <div class="row">


                  <div class="col-xl-4">
                       <div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-client_id">{{ __('Ledger Codes') }}</label>
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
@if(!$LedgerCodes->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('title','Ledger Name')
                                       
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('code','Ledger Code')
                                       
                                    </th>
                                    
                          
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($LedgerCodes as $item)
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
                    <a href="{{ URL::to("/ledger-codes/".$item->id) }}" >
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
          {{ $LedgerCodes->links() }}
          </div>
@else

<p style="padding:20px">
    No Ledger Code(s) added.
</p>


@endif

            </div>
        </div>
    </div>
</div>
 
@endsection