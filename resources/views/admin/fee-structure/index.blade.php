@extends('layouts.user_type.auth')

@section('content')
<?php


// $clients_list="";
// foreach($NotificationList as $item):
// $clients_list.="<option value='".$item->id."'>". $item->title ."</option>"; 
// endforeach; 
// $clients_list.="";


?>
<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Fee Structure</h5>
                        </div>
                        <a href="{{ URL::to("/fee-structure/create/0") }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Fee Structure</a>
                    </div>
                </div>
                @include('layouts.feedback')

@if(!$FeeStructures->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                                <tr>
<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')

</th>



<th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('class_program','Year')

</th>

<th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('academic_stage_id','Stage')

</th>

<th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('academic_year','Academic Year')

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
                                        <a href="{{ URL::to("/fee-structure/".$item->id) }}" >
            <button class="btn btn-primary "><i class="far fa-eye"></i> View </button>
          </a>
                                       
                                    </td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>
 <div class="pagination">
          {{ $FeeStructures->links() }}
          </div>
@else

<p style="padding:20px">
    No Fee Structure(s) added.
</p>


@endif

            </div>
        </div>
    </div>
</div>
 
@endsection