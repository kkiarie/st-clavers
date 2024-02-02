@extends('layouts.pdf')
@section('content')
<?php 



 ?>
<center>
	<h2><u>Request For Purchase</u></h2>
</center>

<table >
	<tr>
        <th width="50%">RFP :  {{$record->rfp_code}} </th>

        <th width="20%"> Date : {{date("d/m/Y",strtotime($record->created_at))}}</th>
		<th width="30%"> Status : 
                  @if($record->status==0)

                  Incomplete
                  @elseif($record->status==1)

                  Pending Cashier Manager
                  @elseif($record->status==5)
                  record Request Canceled
                  @elseif($record->status==11)
                  record-collection-funds
                  @elseif($record->status==12)
                  Pending Purchase Confirmation by Cashier
                  @else
                  Complete
                  @endif

        </th>
		
	</tr>

</table>

@if(!$ProcurementsList->isEmpty())  
<table border="1" style="border:solid 1px #000">
    <tr style="background:#ccc">
        <th>#</th>
        <th>Item</th>

        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Amount</th>
    </tr>
 @foreach ($ProcurementsList as $item)
   
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
<th>{{number_format($ProcuremenTotal,2)}}</th>
 </tr>  
</table>
 @else
            <p style="padding:10px">No records added at the moment.</p>
          @endif

@if($record->status==2)

<table>
    <tr>
        <th width="100%">Approved By : {{$record->ApprovalData->name}}</th>
       <th width="100%">Approval Date : {{date("d/m/Y H:i",strtotime($record->approval_date))}}</th>
    </tr>

    <tr>
        <th> 
          <img src="{{$record->ApprovalData->signature}}" width="100%" alt="logo" >
         
         </th>
    </tr>
</table>

@endif
<br/>




@if($CashierFunds)
<h4>Cashier Details</h4>
<hr/>

@if((int)$CashierFunds->approved_by>0)
<table style="border-style: dotted;">

    <tr>
        <td>Cashier Name : {{$CashierFunds->createrData->name}}</td>
        <td>Amount Utilized : {{number_format($CashierFunds->amount*-1,2)}}</td>
    </tr>
   <tr>
        <th width="100%">Approved By : {{$CashierFunds->updateData->name}}</th>
       <th width="100%">Approval Date : {{date("d/m/Y H:i",strtotime($CashierFunds->approval_date))}}</th>
    </tr>

    <tr>
        <th> 
          <img src="{{$CashierFunds->updateData->signature}}" width="100%" alt="logo" >
         
         </th>
         <th>&nbsp;</th>
    </tr>
    
</table>
@endif

@endif

<br>



@endsection