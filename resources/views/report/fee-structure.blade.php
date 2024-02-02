@extends('layouts.pdf')
@section('content')

<div style="text-align:left">


@if($FeeStructure->program_id>2)
<h3>
<b>{{$FeeStructure->ProgramData->name}}</b>
</h3>
@endif 	
<h3><b>Fee Structure &raquo;
{{$FeeStructure->ClassProgramData->title}}
<br/>
{{$FeeStructure->AcademicStageData->title}}
:: {{$FeeStructure->academic_year}}
</b></h3>
<h3>
	<b>Amount Payable {{number_format($Amount,2)}}</b>
</h3>

 <table class="table align-items-center mb-0 table-striped" border="1">
	<tr style="background:#ccc" border=1>
		<td>#</td>
		<td align="center">Fee Item</td>
		<td align="center">Amount</td>
	</tr>
    @foreach ($FeeStructureItems as $item)
    <tr>
        <td class="ps-4">
            <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
        </td>

        <td class="text-center" align="center">
            <p class="text-xs font-weight-bold mb-0">
                {{$item->FeeData->title}}</p>
        </td>
    

        <td class="text-center" align="center">
            <p class="text-xs font-weight-bold mb-0">
                {{number_format($item->amount,2)}}</p>
        </td>
       

    </tr>
    @endforeach
    <tr>
    	<th colspan="2">Total</th>
    	<th align="center"><center>{{number_format($Amount,2)}}</center></th>
    </tr>

</table>


</div>


@endsection