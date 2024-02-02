<?php


$LedgerCodeItemList_Items="";
foreach($LedgerCodeItemList as $item):
if(isset($Inventory)&&$Inventory->ledger_code_id==$item->id):
    
$LedgerCodeItemList_Items.="<option selected value='".$item->id."'>$item->title - $item->code</option>"; 
elseif(old('ledger_code_id')==$item->id):
$LedgerCodeItemList_Items.="<option selected value='".$item->id."'>$item->title - $item->code</option>";       
else:
$LedgerCodeItemList_Items.="<option value='".$item->id."'>$item->title - $item->code</option>"; 
endif;
endforeach; 
$LedgerCodeItemList_Items.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('inventory-master-list.store')}}" enctype="multipart/form-data">
@else
<form action="{{action('App\Http\Controllers\Admin\InventoryMasterController@update', $id)}}" method="POST" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}




                <div class="row">

<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Title') }}</label>
                    <div class="@if($errors->has('title'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Inventory)){{$Inventory->title}}@else{{old('title')}}@endif" type="text" placeholder="Name of Item" id="user-title" name="title">
                            @if($errors->has('title'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('title') }}</p>
                            @endif
                    </div>
                </div>
    </div>


<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Reorder Level') }}</label>
                    <div class="@if($errors->has('reorder_level'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Inventory)){{$Inventory->reorder_level}}@else{{old('reorder_level')}}@endif" type="text" placeholder="Stock Level" id="user-name" name="reorder_level">
                            @if($errors->has('reorder_level'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('reorder_level') }}</p>
                            @endif
                    </div>
                </div>
    </div>






    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Ledger Code') }}</label>
                    <div class="@if($errors->has('ledger_code_id'))border border-danger rounded-3 @endif">
                <select  name="ledger_code_id" 
                id="select-item-1" class=" form-control-alternative{{ $errors->has('ledger_code_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$LedgerCodeItemList_Items!!}
           </select>
                            @if($errors->has('ledger_code_id'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('ledger_code_id') }}</p>
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