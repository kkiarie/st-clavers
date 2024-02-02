<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;
use App\Models\Menu;
use App\Models\StudentAttendance;
use PDF;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
class StudentAttendanceController extends Controller
{
    //


    public function attendanceGen($id=null)
    {
        
        $data = StudentAttendance::where("status",0)->where("uid",$id)->first();
        if($data->status==0)
        {
            dispatch(new \App\Jobs\SmsQrCodeJob($data))
                    ->delay(Carbon::now()
                    ->addSeconds(20)); 
        }
        
         
    }


    public function attendanceValidate($id=null)
    {
        $data=explode("_",$id);

        // print_r($data);
        $uid=$data[0];
        $parent=$data[1];
        $record = StudentAttendance::where("status",0)->where("uid",$id)->first();
        if($record)
        {
        $record->status=1;
        $record->parent_id=$parent;
        $record->save();
        }
        
    }
}
