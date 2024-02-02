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

use App\Models\InventoryRequest;



function sumStock($id=null)
{
  $data=InventoryRequest::where("parent_id",$id)
  ->where("status","!=",3)
  ->sum("quantity");

  if($data)
  {
    return $data;
  }
  else{

    return 0;
  }

}



?>    
    <div class="container-fluid mt--7">
       <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Request Inventory</h3>
              <a href="{{ URL::to("/inventory-request/create/0") }}" >
            <button class="btn btn-success mt-4"><i class="fas fa-plus"></i> Make Request </button>
          </a>
            </div>
           
            
            <div class="table-responsive">
              @if(!$InventoryRequests->isEmpty())   
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('rfp_code','Request Date')</th>
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('quantity','Request Quantity')</th>
                <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('status','Status')</th>
            
                    
                    
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach ($InventoryRequests as $item)
                  <tr>
                    <td class="budget">
                      {{$loop->iteration}}.
                    </td>
                    <td>
                  <a style="font-weight: bold;" href="{{ URL::to("/inventory-request/".$item->id) }}" > 
                    {{date("d-m-Y H:i:s", strtotime($item->created_at))}}
                  </a>
                    </td>
                      <td>
                      {{sumStock($item->id)}}
                    </td>
      
        <td>
                     <?php 

                  if($item->status==0)
                  {
                    echo "Incomplete";
                  }
                   elseif($item->status==1)
                  {
                    echo "Submitted Pending Inventory Manager Approval";
                  }
                  elseif($item->status==2)
                  {
                    echo "Inventory Manager Approved Requested, pending collection";
                  }
                  else{

                    echo "Request complete, items collected ";
                  }

                ?>
                    </td>
                  </tr>

                  @endforeach
                </tbody>
              </table>
<div class="card-footer py-4">
  <nav aria-label="...">
        <div class="pagination">
          {{ $InventoryRequests->links() }}
          </div>
        </nav>
        </div>
          @else
            <p style="padding:10px">No records added at the moment.</p>
          @endif
            </div>
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