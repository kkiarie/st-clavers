<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\User;
use App\Models\AssignMenu;
use App\Models\SetupConfig;
class AssignMenuController extends BaseController
{


    public function index()
    {

        $Roles = SetupConfig::sortable()->where("status",0)
        ->where("setup_id",1)
        ->paginate(30);

        return view("admin.assign-menu.index",compact("Roles"));

    }

    public function create($id=null)
    {
        $Menus = AssignMenu::where("status",0)->where("user_id",$id)->get();
        $User=User::find($id);

        return view('admin.assign-menu.create',compact("Menus","User"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if($request->input("menu_id")==null)
        {

             return redirect('/roles/create/'.$request->input("user_id"))->with('error','Error. You need to choose a menu'); 
        }

        else
        {

            // return $request->all();
            $this->clearMenu($request->input("user_id"));

                    for($x=0; $x< count($request->input("menu_id")); $x++):
                        

                        $menuid= $request->input("menu_id")[$x];
                        $parent_id=Menu::find($menuid)->parent;
                        $origin_id=Menu::find($parent_id)->parent;

                        
                        $record = new AssignMenu();
                        $record->user_id= $this->cleanStr($request->input("user_id"));
                        $record->parent_id= $parent_id;
                        $record->menu_id= $menuid;
                        $record->origin_id= $origin_id;
                        $record->created_by= Auth::id();
                        $record->updated_by= Auth::id();
                        $record->status=0;
                        $record->save();
                    endfor;

                    return redirect('/roles')->with('status','System Roles updated.'); 

        }


        
    }

    public function clearMenu($id=null)
    {
        $record = AssignMenu::where("status",0)->where("user_id",$id)->update(["status" =>3]);

    }

   
}
