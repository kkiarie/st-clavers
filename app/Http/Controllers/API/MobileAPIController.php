<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class MobileAPIController extends Controller
{
    //


    public function notificationFeed()
    {

        $Feeds = Notification::where("status",0)
        ->orderby("id","desc")
        ->get();

        if($Feeds)
        {
              return response([
                  
                        "status"=>1,
                        "body"=>$Feeds,

                    ],200
                    );
        }
        else{

            return  response([
                        "body"=>"No Data",
                        "status"=>0
                    ],422);
        }
    }
}
