@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <a href="{{ URL::to("/fee-payment/") }}">
                            <button class="btn btn-success">
                                &raquo; Back
                            </button>
                        </a>
                            
                            <h5 class="mb-0"><i class="fa-solid fa-clock-rotate-left"></i> Fee Payment History</h5>

                             <h5 class="mb-0">Student Name : {{$Student->name}}</h5>
                             @if($Student->program_id>2)
                             <h5 class="mb-0"> {{$Student->ProgramData->name}}</h5>
                             @endif


                             <h5 class="mb-0">Admission No. : {{$Student->admission_no}}</h5>
                             <h5 class="mb-0">Payable Amount : {{number_format($BalanceAmount,2)}}</h5>
                             <h5 class="mb-0">Paid : {{number_format($PaidAmount,2)}}</h5>
                             <h5 class="mb-0">Balance : 
                             {{number_format($BalanceAmount-$PaidAmount,2)}}</h5>
                        </div>
                       
                    </div>
                </div>
                @include('layouts.feedback')
         




              @if(!$FeePayments->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','#')
                                        
                                    </th>

                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('ref','Receipt No.')
                                       
                                    </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('gl_date','Receipt Date.')
                                       
                                    </th>

                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('amount','Amount')
                                       
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($FeePayments as $item)
                                <tr>
<td class="ps-4">
<p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
</td>

<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{$item->ref}}</p>
</td>

<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{$item->gl_date}}</p>
</td>

<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{number_format($item->amount,2)}}</p>
</td>

<td>
<a target="_blank" href="{{ URL::to("/fee-payment-pdf/".$item->id) }}" >
<button class="btn btn-primary "><i class="far fa-file-pdf"></i> PDF </button>
</a>
    </td>
                          

                                        


                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>

@else

<p style="padding:20px">
   No Fee Payments have been done
</p>


@endif


            </div>
        </div>
    </div>
</div>
 
@endsection