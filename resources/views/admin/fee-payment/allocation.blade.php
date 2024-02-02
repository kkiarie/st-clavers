<?php

$clients_list="";
foreach($FeeStructures as $item):

if(old('fee_structure_item_id')==$item->id):
$clients_list.="<option selected value='".$item->id."'>".$item->FeeData->title."</option>";       
else:

$clients_list.="<option value='".$item->id."'>".$item->FeeData->title."</option>"; 

endif;

endforeach; 
$clients_list.="";



?>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{$label}} </h3>

                 <h5 class="mb-0">Student Name : {{$Student->name}}</h5>
                 <h5 class="mb-0">Admission : {{$Student->admission_no}}</h5>

                 <hr/>
               <h5 class="mb-0">  Fee Structure : {{number_format($FeeStructuresAmount,2)}}
               </h5>


                <h5 class="mb-0">  Fee Paid : {{number_format($FeeStructuresAmountPaid,2)}}
               </h5>

               <h5 class="mb-0">  Balance : 
                {{number_format($FeeStructuresAmount-$FeeStructuresAmountPaid,2)}}
               </h5>
            </div>
            <div class="card-body pt-4 p-3">

@include('layouts.feedback')



<form method="post" action="{{ route('fee-payment.store')}}" enctype="multipart/form-data">
<input type="hidden" name="student_id" value="{{$Student->id}}">    
<input type="hidden" name="fee_structure_id" value="{{$fee_structure_id}}">    

{{ csrf_field() }}




                <div class="row">




<div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Fee Amount') }}</label>
                    <div class="@if($errors->has('amount'))border border-danger rounded-3 @endif">
                        <input class="form-control" value="@if(isset($Teacher)){{$Teacher->amount}}@else{{old('amount')}}@endif" type="text" placeholder="Fee amount" id="user-amount" name="amount">
                            @if($errors->has('amount'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('amount') }}</p>
                            @endif
                    </div>
                </div>
    </div>
  

    <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="user-name" class="form-control-label">{{ __('Fee Item') }}</label>
                    <div class="@if($errors->has('gender'))border border-danger rounded-3 @endif">
                <select  name="fee_structure_item_id" 
                id="select-item" class=" form-control-alternative{{ $errors->has('gender') ? ' is-invalid' : '' }}">
             <option value="0">All</option>   
            {!!$clients_list!!}
           </select>
                            @if($errors->has('gender'))
                                <p class="text-danger text-xs mt-2">{{ $errors->first('gender') }}</p>
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

              @if(!$FeePaymentItems->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                       

                                     <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('fee_item','Fee Item')
                                       
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('amount','Amount')
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($FeePaymentItems as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$item->FeeDataItem->title}}</p>
                                    </td>
                                
                           
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{number_format($item->amount,2)}}</p>
                                    </td>
                                   
                                    <td class="text-center">
  
<form action="{{action('App\Http\Controllers\Admin\FeePaymentController@destroy', $item->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button onclick="return confirm('Are you sure ?')" class="btn btn-danger mt-2"><i class="far fa-trash-alt"></i> Delete </button>
        </form>                      
                                    </td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>

@else

<p style="padding:20px">
    No items have been added.
</p>


@endif
        </div>



    </div>




