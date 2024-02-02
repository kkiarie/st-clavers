<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class BaseController extends Controller
{
    public function __construct()
    {

      
        
        // dd(Auth::user());
        // $User = User::find($ID);
        // if($User)
        // {
        //     $group_id=(int)$User->group;
        //     dd($group_id);
            
        //     if($group_id==0)
        //     {

        //     Auth::logout();
        //     return redirect('/');
        //     }
        // }


        // else{
        //      Auth::logout();
        //     return redirect('/');
        // }

    }

    public function cleanStr($str=null)
    {
        return $str;
    }
}
