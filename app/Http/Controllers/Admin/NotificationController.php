<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;
use App\Models\SetupConfig;

class NotificationController extends BaseController
{
    public function index()
    {
        //

        $Notifications = Notification::sortable()->where("status","!=",3)
        ->orderby("id","asc")->paginate(50);
        $NotificationList= Notification::where("status",0)->get();
        return view('admin.notifications.index',compact("Notifications","NotificationList"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        $Roles= SetupConfig::where("status",0)->where("setup_id",1)->get();
        return view('admin.notifications.create',compact("Roles"));

    }


    public function notificationQuery(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'value' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

         $value = strtoupper($this->cleanStr($request->input("value")));
         $results = Notification::find($value);


        return redirect('/notification/'.$results->id."/edit")->with('status','Record found.'); 


        }

   
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


        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'user_role' => 'required',
            'institution_role' => 'required',
            'date' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = new Notification();
            $record->title= $this->cleanStr($request->input("title"));
            $record->date= $this->cleanStr($request->input("date"));
            $record->description= $this->cleanStr($request->input("description"));
            $record->user_role= $this->cleanStr($request->input("user_role"));
            $record->institution_role= $this->cleanStr($request->input("institution_role"));

            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
    
            $record->status=0;
     
            


            if($record->save())
            {
                if($record->user_role==4)
                {
                    $this->sendparent($record->description);
                }
                return redirect('/notification')->with('status','Record created.'); 
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Notification= Notification::findOrFail($id);
         $Roles= SetupConfig::where("status",0)->where("setup_id",1)->get();
        return view('admin.notifications.edit',compact("Notification","Roles"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'user_role' => 'required',
            'date' => 'required',
            'institution_role' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = Notification::findOrFail($id);
            $record->title= $this->cleanStr($request->input("title"));
            $record->description= $this->cleanStr($request->input("description"));
            $record->user_role= $this->cleanStr($request->input("user_role"));
            $record->date= $this->cleanStr($request->input("date"));
            $record->institution_role= $this->cleanStr($request->input("institution_role"));
            $record->updated_by= Auth::id();

            if($record->save())
            {
                if($record->user_role==4)
                {
                    $this->sendparent($record->description);
                }
                return redirect('/notification')->with('status','Record updated.'); 
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendparent($message=null)
    {

        $Parents = User::where("status",0)
         ->where("user_role",4)
        ->orderby("id","asc")->get();

        if($Parents)
        {

            foreach($Parents as $item)
            {

                $this->sendText($item->phone,"Hi $item->name \n".$message);
            }
        }
    }


    public function sendText($number,$message){

        $recipients=$number;
        try {
            $url="https://api.africastalking.com/restless/send?username=int&Apikey=9900aac922922643c1a34792ad1be8df2c5411b33f372192d37357486d81b16b&to=$recipients&message=".urlencode($message);

                // exit();
                $filename = $url;
                $ch = curl_init();
                curl_setopt ($ch, CURLOPT_URL, $filename);
                curl_setopt($ch, CURLOPT_HEADER, 1 );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resp = curl_exec($ch);
                  if (!curl_errno($ch)) {
                  $info = curl_getinfo($ch);
                  return json_encode($resp);
                }
                curl_close($ch);
                
                }
                 catch(Exception $e) {
                
                 
                }
      }
      



    public function mynotification()
    {



        $Include= SetupConfig::where("setup_id",1)->where("status",0)->get(['id'])->toArray();
        if(Auth::user()->user_role==1):
        $Bells= Notification::where("status",0)
        ->whereIN("user_role",$Include)
        ->orWhere("user_role",Auth::user()->user_role)
        ->orWhere("user_role",0)
        ->orderBy("id","desc")
        ->paginate(30);

        else:

        $Bells= Notification::where("status",0)
        ->Where("user_role",Auth::user()->user_role)
        ->orWhere("user_role",0)
        ->orderBy("id","desc")
        ->paginate(30);

        endif;

        return view("admin.notifications.mynotification",compact("Bells"));
    }
}
