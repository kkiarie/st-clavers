@extends('layouts.user_type.auth')

@section('content')
<?php


$clients_list="";
foreach($ProcurementsList as $item):
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



use App\Models\Procurement;
function MasterProcurement($id=null)
{

  $title = Procurement::where("status","!=",3)->where("parent_id",$id)
  ->sum("amount");
  if(!$title)
  {
    return 0;
  }
  else{

    return number_format($title,2);
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
                            <h5 class="mb-0">All Procurement Items</h5>
                        </div>
                        <a href="{{ URL::to("/procurement/create/0") }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Procurement</a>
                    </div>
                </div>
                @include('layouts.feedback')
            <div style="padding:10px">
                
              <form action="{{action('App\Http\Controllers\Admin\ProcurementController@searchProcess')}}" method="POST">
                {{ csrf_field() }}
                <div class="row">


                  <div class="col-xl-4">
                       <div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-client_id">{{ __('Procurement Item') }}</label>
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
@if(!$Procurements->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                                       <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('rfp_code','RFP Code Name')</th>
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('quantity','Quantity')</th>
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('quantity','Price')</th>
                <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('status','Status')</th>
            
                    
                    
                  </tr>
                </thead>
                        <tbody class="list">
                  @foreach ($Procurements as $item)
                  <tr>
                    <td class="budget">
                      {{$loop->iteration}}.
                    </td>
                    <td>
                  <a style="font-weight: bold;" href="{{ URL::to("/procurement/".$item->id) }}" >  {{$item->rfp_code}}
                  </a>
                    </td>
                      <td>
                      {{number_format($item->quantity,2)}}
                    </td>
                    <td>
                      {{MasterProcurement($item->id)}}
                    </td>
      
        <td>
                  @if($item->status==0)

                  Incomplete
                  @elseif($item->status==1)

                  Pending Cashier Manager
                  @elseif($item->status==5)
                  Procurement Request Canceled
                  @elseif($item->status==11)
                  procurement-collection-funds
                  @elseif($item->status==12)
                  Pending Purchase Confirmation by Cashier
                   @elseif($item->status==2)
                  Pending Cashier Allocation
                  @else
                  Complete
                  @endif
                    </td>
                  </tr>

                  @endforeach
                </tbody>
                        </table>
                    </div>
                </div>
 <div class="pagination">
          {{ $Procurements->links() }}
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