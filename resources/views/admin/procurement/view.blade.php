@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">RFQ Details</h5>

            <a href="{{ URL::to("/procurement") }}" >
            <button class="btn btn-primary mt-4">&raquo; Back</button>
          </a>
     

 

  <a target="_blank" href="{{ URL::to("/procurement/pdf/$Procurement->id") }}" >
      <button class="btn btn-primary mt-4"><i class="far fa-file-pdf"></i> Print RFQ{{$Procurement->name}}</button>
      </a> 

      @if($Procurement->status==0 && $ProcurementCount>0)
           <a onclick="return confirm('Are you sure ?')"  href="{{ URL::to("/procurement/submission/$Procurement->id") }}" >
      <button class="btn btn-success mt-4"><i class="fa-solid fa-check"></i> Submit</button>
      </a> 
@endif 
      


@if($Procurement->status==0)
       <a href="{{ URL::to("/procurement/create/$Procurement->id") }}" >
      <button class="btn btn-primary mt-4"><i class="far fa-edit"></i> Add Items {{$Procurement->name}}</button>
      </a> 

@endif 


@if($Procurement->status==1)
       <a href="{{ URL::to("/procurement/complete/$Procurement->id") }}" >
      <button class="btn btn-success mt-4"><i class="far fa-edit"></i> Approve Request</button>
      </a> 



    <a href="{{ URL::to("/procurement/cancel/$Procurement->id") }}" >
      <button class="btn btn-danger mt-4"><i class="far fa-edit"></i> Cancel Request</button>
      </a> 

@endif 




@if($Procurement->status==12)


&nbsp;&nbsp;


       <a onclick="return confirm('Are you sure ?')" href="{{ URL::to("/internalPay/$Procurement->id") }}" >
      <button class="btn btn-success mt-4"><i class="far fa-edit"></i> Confirm</button>
      </a> 

   


@endif 


                        </div>
                          <div class="row">
                            <div class="col-xl-12">
                <h4>RFQ Status: 

           @if($Procurement->status==0)

                  Incomplete
                  @elseif($Procurement->status==1)

                  Pending Cashier Manager
                  @elseif($Procurement->status==5)
                  Procurement Request Canceled
                  @elseif($Procurement->status==11)
                  procurement-collection-funds
                  @elseif($Procurement->status==12)
                  Pending Purchase Confirmation by Cashier
                  @elseif($Procurement->status==2)
                  Pending Cashier Allocation
                  @else
                  Complete
                  @endif
                </h4>
               </div>
                        </div>
                      

                    </div>
                </div>

@if(!$ProcurementsList->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
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


                                @foreach ($ProcurementsList as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>
                                
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->InventoryMasterData->title}}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->created_at}}</p>
                                    </td>
                                   
                                    <td class="text-center">
    @if($Procurement->status==0)                      
<form action="{{action('App\Http\Controllers\Admin\ProcurementController@destroy', $item->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button onclick="return confirm('Are you sure ?')" class="btn btn-danger mt-2"><i class="far fa-trash-alt"></i> Delete </button>
        </form>  
@else
&nbsp;
        @endif                    
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