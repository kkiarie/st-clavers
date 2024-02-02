<?php 

 use App\Models\Menu;
 use App\Models\SetupConfig;
use App\Models\AssignMenu;
function mainMenu()
{
    $html="";
    $MainMenu = Menu::where("status",0)->where("parent",0)->where('level',0)
        ->orderby("id","asc")->get();
    foreach($MainMenu as $item):
    $html.='<div class="col-xl-6"><h2> '.$item->icon.' '.$item->title.'</h2>';
    $html.='<div class="row">'.mainMenu2($item->id).'</div>';
    $html.='</div>';
     endforeach;  
     
    return $html;  
}



function mainMenu2($id=null)
{

    $levelOne = Menu::where("status",0)->where("parent",$id)->where('level',1)
        ->orderby("id","asc")->get();
    $result='';    
    foreach($levelOne as $item):
    $result.='<div class="col-xl-12">';    
    $result.="<h4 style='margin-left:10px'><b> &raquo; $item->title</b></h4>"; 
    $result.='<div class="row">'.mainMenu3($item->id).'</div>'; 
    $result.='</div>';     
    endforeach;
    return $result;
}




function mainMenu3($id=null)
{

    $levelOne = Menu::where("status",0)->where("parent",$id)->where('level',2)
        ->orderby("id","asc")->get();
    $result='<ul style="margin-left:35px;padding:10px">';    
    foreach($levelOne as $item):  
    $result.="<li><input ".checkMenu($item->id)." type='checkbox' name='menu_id[]' value=$item->id> $item->title<br/></li>";  

    endforeach;
     $result.='</ul>';
    return $result;
}


function checkMenu($id=null)
{
    $role = AssignMenu::where("menu_id",$id)->where("user_id",Request::segment(3))->where("status",0)->first();
    if($role)
    {
        return "checked";
    }
    else{
        return "";
    }
}

function roleName($id=null)
{


$data = SetupConfig::find($id);
if($data)
{
    return $data->title;
}
else{

    return "";
}

}

?>




    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{$label}} :: <?php echo roleName(Request::segment(3))?>  </h6>
            </div>
            <div class="card-body pt-4 p-3">
@include('layouts.feedback')



<form method="post" action="{{ route('roles.store')}}" autocomplete="off">
<input type="hidden" name="user_id" value="{{Request::segment(3)}}">
{{ csrf_field() }}




<div class="row">
    <?php echo mainMenu()?>
</div>


                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">
                        {{ $button }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>