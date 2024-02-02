@extends('layouts.app')

@section('content')
@include('layouts.headers.cards2')
    
    <div class="container-fluid mt--7">
       <div class="row">
               <div class="col-xl-10 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0"> Balance Sheet Report</h3>
                        </div>
                    </div>
                    <div class="card-body">
                      
<?php

$client_list="";
foreach($LedgerCodeItemList as $item):
$client_list.="<option value='".$item->id."'>$item->title - $item->code </option>"; 
endforeach; 
$client_list.="";








  use App\Models\Entity;
function MasterConfigItem($id=null)
{

  $title = Entity::find($id);
  if(!$title)
  {
    return "Not Found";
  }
  else{

    return strtoupper($title->title);
  }
}


?>   


<form action="{{action('App\Http\Controllers\Admin\ExpenseController@balanceSheetProc')}}" method="POST">


{{ csrf_field() }}

   
    
    @include('layouts.feedback')


    <div class="pl-lg-4">

        <div class="row">


                <div class="col-xs-12 col-sm-6">
                              <div class="form-group{{ $errors->has('from_date') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-from_date">{{ __('From Date') }}</label>

         <input type="text" name="from_date" id="input-from_date" class="form-control form-control-alternative {{ $errors->has('from_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Select date') }}" value="@if(isset($NonMotor)){{$NonMotor->from_date}}@else{{old('from_date')}}@endif" >

            @if ($errors->has('from_date'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('from_date') }}</strong>
                </span>
            @endif

        </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                              <div class="form-group{{ $errors->has('to_date') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-to_date">{{ __('To Date') }}</label>

         <input type="text" name="to_date" id="input-to_date" class="form-control form-control-alternative {{ $errors->has('to_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Select date') }}" value="@if(isset($NonMotor)){{$NonMotor->to_date}}@else{{old('to_date')}}@endif" >

            @if ($errors->has('to_date'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('to_date') }}</strong>
                </span>
            @endif

        </div>
                </div>

                              
        </div>






        <div class="text-center">
            <button type="submit" class="btn btn-success mt-4">Search</button>
        </div>
    </div>

</form>


                    </div>
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