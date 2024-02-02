<?php


$setup_list="";
foreach($InventoryMastersList as $item):
if(isset($InventoryRequest)&&$InventoryRequest->inventory_masters_id==$item->id):
    
$setup_list.="<option selected value='".$item->id."'>$item->title - ".datTotals($item->id)."</option>"; 
elseif(old('inventory_masters_id')==$item->id):
$setup_list.="<option selected value='".$item->id."'>$item->title - ".datTotals($item->id)."</option>";       
else:
$setup_list.="<option value='".$item->id."'>$item->title - ".datTotals($item->id)."</option>"; 
endif;
endforeach; 
$setup_list.="";


$destination_list="";
foreach($LedgerCodeItemList as $item):
if(isset($Cashier)&&$Cashier->ledger_id==$item->id):
    
$destination_list.="<option selected value='".$item->id."'>$item->title - $item->code</option>"; 
elseif(old('ledger_id')==$item->id):
$destination_list.="<option selected value='".$item->id."'>$item->title - $item->code</option>";       
else:
$destination_list.="<option value='".$item->id."'>$item->title - $item->code</option>"; 
endif;
endforeach; 
$destination_list.="";



use App\Models\InventoryTransactions;



function datTotals($id=null)
{

  $record = InventoryTransactions::where("status",1)->where("inventory_masters_id",$id)->sum("stock");

  if($record)
  {
    return number_format($record);
  }
  else{

    return 0;
  }
}


?> 

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('inventory-request.store')}}" autocomplete="off">
    <input type="hidden" name="parent_id" value="{{$parent_id}}">
@else
<form action="{{action('App\Http\Controllers\Admin\InventoryRequestController@update', $id)}}" method="POST">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




<div class="row">

<div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="user-name" class="form-control-label">{{ __('Quantity') }}</label>
                <div class="@if($errors->has('quantity'))border border-danger rounded-3 @endif">
                    <input class="form-control" value="@if(isset($Inventory)){{$Inventory->quantity}}@else{{old('quantity')}}@endif" type="text" placeholder="Quantity" id="user-quantity" name="quantity">
                        @if($errors->has('quantity'))
                            <p class="text-danger text-xs mt-2">{{ $errors->first('quantity') }}</p>
                        @endif
                </div>
            </div>
</div>


<div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="user-name" class="form-control-label">{{ __(' Inventory Items') }}</label>
                <div class="@if($errors->has('quantity'))border border-danger rounded-3 @endif">
                <select 
            name="inventory_masters_id" id="select-item" class=" form-control-alternative{{ $errors->has('airport_code_id') ? ' is-invalid' : '' }}">
             <option value="0">Search </option>   
            {!!$setup_list!!}
           </select>
                        @if($errors->has('quantity'))
                            <p class="text-danger text-xs mt-2">{{ $errors->first('quantity') }}</p>
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