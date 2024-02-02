@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <div class="row">
<div class="col-xs-6">
<h5 class="mb-0">
Fee Structure &raquo;
{{$FeeStructure->ClassProgramData->title}}
::
{{$FeeStructure->AcademicStageData->title}}

</h5>
</div>


<div class="col-xs-6">
<h5 class="mb-0">
Amount Payable {{number_format($Amount,2)}}
</h5>


<a target="_blank" href="{{ URL::to("/fee-structure-pdf/$FeeStructure->id") }}" >
<button class="btn btn-success mt-4"><i class="fas fa-file-pdf"></i> 
PDF </button>
</a>
</div>


</div>




                        </div>

                    </div>
                </div>

@if(!$FeeStructureItems->isEmpty())  


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

                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($FeeStructureItems as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$item->FeeData->title}}</p>
                                    </td>
                                
                           
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{number_format($item->amount,2)}}</p>
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
    </div>
</div>
 
@endsection