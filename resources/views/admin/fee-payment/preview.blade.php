@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <div class="row">
<div class="col-xs-6">
<h5 class="mb-0">
Fee Payment &raquo;


</h5>
</div>


<div class="col-xs-6">
<h5 class="mb-0">
Paid Amount {{number_format($FeePayment->amount,2)}}
</h5>


<a target="_blank" href="{{ URL::to("/fee-payment-pdf/$FeePayment->id") }}" >
<button class="btn btn-success mt-4"><i class="fas fa-file-pdf"></i> 
PDF </button>
</a>
</div>


</div>




                        </div>

                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
 
@endsection