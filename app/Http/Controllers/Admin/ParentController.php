<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Menu;
use App\Models\SetupConfig;
use Illuminate\Support\Str;
use Carbon\Carbon;
class ParentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $Parents = User::sortable()->where("user_role",4)
        ->orderby("id","asc")->paginate(30);
        $Clients= User::where("status",0)->where("user_role",4)->get();
        return view('admin.parent.index',compact("Parents","Clients"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $GenderList= SetupConfig::where("status",0)->where("setup_id",2)->get();
        $ParentRoleList= SetupConfig::where("status",0)->where("setup_id",11)->get();
        return view('admin.parent.create',compact("GenderList","ParentRoleList"));

    }


    public function parentQuery(Request $request)
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
         $results = User::find($value);


        return redirect('/parents/'.$results->id."/edit")->with('status','Record found.'); 


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
            'name' => 'required',
            'phone' => 'required',
            'parental_role'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = new User();
            if ($request->hasFile('logo')) {

            $image = $request->file('logo');
            $filename = time()."_".$image->getClientOriginalName();
            $filename=preg_replace('/\s+/', '', $filename);

            $request->logo->move(public_path('uploads'),$filename);
            $record->file= $filename;
           
            }
            else{

            $record->file= 0;

            }

        if(isset($email))
        {
            $p=Str::random(9);
            $record->phone= $this->cleanStr($request->input("phone"));
            $record->name= $this->cleanStr($request->input("name"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->temp_password=$p;
            $record->password=Hash::make($p);
             $record->email= $email;
            $record->status=1;
             $record->with_email=0;
            $record->user_role=4;
            $record->gender= $this->cleanStr($request->input("gender"));
            $record->dob= $this->cleanStr($request->input("dob"));
            $record->parental_role= $this->cleanStr($request->input("parental_role"));

        }else{

            $record->phone= $this->cleanStr($request->input("phone"));
            $record->name= $this->cleanStr($request->input("name"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
             $record->with_email=1;
             $record->email=time()."@mail.com";
            $record->user_role=4;
            $record->gender= $this->cleanStr($request->input("gender"));
            $record->dob= $this->cleanStr($request->input("dob"));
            $record->parental_role= $this->cleanStr($request->input("parental_role"));

        } 


            


            if($record->save())
            {
                if(isset($record->email))
                {
                    dispatch(new \App\Jobs\MailOnboardingJob($record))
                    ->delay(Carbon::now()
                    ->addSeconds(20)); 
                }
                return redirect('/parents')->with('status','Record updated.'); 
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
        $Parent= User::findOrFail($id);
        $GenderList= SetupConfig::where("status",0)->where("setup_id",2)->get();
        $ParentRoleList= SetupConfig::where("status",0)->where("setup_id",11)->get();
        return view('admin.parent.edit',compact("GenderList","Parent","ParentRoleList"));
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
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = User::findOrFail($id);
            if ($request->hasFile('logo')) {

            $image = $request->file('logo');
            $filename = time()."_".$image->getClientOriginalName();
            $filename=preg_replace('/\s+/', '', $filename);

            $request->logo->move(public_path('uploads'),$filename);
            $record->file= $filename;
           
            }
            


            $record->name= $this->cleanStr($request->input("name"));
            $record->dob= $this->cleanStr($request->input("dob"));
            $record->gender= $this->cleanStr($request->input("gender"));
            $record->updated_by= Auth::id();
            $record->status=0;
            $record->user_role=4;
             $record->phone= $this->cleanStr($request->input("phone"));
            $record->parental_role= $this->cleanStr($request->input("parental_role"));
            


            if($record->save())
            {
                return redirect('/parents')->with('status','Record updated.'); 
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
}
