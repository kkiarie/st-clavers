@extends('layouts.user_type.auth')

@section('content')


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

  return 1;
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

  return 1;
}


}

?> 
<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                     <div class="row">



       <a href="{{ URL::to("/inventory-master-list/$InventoryMaster->id/edit") }}" >
      <button class="btn btn-primary mt-4"><i class="far fa-edit"></i> Edit {{$InventoryMaster->title}}</button>
      </a> 
      &nbsp;
  
              </div>
              
              <br/>
              <br/>
             <div class="row">

               <div class="col-xl-6">
                <h4>Title : {{$InventoryMaster->title}}</h4>
               </div>
                   <div class="col-xl-6">
                <h4>Ledger Code : <?php if((int)$InventoryMaster->ledger_code_id >0){

                        echo $InventoryMaster->ledgerData->code;
                      }
                      else{
                        echo "";
                      } ?></h4>
               </div>
               <div class="col-xl-6">
                <h4>Stock Level : {{datTotals($InventoryMaster->id)}}</h4>
               </div>
               <div class="col-xl-6">
                <h4>Minimum Level : {{$InventoryMaster->reorder_level}}</h4>
               </div>

               <div class="col-xl-6">
                <h4>Stock Value : {{number_format(stockValue($InventoryMaster->id),2)}}</h4>
               </div>
               <div class="col-xl-6">
                <h4>Average Unit Price : 

              <?php 
                     $value=stockValue($InventoryMaster->id)/stockCount($InventoryMaster->id);
                     echo number_format($value,2);
                      ?>
                </h4>
               </div>



             </div>
              
 <h1><b>History</b></h1>
            </div>
            <!-- Light table -->
             
                        <div class="table-responsive">
              @if(!$InventoryTransactions->isEmpty())   

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">@sortablelink('id','#')</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('title','Stock')</th>
                      <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('unit_price','Unit Price')</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('amount','Amount')</th>

                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('created_at','Date')</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('transaction_type','Source')</th>
              

     
            
                    
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach ($InventoryTransactions as $item)
                  <tr>
                    <td class="budget">
                      {{$loop->iteration}}.
                    </td>
                    <td>{{number_format($item->stock)}}</td>
                    <td>{{number_format($item->unit_price,2)}}</td>
                    <td>{{number_format($item->amount,2)}}</td>
                    <td>{{date("d-m-Y", strtotime($item->created_at))}}</td>
                    <td>
                      <?php 
                      if($item->transaction_type==1){
                        echo "Inventory Request";
                      }
                      elseif($item->transaction_type==20){
                        echo "Inventory Stock Purchase";
                      }
                      ?>
                    </td>
         
     
                  </tr>

                  @endforeach
                </tbody>
              </table>
<div class="card-footer py-4">
  <nav aria-label="...">
        <div class="pagination">
          {{ $InventoryTransactions->links() }}
          </div>
        </nav>
        </div>
          @else
            <p style="padding:10px">No history for {{$InventoryMaster->title}} at the moment.</p>
          @endif
            </div>

            </div>
        </div>
    </div>
</div>
 
@endsection