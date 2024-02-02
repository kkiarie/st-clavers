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
             

               <h1>Expense Details   <br/>
          @if($Expense->status==1)    
         <a href="{{ URL::to("/expenses-approval/".$Expense->id) }}" >
            <button class="btn btn-success mt-4"><i class="fas fa-file-pdf"></i> Approve Request </button>
         </a>
         @endif

          
      </h1>
           
          <br/> 
             <div class="row">
              
              <div class="col-xl-4">
                <h4>Submited by Name : </h4>
               </div>
        
               <div class="col-xl-3">
                <h4> Amount : {{number_format($Expense->amount,2)}}</h4>
               </div>
               <div class="col-xl-3">
                <h4> Date : {{date("d/m/Y",strtotime($Expense->created_at))}}</h4>
               </div>
                      <div class="col-xl-3">
                <h4>Status : <?php if($Expense->status==1) { echo "Pending Approval";}

         if($Expense->status==2) { echo "Approved";} ?></h4>
               </div>
               <div class="col-xl-12">
               	<h4>Description</h4>
               		<blockquote>
               			{{$Expense->description}}
               		</blockquote>




			@if(isset($Expense))

			@if(strlen($Expense->file)>1)
			<br/>
			<a href="{{ asset("uploads/".$Expense->file) }}"  target="_blank" alt="logo"><button class="btn btn-primary"><i class="fas fa-file-pdf"></i>Download Document</button></a>
			@endif
			@endif
               </div>



           


             </div>

@if($Expense->status==2) 
<br/>
<br/>
             <div class="row">
             	  
               <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
               	           
               	<h3>Approved By : {{$Expense->updateData->name}}</h3>
         
               </div>
                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
               	           
               	<h3>Approved Date : {{date("d/m/Y",strtotime($Expense->created_at))}}</h3>
         
               </div>
               
             </div>
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