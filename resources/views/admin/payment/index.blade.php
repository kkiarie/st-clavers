@extends('layouts.user_type.auth')

@section('content')
<?php



?>    
    <div class="container-fluid mt--7">
       <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Accounting Transactions</h3>
          {{-- <h4>Cashier Balance : {{number_format($Amount,2)}}</h4> --}}


           <a href="{{ URL::to("/payment/create") }}" >
            <button class="btn btn-success mt-4"><i class="fas fa-plus"></i> New Transaction </button>
          </a>
            </div>
            <!-- Light table -->
 
          @include('layouts.feedback')   
            <div class="table-responsive">
              @if(!$PaymentsList->isEmpty())   
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                  
                    
                    <th scope="col" class="sort" data-sort="status">
                    @sortablelink('source','Source')</th>
                    <th scope="col" class="sort" data-sort="status">
                    @sortablelink('destination','Destination')</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('cashier_amount','Amount')</th>

                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('created_at','Date')</th>
            
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('status','Status')</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach ($PaymentsList as $item)
                  <tr>
                    <td class="budget">
                      {{$loop->iteration}}.
                    </td>
                 
                     <td>
                     {{$item->sourceData->code}}
                    </td>
                    <td>
                     {{$item->destinationData->code}}
                    </td>
                    <td>
                     {{number_format($item->amount,2)}}
                    </td>
                    <td>
                     {{date("d/m/Y",strtotime($item->created_at))}}
                    </td>
                    <td>
                     @if($item->status==0)
                     <button class="btn btn-primary">Pending</button>
                     @else

                      <button class="btn btn-success">Complete</button>
                     @endif
                    </td>
                    <td>
       @if($item->status==0)
          <a href="{{ URL::to("/payment/".$item->id."/edit") }}" >
            <button class="btn btn-primary "><i class="far fa-eye"></i> View </button>
          </a>
@endif
        </td>
                  </tr>

                  @endforeach
                </tbody>
              </table>
<div class="card-footer py-4">
  <nav aria-label="...">
        <div class="pagination">
          {{ $PaymentsList->links() }}
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

