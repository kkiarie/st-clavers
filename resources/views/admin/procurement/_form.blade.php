  <?php 
$setup_list="";
foreach($InventoryMastersList as $item):
if(isset($Procurement)&&$Procurement->inventory_masters_id==$item->id):
    
$setup_list.="<option selected value='".$item->id."'>$item->title </option>"; 
elseif(old('inventory_masters_id')==$item->id):
$setup_list.="<option selected value='".$item->id."'>$item->title </option>";       
else:
$setup_list.="<option value='".$item->id."'>$item->title </option>"; 
endif;
endforeach; 
$setup_list.="";



?> 

  <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')

@if($id==null)

<form method="post" action="{{ route('procurement.store')}}" autocomplete="off">
    <input type="hidden" name="parent_id" value="{{$parent_id}}">
@else
<form action="{{action('App\Http\Controllers\Admin\ProcurementController@update', $id)}}" method="POST">
<input name="_method" type="hidden" value="PATCH">
@endif 
{{ csrf_field() }}




                <div class="row">




<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Quantity') }}</label>
    <div class="@if($errors->has('reorder_level'))border border-danger rounded-3 @endif">
    <input class="form-control" value="@if(isset($Procurement)){{$Procurement->quantity}}@else{{old('quantity')}}@endif" type="text" placeholder="Quantity" id="user-name" name="quantity">
        @if($errors->has('quantity'))
            <p class="text-danger text-xs mt-2">{{ $errors->first('quantity') }}</p>
        @endif
                    </div>
                </div>
    </div>


    <div class="col-xs-12 col-md-4">
                <div class="form-group">
            <label for="user-name" class="form-control-label">
            {{ __('Unit Price') }}</label>
    <div class="@if($errors->has('reorder_level'))border border-danger rounded-3 @endif">
    <input class="form-control" value="@if(isset($Procurement)){{$Procurement->unit_price}}@else{{old('unit_price')}}@endif" type="text" placeholder="Unit Price" id="user-name" name="unit_price">
        @if($errors->has('unit_price'))
            <p class="text-danger text-xs mt-2">{{ $errors->first('unit_price') }}</p>
        @endif
                    </div>
                </div>
    </div>






    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Inventory Item') }}</label>
                    <div class="@if($errors->has('ledger_code_id'))border border-danger rounded-3 @endif">
                <select  name="inventory_masters_id" id="select-item" class=" form-control-alternative{{ $errors->has('ledger_code_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
           {!!$setup_list!!}
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