@extends('layouts.app')

@section('content')
@include('layouts.headers.cards2')
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


?>    
    <div class="container-fluid mt--7">
       <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Request For Purchase Approval</h3>
             
            </div>
            <!-- Light table -->
                      <form action="{{action('App\Http\Controllers\Admin\ProcurementController@searchProcess')}}" method="POST">


{{ csrf_field() }}

  <?php $setup_list="";
foreach($ProcurementsList as $item):

    $setup_list.="<option value='".$item->id."'>$item->rfp_code</option>"; 
endforeach; 
$setup_list.="";


?> 
    
    @include('layouts.feedback')


    <div class="pl-lg-4">

        <div class="row">
                <div class="col-xl-6">
                            <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-title"> 
        </label>
              <select 
            name="value" id="select-item" class=" form-control-alternative{{ $errors->has('airport_code_id') ? ' is-invalid' : '' }}">
             <option value="0">Search </option>   
            {!!$setup_list!!}
           </select>

            @if ($errors->has('value'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('value') }}</strong>
                </span>
            @endif

            <button type="submit" class="btn btn-success mt-4"><i class="fas fa-search"></i> Search</button>
        </div>


                </div>



        </div>



    </div>

</form>   
            
            <div class="table-responsive">
              @if(!$Procurements->isEmpty())   
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('rfp_code','RFP Code Name')</th>
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('quantity','RFP Quantity')</th>
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
                     <?php 
                     if($item->status==0)
                     {
                      echo "Incomplete";
                     }
                      elseif($item->status==1)
                     {
                      echo "Pending Approval";
                     }
                     else{

                      echo "Approved";
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
          {{ $Procurements->links() }}
          </div>
        </nav>
        </div>
          @else
            <p style="padding:10px">No records added at the moment.</p>
          @endif
            </div>
            <!-- Card footer -->

          </div>
        </div>
      </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush