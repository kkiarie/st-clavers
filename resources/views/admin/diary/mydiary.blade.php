 @extends('layouts.user_type.auth')

@section('content')


<style type="text/css">
  .table td, .table th{
    white-space:normal !important;
  }
</style>

  <div class="row my-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6><i class="fa-solid fa-bell"></i> Diary</h6>

            </div>

          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0 table-striped">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">&nbsp;</th>
              
                </tr>
              </thead>
              <tbody>
@if(count($Bells)>0)  



@for($x=0;$x<count($Bells);$x++)


<tr>
<td>
<div class="d-flex px-2 py-1">
<div>
<img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="xd">
</div>
<div class="d-flex flex-column justify-content-center">

<h3 class="mb-0 text-sm">
<span style="color:#efefe;font-weight:bold;padding:20px">
  Student :: {{$Bells[$x]["user"]}}
</span> 

<span style="color:#efefe;font-weight:bold;padding:20px">
  Subject :: {{$Bells[$x]["subject"]}}
</span> 

<span style="color:#efefe;font-size:13px;font-weight:bold;padding:20px">
  {{$Bells[$x]["created_at"]->diffForHumans()}} 
  ({{date("d/m/Y H:i:s",strtotime($Bells[$x]["created_at"]))}})
</span> 
</h3>

<div style="color:#474747;font-size:15px;font-weight:bold;padding:20px">
  {{$Bells[$x]["description"]}}
</div>
</div>
</div>
</td>
</tr>



@endfor


@else

<p style="padding:20px">There are no item present in diary.</p>

@endif            

  
              

          
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection