@extends('layouts.app')

@section('content')
@include('layouts.headers.cards2')
    
    <div class="container-fluid mt--7">
       <div class="row">
      <?php $setup_list="";
foreach($InventoryMastersList as $item):


if(isset($Procurement)):

 if($Procurement->inventory_masters_id==$item->id):

    $setup_list.="<option selected value='".$item->id."'>$item->title</option>"; 
else:

$setup_list.="<option value='".$item->id."'>$item->title</option>"; 
    

 endif;   

else:

$setup_list.="<option value='".$item->id."'>$item->title</option>"; 

endif;    


    


endforeach; 
$setup_list.="";


?> 


            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{$label}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                      
@if($id==null)

<form method="post" action="{{ route('procurement.store')}}" autocomplete="off">
    <input type="hidden" name="parent_id" value="{{$parent_id}}">
@else
<form action="{{action('App\Http\Controllers\Admin\ProcurementController@update', $id)}}" method="POST">
<input name="_method" type="hidden" value="PATCH">
@endif  
{{ csrf_field() }}

    
    
    @include('layouts.feedback')


    <div class="pl-lg-4">


                            <div class="form-group{{ $errors->has('inventory_masters_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-inventory_masters_id"> 
        </label>
              <select 
            name="inventory_masters_id" id="select-item" class=" form-control-alternative{{ $errors->has('airport_code_id') ? ' is-invalid' : '' }}">
             <option value="0">Search </option>   
            {!!$setup_list!!}
           </select>

            @if ($errors->has('value'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('value') }}</strong>
                </span>
            @endif

        </div>



        <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>
            <input type="text" name="quantity" id="input-quantity" class="form-control form-control-alternative{{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="{{ __('Quantity') }}" value="@if(isset($Procurement)){{$Procurement->quantity}}@else{{old('quantity')}}@endif" >

            @if ($errors->has('quantity'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('quantity') }}</strong>
                </span>
            @endif
        </div>










        <div class="text-center">
            <button type="submit" class="btn btn-success mt-4">{{$button}}</button>
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