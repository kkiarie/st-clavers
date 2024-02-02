@extends('layouts.user_type.auth')

@section('content')



@if(Auth::user()->user_role==3)
<div class="row">

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <a href="{{ URL::to("/student-performance-report") }}"> 
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">&nbsp;</p>
                <h5 class="font-weight-bolder mb-0">
                  Exam Results
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fa-solid fa-file-circle-check"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
    </div>



        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <a href="{{ URL::to("/fee-payment-history/".Auth::id()) }}"> 
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">&nbsp;</p>
                <h5 class="font-weight-bolder mb-0">
                  Fee Payment
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fa-solid fa-file-circle-check"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
    </div>







</div>  


@endif


@if(Auth::user()->user_role==1)
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Administrator</p>
                <h5 class="font-weight-bolder mb-0">
                  @livewire('admin-data')
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fa-solid fa-user"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
       <a href="{{ URL::to("/teachers") }}"> 
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Teacher</p>
                <h5 class="font-weight-bolder mb-0">
                    @livewire('teacher-data')
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fa-solid fa-children"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
    </div>  
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
       <a href="{{ URL::to("/students") }}"> 
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Students</p>
                <h5 class="font-weight-bolder mb-0">
                  @livewire('student-data')
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                
                <i class="fa-solid fa-user-graduate"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
    </div>        

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
       <a href="{{ URL::to("/parents") }}"> 
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Parents</p>
                <h5 class="font-weight-bolder mb-0">
                  @livewire('parents-data')
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                {{-- <i class="fa-solid fa-children"></i> --}}
                <i class="fa-solid fa-user"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
    </div>  
  </div>

@endif

@if(Auth::user()->user_role==4)
<h3>Parent Centre</h3>
  <div class="row my-4">


    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
@livewire('parent-hub-bio')
    </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <a href="{{ URL::to("/student-performance-report") }}"> 
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">&nbsp;</p>
                <h5 class="font-weight-bolder mb-0">
                  Exam Results
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fa-solid fa-file-circle-check"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card h-100">
        <div class="card-header pb-0">
         <a href="{{ URL::to("/parent-hub-diary") }}">
          <h5><i class="fa-solid fa-book-bookmark"></i> Diary </h5>
        </a>
        </div>
        <div class="card-body p-3">
          <h2 style="text-align: center;">@livewire('parent-diary')</h2>
        </div>
      </div>
    </div>
  </div> 
@endif


<div class="row">
  <div>
   @livewire('my-resourece-hub')
</div>
</div>
  <div class="row my-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h5>

                <a href="{{ URL::to("/my-notification") }}"><i class="fa-solid fa-bell"></i> Notifications
                </a>
              </h5>

            </div>

          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive">

            <table class="table align-items-center mb-0 table-striped">

              <tbody>
              

  
                {!! Notifications() !!}

              
              </tbody>
            </table>
            
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card h-100">
        <div class="card-header pb-0">
         <a href="{{ URL::to("/my-resources-hub") }}">
          <h5><i class="fa-solid fa-book-bookmark"></i> Resources </h5>
        </a>
        </div>
        <div class="card-body p-3">
          @livewire('resourcehub')
        </div>
      </div>
    </div>
  </div>

@endsection






<?php 
use App\Models\Notification;
use App\Models\SetupConfig;




function Notifications()
{
$html="";

$Include= SetupConfig::where("setup_id",1)->where("status",0)->get(['id'])->toArray();
if(Auth::user()->user_role==1):
$Bells= Notification::where("status",0)
->whereIN("user_role",$Include)
->orWhere("user_role",Auth::user()->user_role)
->orWhere("user_role",0)
->orderBy("id","desc")
->limit(3)
->get();

else:

$Bells= Notification::where("status",0)
->Where("user_role",Auth::user()->user_role)
->orWhere("user_role",0)
->orderBy("id","desc")
->limit(3)
->get();



endif;




foreach($Bells as $item):
$html.='<tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div>
                        <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="xd">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">'.$item->title.' 

                        <span style="color:#efefe;font-size:12px;font-weight:bold;padding:20px">'.$item->created_at->diffForHumans().'</span> </h6>

                        <div style="color:#474747;font-size:12px;font-weight:bold;padding:20px">'.$item->description.'</div>
                      </div>
                    </div>
                  </td>
                </tr>';


endforeach;

return $html;

}


?>

<style type="text/css">
  .table td, .table th{
    white-space:normal !important;
  }
</style>