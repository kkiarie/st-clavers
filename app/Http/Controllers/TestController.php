<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NotificationMailService;
class TestController extends Controller
{
    //

    public function index()
    {




        \Mail::to("kkiarie4@gmail.com")
        ->queue(new NotificationMailService());

    }
}
