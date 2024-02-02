
@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
          <div class="card mb-4 mx-4">  

         

          <div class="card-body">
             <h2>Procurement Value : {{number_format($ProcurementAmount)}}</h2>
             @if(!$ProcurementsList->isEmpty())   
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('rfp_code','Inventory Item')</th>
                   
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('amount','Quantity')</th>
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('unit_price','Unit Price')</th>
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('amount','Amount')</th>
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach ($ProcurementsList as $item)
                  <tr>
                    <td class="budget">
                      {{$loop->iteration}}.
                    </td>
                    <td>
                  {{$item->InventoryMasterData->title}}
                    </td>
                      <td>
                      {{number_format($item->quantity)}}
                    </td>


                    <td>
                      {{number_format($item->unit_price)}}
                    </td>

                    <td>
                      {{number_format($item->amount)}}
                    </td>


      
        
                  </tr>

                  @endforeach
                </tbody>
              </table>

              @endif
                      

<form action="{{action('App\Http\Controllers\Admin\ProcurementController@internalPayProccess')}}" method="POST" enctype="multipart/form-data">

<input type="hidden" name="transaction_id" value="{{$transaction_id}}">
<input type="hidden" name="field_amount" value="{{$Amount}}">

{{ csrf_field() }}

    
    
    @include('layouts.feedback')


    <div class="pl-lg-4">


     
                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-description">{{ __('Description') }}</label>


            <textarea name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Description') }}">@if(isset($Procurement)){{$Procurement->description}}@else{{old('description')}}@endif</textarea>
           

            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>

       
                    <div class="form-group{{ $errors->has('document') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-document">{{ __('Supporting Document') }}</label>
            <input type="file" name="document" id="input-document" class="form-control form-control-alternative{{ $errors->has('document') ? ' is-invalid' : '' }}" placeholder="{{ __('document ') }}" value="@if(isset($Procurement)){{$Procurement->document}}@else{{old('document')}}@endif" >





            @if ($errors->has('document'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('document') }}</strong>
                </span>
            @endif



    </div>




        <div class="text-center">
            <button type="submit" class="btn btn-success mt-4">Save</button>
        </div>
    </div>

</form>

                    </div>   
    </div>
    </div>
</div>
 
@endsection