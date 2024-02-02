 @extends('layouts.user_type.auth')

@section('content')
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

  <div class="row my-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6><i class="fa-solid fa-bell"></i> Notification</h6>

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
@if(!$Bells->isEmpty())  



@foreach ($Bells as $item)


<tr>
<td>
<div class="d-flex px-2 py-1">
<div>
<img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="xd">
</div>
<div class="d-flex flex-column justify-content-center">
<h6 class="mb-0 text-sm">{{$item->title}}
<span style="color:#efefe;font-size:12px;font-weight:bold;padding:20px">{{$item->created_at->diffForHumans()}}</span> </h6>

<div style="color:#474747;font-size:12px;font-weight:bold;padding:20px">{{$item->description}}</div>
</div>
</div>
</td>
</tr>



@endforeach


@else

There are no notifcation

@endif            

  
              

          
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection