@extends('layouts.user_type.auth')

@section('content')
<?php 

  use App\Models\SetupConfig;
function MasterConfigItem($id=null)
{

  $title = SetupConfig::find($id);
  if(!$title)
  {
    return "Not Found";
  }
  else{

    return strtoupper($title->title);
  }
}



  use App\Models\User;
function userData($id=null)
{

  $title = User::find($id);
  if(!$title)
  {
    return "Not Found";
  }
  else{

    return ucwords($title->name);
  }
}


?>    
    <div class="container-fluid mt--7">
       <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
             
              <div class="row">
      


      <a target="_blank" href="{{ URL::to("/inventory-request/pdf/$InventoryRequest->id") }}" >
      <button class="btn btn-primary mt-4"><i class="far fa-file-pdf"></i> 
      Print Request 
    </button>
      </a>        
 

@if($InventoryRequest->status==0)
       <a href="{{ URL::to("/inventory-request/create/$InventoryRequest->id") }}" >
      <button class="btn btn-primary mt-4"><i class="far fa-edit"></i> Add Items </button>
      </a> 


@if($Counter>0)
&nbsp;
&nbsp;
       <a onclick="return confirm('Are you sure ?')" href="{{ URL::to("/inventory-request-submit/$InventoryRequest->id") }}" >
      <button class="btn btn-success mt-4"><i class="far fa-plus"></i> Submit </button>
      </a> 

@endif 





@endif 


@if($InventoryRequest->status==1)

&nbsp;
&nbsp;
       <a onclick="return confirm('Are you sure ?')" href="{{ URL::to("/inventory-request-approve/$InventoryRequest->id") }}" >
      <button class="btn btn-success mt-4"><i class="far fa-plus"></i> Approve </button>
      </a> 



@endif




@if($InventoryRequest->status==2)

&nbsp;
&nbsp;
       <a onclick="return confirm('Are you sure ?')"  href="{{ URL::to("/inventory-request-collection/$InventoryRequest->id") }}" >
      <button class="btn btn-success mt-4"><i class="far fa-plus"></i> Collect </button>
      </a> 



@endif





 
              </div>

              <div class="row">

              <div class="col-xs-12 col-sm-6">
                  <h3>Request Date :: {{date("d-m-Y H:i:s",strtotime($InventoryRequest->request_date))}}</h3>
                </div>

                    <div class="col-xs-12 col-sm-6">
                  <h3>Request by :: {{userData($InventoryRequest->requested_by)}}</h3>
                </div>

                  <div class="col-xs-12 col-sm-6">
                  <h3>Status : <?php 

                  if($InventoryRequest->status==0)
                  {
                    echo "Incomplete";
                  }
                   elseif($InventoryRequest->status==1)
                  {
                    echo "Submitted Pending Inventory Manager Approval";
                  }
                  elseif($InventoryRequest->status==2)
                  {
                    echo "Inventory Manager Approved Requested, pending collection";
                  }
                  else{

                    echo "Request complete, items collected ";
                  }

                ?></h3>
                </div>
             
               
@if($InventoryRequest->status==2)

                             <div class="col-xs-12 col-sm-6">
                  <h3>Approval Date :: {{date("d-m-Y H:i:s",strtotime($InventoryRequest->approval_date))}}</h3>
                </div>

                    <div class="col-xs-12 col-sm-6">
                  <h3>Approved by :: {{userData($InventoryRequest->approved_by)}}</h3>
                </div>
             
@endif





@if($InventoryRequest->status==4)

                             <div class="col-xs-12 col-sm-6">
                  <h3>Approval Date :: {{date("d-m-Y H:i:s",strtotime($InventoryRequest->approval_date))}}</h3>
                </div>

                    <div class="col-xs-12 col-sm-6">
                  <h3>Approved by :: {{userData($InventoryRequest->approved_by)}}</h3>
                </div>  


<div class="col-xs-12 col-sm-6">
<h3>Received Date :: {{date("d-m-Y H:i:s",strtotime($InventoryRequest->received_date))}}</h3>
</div>

<div class="col-xs-12 col-sm-6">
<h3>Received by :: {{userData($InventoryRequest->received_by)}}</h3>
</div>

@endif

 </div>
              <br/>
              <br/>

              

            </div>
            <!-- Light table -->
                        <div class="table-responsive">
              @if(!$InventoryRequestList->isEmpty())   
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('rfp_code','Inventory Item')</th>
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('amount','Quantity')</th>
                    <th>&nbsp;</th>
     
     
            
                    
                    
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach ($InventoryRequestList as $item)
                  <tr>
                    <td class="budget">
                      {{$loop->iteration}}.
                    </td>
                    <td>
                    {{$item->InventoryMasterData->title}}
                 
                    </td>
                      <td>
                      {{number_format($item->quantity)}}
                    </td>

                    <td>
                      @if($InventoryRequest->status==0):
                      <form action="{{action('App\Http\Controllers\Admin\InventoryRequestController@destroy', $item->id)}}" method="POST" role="form" style="margin:16px">
      {{ csrf_field() }}
      <input name="_method" type="hidden" value="DELETE">
      <button onclick="return confirm('Are you sure ?')" class="btn btn-danger mt-2"><i class="far fa-trash-alt"></i> Remove Item</button>
      </form>
      @endif
                    </td>
      
        
                  </tr>

                  @endforeach
                </tbody>
              </table>

          @else
            <p style="padding:10px">No records added at the moment.</p>
          @endif
            </div>
            
   
   <br>
   <br>
   <br>
 


            <!-- Card footer -->

          </div>
        </div>
      </div>

        
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush