@extends('layouts.pdf')
@section('content')

<div style="text-align:left">

	


 <table class="table align-items-center mb-0 table-striped" style="border:solid 1px" border="1">
	<tr>
		<td width="50%">{{$FeePayment->ref}}</td>
		<td width="50%"> Date: {{date('d/m/Y',strtotime($FeePayment->gl_date))}}</td>
	</tr>


    <tr>
        <td colspan="2">Received From  : {{$FeePayment->StudentData->name}}</td>
    </tr>
 @if($FeePayment->program_id>2)   
<tr>
    <td colspan="2">{{$FeePayment->ProgramData->name}}</td>
</tr>
@endif
   

        <tr>
        <td width="50%">{{$FeePayment->ClassProgramData->title}}
{{$FeePayment->AcademicStageData->title}}

        </td>
        <td width="50%">ADM NO.: {{$FeePayment->StudentData->admission_no}}</td>
    </tr>

    <tr>
        <td>Payment Mode : {{$FeePayment->PaymentModeData->title}}</td>
       <td> Paid Amount : {{number_format($FeePayment->amount,2)}}<br/>
       </td>
    </tr>
    <tr>
        <td colspan="2">
          {{$FeePayment->description}}  
        </td>

    </tr>
    <tr>
       <td colspan="2" style="text-transform: uppercase;"> 
       Amount in words ({{$AmountWords}})</td>
    </tr>
    <tr>
        <td>Outstanding Balance : {{number_format($Outstanding,2)}}</td>
        <td></td>
    </tr>

    <tr>
        <td>Received By : {{$FeePayment->issueData->name}}</td>
        <td>Issue date : {{date('d/m/Y',strtotime($FeePayment->created_at))}}</td>
        
    </tr>


</table>


</div>


@endsection