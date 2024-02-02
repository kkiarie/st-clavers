@extends('layouts.user_type.auth')

@section('content')
<?php


$clients_list="";
foreach($StudentLists as $item):

    if(isset($student) && $student->id==$item->id)
    {
       $clients_list.="<option selected value='".$item->id."'>$item->name - $item->admission_no </option>";  
    }
    else{
        $clients_list.="<option value='".$item->id."'>$item->name - $item->admission_no </option>"; 
    }

endforeach; 
$clients_list.="";


 use App\Models\FeeStructure;
use App\Models\FeePayment;




 function paid($FeeID=null,$StudentID=null)
    {

        $Paid =FeePayment::where("student_id",$StudentID)
        ->where("fee_structure_id",$FeeID)
        ->where("status",1)->sum("amount");


        return $Paid;
    }




 function payable($FeeID=null,$StudentID=null)
    {


        $Outstanding= FeeStructure::where("status",1)
        ->where("parent_id",$FeeID)->sum("amount");

        return $Outstanding;
    }




 function opBalance($FeeID=null,$StudentID=null)
    {

        $Paid =FeePayment::where("student_id",$StudentID)
        ->where("fee_structure_id",$FeeID)
        ->where("status",1)->sum("amount");
        $Outstanding= FeeStructure::where("status",1)
        ->where("parent_id",$FeeID)->sum("amount");

        return $Outstanding-$Paid;
    }




?>
<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            
                            <h5 class="mb-0">Fee Payment</h5>

                             <h5 class="mb-0">Student Name : {{$student->name}}</h5>

                             <a href="{{ URL::to("/fee-payment-history/".$id) }}" >
<button class="btn btn-primary "><i class="fa-solid fa-clock-rotate-left"></i> Payment History </button>
</a>
                        </div>
                       
                    </div>
                </div>
                @include('layouts.feedback')
            <div style="padding:10px">
                
              <form action="{{action('App\Http\Controllers\Admin\FeePaymentController@feepaymentProc')}}" method="POST">
                {{ csrf_field() }}
                <div class="row">


                  <div class="col-xl-4">
                       <div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-client_id">{{ __('Students') }}</label>
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




              @if(!$FeeStructures->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">#
                                        
                                    </th>
                                     <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">Grace
                                        
                                    </th>
                                     <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">Term                                        
                                    </th>
                                     <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">Academic Year                                        
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">Amount Payable                                   
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">Amount paid                                   
                                    </th>
                               
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($FeeStructures as $item)
                                <tr>
<td class="ps-4">
<p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
</td>

<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{$item->ClassProgramData->title}}</p>
</td>

<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{$item->AcademicStageData->title}}</p>
</td>


<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{$item->academic_year}}</p>
</td>

<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{number_format(payable($item->id,$id),2)}}</p>
</td>



<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{number_format(paid($item->id,$id),2)}}</p>
</td>

                                   

                                        

          
                               
                                   
<td class="text-center">
    @if(opBalance($item->id,$id)==0)
<a href="{{ URL::to("/fee-payment-history/".$id) }}" >
<button class="btn btn-primary "><i class="fa-solid fa-clock-rotate-left"></i> Payment History </button>
</a>
    @else
<a href="{{ URL::to("/fee-payment/create/".$item->id."/".$id) }}" >
<button class="btn btn-primary "><i class="far fa-eye"></i> Make Payment </button>
</a>

    @endif


</td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>

@else

<p style="padding:20px">
   No Fee Structure has been configured to that fits you class allocation
</p>


@endif


            </div>
        </div>
    </div>
</div>
 
@endsection