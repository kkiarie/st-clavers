
  <?php 


$setup_list="";
foreach($LedgerCodeItemList as $item):
if(isset($Payment)&&$Payment->source==$item->id):
    
$setup_list.="<option selected value='".$item->id."'>$item->title - $item->code </option>"; 
elseif(old('source')==$item->id):
$setup_list.="<option selected value='".$item->id."'>$item->title - $item->code</option>";       
else:
$setup_list.="<option value='".$item->id."'>$item->title - $item->code</option>"; 
endif;
endforeach; 
$setup_list.="";



$setup_list_1="";
foreach($LedgerCodeItemList as $item):
if(isset($Payment)&&$Payment->destination==$item->id):
    
$setup_list_1.="<option selected value='".$item->id."'>$item->title - $item->code </option>"; 
elseif(old('destination')==$item->id):
$setup_list_1.="<option selected value='".$item->id."'>$item->title - $item->code</option>";       
else:
$setup_list_1.="<option value='".$item->id."'>$item->title - $item->code</option>"; 
endif;
endforeach; 
$setup_list_1.="";







$suppliers_list="";
foreach($Suppliers as $item):
if(isset($Payment)&&$Payment->supplier_id==$item->id):
    
$suppliers_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('supplier_id')==$item->id):
$suppliers_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$suppliers_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$suppliers_list.="";



?> 
  
 

   <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

 @if(isset($Payment))

                @if(strlen($Payment->file)>1)
            <br/>
                <a href="{{ asset("uploads/".$Payment->file) }}"  target="_blank" alt="logo"><button class="btn btn-primary"><i class="fas fa-file-pdf"></i>Download Document</button></a>
                @endif
            @endif

@if(isset($Payment))
<br/>
<a href="{{ URL::to("/payment-submission/".$Payment->id) }}"  onclick=" return confirm('Are you sure ?')">
    <button class="btn btn-success mt-4"><i class="fas fa-plus"></i> Complete </button>
</a>

@endif
                      
@if($id==null)

<form action="{{ route('payment.store')}}" method="POST" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\PaymentController@update', $id)}}" method="POST" enctype="multipart/form-data">
  
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}

<input type="hidden" name="transaction_date" value="<?php echo date('Y-m-d')?>">


                <div class="row">

<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Amount') }}</label>
                    <div class="@if($errors->has('amount'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Payment)){{$Payment->amount}}@else{{old('amount')}}@endif" type="text" placeholder="Amount" id="user-amount" name="amount">
                            @if($errors->has('amount'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('amount') }}</p>
                            @endif
                    </div>
                </div>
    </div>




<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Source') }}</label>
            <div class="@if($errors->has('source'))border border-danger rounded-3 @endif">
                        <select 
            name="source" id="select" class="select-item form-control-alternative{{ $errors->has('airport_code_id') ? ' is-invalid' : '' }}">
             <option value="0">Ledger Code  Source</option>   
            {!!$setup_list!!}
           </select>
                            @if($errors->has('source'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('source') }}</p>
                            @endif
                    </div>
                </div>
    </div>


    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Ledger Code  Destination') }}</label>
            <div class="@if($errors->has('source'))border border-danger rounded-3 @endif">
                        <select 
            name="destination" id="select-items" class="select-item form-control-alternative{{ $errors->has('airport_code_id') ? ' is-invalid' : '' }}">
             <option value="0">Ledger Code  Destination</option>   
            {!!$setup_list_1!!}
           </select>
                            @if($errors->has('destination'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('destination') }}</p>
                            @endif
                    </div>
                </div>
    </div>




    <div class="col-xs-12 col-md-12">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Description') }}</label>
                    <div class="@if($errors->has('amount'))border border-danger rounded-3 @endif">
                         <textarea name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Description') }}">@if(isset($Payment)){{$Payment->description}}@else{{old('description')}}@endif</textarea>


                            @if($errors->has('amount'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('amount') }}</p>
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