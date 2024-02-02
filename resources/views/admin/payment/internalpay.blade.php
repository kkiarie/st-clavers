@extends('layouts.app')

@section('content')
@include('layouts.headers.cards2')
    
    <div class="container-fluid mt--7">
       <div class="row">
              <div class="col-xl-10 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h2 class="mb-0">Make Allocation<br/>
                                
                                <br/>

                                Cashier Balance : {{number_format($Amount,2)}}
                            </h2>
                            <br/>
                            <h3>
                                
                            </h3>
                        </div>
                    </div>


            
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                    <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('rfp_code','Ledger Code')</th>
                     <th scope="col" class="sort" data-sort="budget"
                    >@sortablelink('amount','Amount')</th>
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody class="list">
                 
                  <tr>
                    <td class="budget">
                     
                    </td>
                    <td>
                 {{$Expense->ledgerData->title}}
                    </td>
                      <td>
                      {{number_format($Expense->amount,2)}}
                    </td>


      
        
                  </tr>

                 
                </tbody>
              </table>
               @include('layouts.feedback')
              <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <div class="jumbotron">
                          <div class="container">
                              
                              <p>{{$Expense->description}}</p>
                              <p>
                                            @if(isset($Expense))

            @if(strlen($Expense->file)>1)
            <br/>
            <a href="{{ asset("uploads/".$Expense->file) }}"  target="_blank" alt="logo"><button class="btn btn-primary"><i class="fas fa-file-pdf"></i> Download Document</button></a>
            @endif
            @endif
              
                              </p>
                          </div>
                      </div>
                  </div>
              </div>
              


                    <div class="card-body">
                      

<form action="{{action('App\Http\Controllers\Admin\ExpenseController@ExpInternalPayProccess')}}" method="POST">


<input type="hidden" name="field_amount" value="{{$Amount}}">
<input type="hidden" name="id" value="{{$Expense->id}}">

{{ csrf_field() }}

    
    
    @include('layouts.feedback')


    <div class="pl-lg-4">

        <div class="form-group{{ $errors->has('notes') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-notes">{{ __('Notes') }}</label>
      
            <textarea placeholder="notes" name="notes" id="input-notes" class="form-control form-control-alternative{{ $errors->has('notes') ? ' is-invalid' : '' }}"></textarea>

            @if ($errors->has('notes'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('notes') }}</strong>
                </span>
            @endif
        </div>
       




        <div class="text-center">
            <button type="submit" onclick="return confirm('are you sure ?')" class="btn btn-success mt-4">Save</button>
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