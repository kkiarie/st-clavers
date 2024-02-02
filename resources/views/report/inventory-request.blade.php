@extends('layouts.pdf')
@section('content')


<?php

  use App\Models\User;
function MasterEntity($id=null)
{

  $title = User::find($id);
  if(!$title)
  {
    return "Not Found";
  }
  else{

    return strtoupper($title->name);
  }
}

 ?>
<center>
    <h2><u>Inventory Request </u></h2>
</center>

<table >
    <tr>
        

        <th width="20%"> Date : {{date("d/m/Y",strtotime($record->created_at))}}</th>
        <th width="30%"> Status :<?php 

                  if($record->status==0)
                  {
                    echo "Incomplete";
                  }
                   elseif($record->status==1)
                  {
                    echo "Submitted Pending Inventory Manager Approval";
                  }
                  elseif($record->status==2)
                  {
                    echo "Inventory Manager Approved Requested, pending collection";
                  }
                  else{

                    echo "Request complete, items collected ";
                  }

                ?>

        </th>
        
    </tr>

</table>

@if(!$InventoryRequestList->isEmpty())  
<table border="1" style="border:solid 1px #000">
    <tr style="background:#ccc">
        <th>#</th>
        <th>Item</th>

        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Amount</th>
    </tr>
 @foreach ($InventoryRequestList as $item)
   
  <tr>
      <td> {{$loop->iteration}}.</td>
      <td> {{$item->InventoryMasterData->title}}</td>
     <td>{{number_format($item->quantity)}}</td>
     <td>{{number_format($item->unit_price,2)}}</td>
     <td>{{number_format($item->amount,2)}}</td>
  </tr> 



 @endforeach   

 <tr>
<th colspan="4">Total</th>
<th>{{number_format($InventoryRequestListTotal,2)}}</th>
 </tr>  
</table>
 @else
            <p style="padding:10px">No records added at the moment.</p>
          @endif

@if($record->status==4)

<table>
    <tr>
        <th width="100%">Submitted By : {{MasterEntity($record->created_by)}}</th>
       <th width="100%">Date Of Subimission : {{date("d/m/Y H:i",strtotime($record->created_at))}}</th>
    </tr>

    <tr>
        <th width="100%">Approved By : {{MasterEntity($record->approved_by)}}</th>
       <th width="100%">Approval Date : {{date("d/m/Y H:i",strtotime($record->approval_date))}}</th>
    </tr>

        <tr>
        <th width="100%">Collected By : {{MasterEntity($record->received_by)}}</th>
       <th width="100%">Collection Date : {{date("d/m/Y H:i",strtotime($record->received_date))}}</th>
    </tr>
</table>

@endif
<br/>






<br>



@endsection