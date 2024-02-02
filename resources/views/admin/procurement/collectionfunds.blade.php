@extends('layouts.app')

@section('content')
@include('layouts.headers.cards2')
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


?>    
    <div class="container-fluid mt--7">
       <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Procurement Request - Collection Funds</h3>
     
            </div>
            <!-- Light table -->

            
            <div class="table-responsive">
              @if(!$Procurements->isEmpty())   
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('rfp_code','RFP Code Name')</th>
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('quantity','RFP Quantity')</th>
                <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('status','Status')</th>
            
                    
                    
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach ($Procurements as $item)
                  <tr>
                    <td class="budget">
                      {{$loop->iteration}}.
                    </td>
                    <td>
                  <a style="font-weight: bold;" href="{{ URL::to("/procurement/".$item->id) }}" >  {{$item->rfp_code}}
                  </a>
                    </td>
                      <td>
                      {{number_format($item->quantity,2)}}
                    </td>
      
        <td>
                  @if($item->status==0)

                  Incomplete
                  @elseif($item->status==1)

                  Pending Cashier Manager
                  @elseif($item->status==5)
                  Procurement Request Canceled

                  @elseif($item->status==11)
                  Procurement Fund Allocated 
                  @else

                  @endif
                    </td>

                    <td>
                  <a href="{{ URL::to("/procurement-collection-fund/".$item->id) }}" onclick="return confirm('Are you sure ?')">  
                    <button class="btn btn-primary">Collect</button>
                  </a>
                    </td>
                  </tr>

                  @endforeach
                </tbody>
              </table>
<div class="card-footer py-4">
  <nav aria-label="...">
        <div class="pagination">
          {{ $Procurements->links() }}
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

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush