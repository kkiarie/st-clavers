@extends('layouts.user_type.auth')

@section('content')
<?php


$clients_list="";
foreach($InventoryMastersList as $item):
$clients_list.="<option value='".$item->id."'>".$item->title ."</option>"; 
endforeach; 
$clients_list.="";


?>

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



use App\Models\Procurement;

function stockValue($id=null)
{


    $In= InventoryTransactions::where("inventory_masters_id",$id)
    ->where("transaction_type",20)
    ->where("status",1)
    ->sum("amount");

    $Out= InventoryTransactions::where("inventory_masters_id",$id)
    ->where("transaction_type",1)
    ->where("status",1)
    ->sum("amount");
    $data=$In-$Out;
if($data)
{
  return $In-$Out;
}
else{

  return 0;
}


}


function stockCount($id=null)
{


    $In= InventoryTransactions::where("inventory_masters_id",$id)
    // ->where("transaction_type",20)
    ->where("status",1)
    ->sum("stock");


    $data=$In;
if($data)
{
  return $In;
}
else{

  return 0;
}


}

?>  
<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Inventory Items</h5>
                        </div>
                        <a href="{{ URL::to("/inventory-master-list/create") }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Inventory</a>
                    </div>
                </div>
                @include('layouts.feedback')
            <div style="padding:10px">
                
              <form action="{{action('App\Http\Controllers\Admin\InventoryMasterController@inventoryQuery')}}" method="POST">
                {{ csrf_field() }}
                <div class="row">


                  <div class="col-xl-4">
                       <div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-client_id">{{ __('Inventory Item') }}</label>
            <br/>
               <select  name="value" 
                id="select-item" class=" form-control-alternative{{ $errors->has('client_id') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$clients_list!!}
           </select>


    </div>
                </div>
<div class="col-xl-12">
 <button class="btn btn-primary "><i class="fa-solid fa-magnifying-glass"></i> Search</button>
</div>







              </form>
              
              </div>
@if(!$InventoryMasters->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                               <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('title','Inventory Item Name')</th>
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('ledger_code_id','Ledger Code')</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('stock_level','Stock Level')</th>
                    <th scope="col" class="sort" data-sort="status">
                    @sortablelink('reorder_level','Stock Value')</th>
                    <th scope="col" class="sort" data-sort="status">
                    @sortablelink('reorder_level','Average Unit Price')</th>

     
            
                    
                    <th scope="col"></th>
                  </tr>
                            </thead>
                           <tbody class="list">
                  @foreach ($InventoryMasters as $item)
                  <tr>
                    <td class="budget">
                      {{$loop->iteration}}.
                    </td>
                    <td>
                      <a href="{{ URL::to("/inventory-master-list/".$item->id) }}" style="font-weight: bold;">
                    {{$item->title}}
                  </a>
                    </td>
                     <td>
                      <?php if((int)$item->ledger_code_id >0){

                        echo $item->ledgerData->code;
                      }
                      else{
                        echo "";
                      } ?>
                    </td>
                     <td>
                     {{datTotals($item->id)}}
                    </td>
                    <td>
                     @if(stockValue($item->id)>0)
{{number_format(stockValue($item->id),2)}}
                     @else

0
                     @endif
                    </td>
                    <td>
                       @if(stockValue($item->id)>0)
                     <?php 
                     $value=stockValue($item->id)/stockCount($item->id);
                     echo number_format($value,2);
                      ?>
                      @else
0
                      @endif
                    </td>

     
                  </tr>

                  @endforeach
                </tbody>
                        </table>
                    </div>
                </div>
 <div class="pagination">
          {{ $InventoryMasters->links() }}
          </div>
@else

<p style="padding:20px">
    No Item(s) added.
</p>


@endif

            </div>
        </div>
    </div>
</div>
 
@endsection