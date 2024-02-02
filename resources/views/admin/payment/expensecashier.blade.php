@extends('layouts.app')

@section('content')
@include('layouts.headers.cards2')
<?php



?>    
    <div class="container-fluid mt--7">
       <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Expense - Cashier Allocated Funds</h3>
        
            </div>
            <!-- Light table -->
 
            
            <div class="table-responsive">
              @if(!$ExpenseList->isEmpty())   
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                  
                    
                    <th scope="col" class="sort" data-sort="status">
                    @sortablelink('ledger_code_id','Ledger')</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('cashier_amount','Amount')</th>

      <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('created_at','Date')</th>
            
                    
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach ($ExpenseList as $item)
                  <tr>
                    <td class="budget">
                      {{$loop->iteration}}.
                    </td>
                 
                     <td>
                   
                    </td>
                    <td>
                     {{number_format($item->amount,2)}}
                    </td>
                    <td>
                     {{date("d/m/Y",strtotime($item->created_at))}}
                    </td>
                    <td>
      
          <a href="{{ URL::to("/expense-internal-pay/".$item->id) }}" >
            <button class="btn btn-primary "><i class="far fa-eye"></i> View </button>
          </a>
      
                  </tr>

                  @endforeach
                </tbody>
              </table>
<div class="card-footer py-4">
  <nav aria-label="...">
        <div class="pagination">
          {{ $ExpenseList->links() }}
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