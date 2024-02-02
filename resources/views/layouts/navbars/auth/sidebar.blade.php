<?php 




use Illuminate\Support\Facades\Auth;



use App\Models\AssignMenu;

use App\Models\Menu;
use App\Models\User;
use App\Models\Setting;

$Setting = Setting::find(1);
$UserRole = User::findOrFail(Auth::id())->user_role;

function menuName($id=null,$column=null)
{

    $name = Menu::find($id);
    if($name)
    {
        return $name->$column;
    }
    else{

        return "";
    }

}

function showMenu($role=null)
{

    $MainMenu = AssignMenu::where("status",0)->where("user_id",$role)
        ->groupBy('origin_id')
        ->orderby("origin_id","asc")->get();
    $html='';
    if($MainMenu)
    {
        
        foreach($MainMenu as $item)
        {


$html.='<li class="nav-item">
<a data-bs-toggle="collapse" href="#ecomme'.$item->origin_id.'" class="nav-link collapsed" aria-controls="ecomme'.$item->origin_id.'" role="button" aria-expanded="false">
<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2" >
'.menuName($item->origin_id,"icon").'
</div>
<span class="nav-link-text ms-1"> '.menuName($item->origin_id,"title").'</span>
</a>
<div class="collapse" id="ecomme'.$item->origin_id.'" style="">';

$html.=levelOne($item->origin_id,$role); 

$html.='</div>
</li>';

                   
        } 
          

        
    }
    return $html; 

}


function levelOne($Origin=null,$role=null)
{
    $levelOne = AssignMenu::where("status",0)
        ->where("user_id",$role)
        ->where("origin_id",$Origin)
        ->groupBy('parent_id')
        ->orderby("parent_id","asc")->get();
        $html='';
    if($levelOne)
    {

    foreach($levelOne as $item)
    {
        $html.='<ul class="nav ms-4 ps-3">
<li class="nav-item ">
<a class="nav-link collapsed" data-bs-toggle="collapse" aria-expanded="false" href="#products'.$item->parent_id.'">
<span class="sidenav-mini-icon"> P </span>
<span class="sidenav-normal"> '.menuName($item->parent_id,"title").' <b class="caret"></b></span>
</a>
<div class="collapse" id="products'.$item->parent_id.'" style="">';
        $html.=levelTwo($Origin,$item->parent_id,$role);  
        $html.='</div>
</li>


</ul>';
       
    }
 

        
    }
    return $html;     

}


function levelTwo($Origin,$Parent,$role)
{

    $levelTwo = AssignMenu::where("status",0)
        ->where("user_id",$role)
        ->where("origin_id",$Origin)
        ->where("parent_id",$Parent)
        ->orderby("menu_id","asc")->get();
    $html='';    
    if($levelTwo)
    {
       $html.='<ul class="nav nav-sm flex-column">';
        foreach($levelTwo as $item)
        {   
            $url_path= menuName($item->menu_id,"action");
            $url =URL::to("/$url_path");
             $html.='
<li class="nav-item ">
<a class="nav-link " href="'.$url.'">
<span class="sidenav-mini-icon text-xs"> N </span>
<span class="sidenav-normal">'.$item->MenuData->title.' </span>
</a>
</li>

';   
        } 
        
        $html.='</ul>';
        

        
    }
    return $html;       


}

?>


<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
<div class="sidenav-header">
<i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
<a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{URL::to("/dashboard")}}">
<img src="https://soft-ui-dashboard-pro-laravel.creative-tim.com/assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
<span class="ms-3 font-weight-bold">{{$Setting->title}}</span>
</a>
</div>
<hr class="horizontal dark mt-0">
<div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">


<ul class="navbar-nav">

{!! showMenu($UserRole)!!}


 
      <li class="nav-link mb-0">
        <a href="{{ url('/logout')}}" class="btn btn-primary btn-md active px-5 text-white"  role="button" aria-pressed="true">
            <i class="fa fa-user me-sm-1"></i>
                    <span class="d-sm-inline d-none">Sign Out</span>
        </a>
      </li>
</ul>


</div>

</aside>








