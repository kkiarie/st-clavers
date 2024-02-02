<?php





$clients_list="";
foreach($PaymentModes as $item):
if(isset($FeePayment)&&$FeePayment->payment_mode_id==$item->id):
    
$clients_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('payment_mode_id')==$item->id):
$clients_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$clients_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$clients_list.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>

                 <h5 class="mb-0">Student Name : {{$Student->name}}</h5>
                 <h5 class="mb-0">Admission : {{$Student->admission_no}}</h5>

                 <hr/>
               <h5 class="mb-0">  Fee Structure : {{number_format($FeeStructuresAmount,2)}}
               </h5>


                <h5 class="mb-0">  Fee Paid : {{number_format($FeeStructuresAmountPaid,2)}}
               </h5>

               <h5 class="mb-0">  Balance : 
                {{number_format($FeeStructuresAmount-$FeeStructuresAmountPaid,2)}}
               </h5>
            </div>
            <div class="card-body pt-4 p-3">

                  @if(isset($FeePayment))<br/>

        
          
          <a href="{{ URL::to("/fee-payment/complete/".$FeePayment->id) }}" onclick="return confirm('Are your sure?')">
            <button class="btn btn-success"><i class="fa fa-file-pdf"></i> Complete</button>
          </a>


    <a href="{{ URL::to("/fee-payment-mpesa/".$FeePayment->id) }}" >
            <button class="btn btn-primary"><i class="fa fa-file-pdf"></i> MPesa</button>
          </a>
        

         @endif

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('fee-payment.store')}}" enctype="multipart/form-data">
<input type="hidden" name="student_id" value="{{$Student->id}}">    
<input type="hidden" name="fee_structure_id" value="{{$fee_structure_id}}">    
@else
<form action="{{action('App\Http\Controllers\Admin\FeePaymentController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif 


{{ csrf_field() }}




                <div class="row">




<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Fee Amount') }}</label>
                    <div class="@if($errors->has('amount'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($FeePayment)){{$FeePayment->amount}}@else{{old('amount')}}@endif" type="text" placeholder="Fee amount" id="user-amount" name="amount">
                            @if($errors->has('amount'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('amount') }}</p>
                            @endif
                    </div>
                </div>
    </div>


    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Phone Number') }}</label>
                    <div class="@if($errors->has('phone_number'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($FeePayment)){{$FeePayment->phone_number}}@else{{old('phone_number')}}@endif" type="text" placeholder="Fee phone_number" id="user-phone_number" name="phone_number">
                            @if($errors->has('phone_number'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('phone_number') }}</p>
                            @endif
                    </div>
                </div>
    </div>
  

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Payment Mode') }}</label>
                    <div class="@if($errors->has('payment_mode_id'))border border-danger rounded-3 @endif">
                <select  name="payment_mode_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('payment_mode_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$clients_list!!}
           </select>
                            @if($errors->has('payment_mode_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('payment_mode_id') }}</p>
                            @endif
                    </div>
                </div>
    </div>    

      <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Receipt Date') }}</label>
                    <div class="@if($errors->has('gl_date'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($FeePayment)){{$FeePayment->gl_date}}@else{{old('gl_date')}}@endif" type="text" placeholder="Receipt Date" id="input-from_date" name="gl_date">
                            @if($errors->has('gl_date'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('gl_date') }}</p>
                            @endif
                    </div>
                </div>
    </div>




        <div class="col-xs-12 col-md-12">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Description') }}</label>
                    <div class="@if($errors->has('description'))border border-danger rounded-3 @endif">
                        <textarea placeholder="narration" class="form-control" name="description">@if(isset($FeePayment)){{$FeePayment->description}}@else{{old('description')}}@endif</textarea>



                            @if($errors->has('description'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('description') }}</p>
                            @endif
                    </div>
                </div>
    </div>


                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">
                        {{ $button }}</button>
                    </div>
                </form>

            </div>

        </div>



    </div>




