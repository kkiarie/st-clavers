<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Menu;
use Carbon\Carbon;
class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $MyGroup=User::find(Auth::id())->group;
        $Users = User::orderby("id","asc")->paginate(30);
        return view('admin.users.index',compact("Users","MyGroup"));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.users.create');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'group' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            // $id=1;
            $record = new User();
           //  if ($request->hasFile('signature')) {
           //  $signature = $request->file('signature');
           //  $filename = time()."_".$signature->getClientOriginalName();
           //  $filename=preg_replace('/\s+/', '', $filename);
           //  $request->signature->move(public_path('uploads'),$filename);
        
           //  $record->signature= $filename;

  
           //  }
           //  else{


           // $record->signature=0;
      


           //  }


            $record->name= $this->cleanStr($request->input("name"));
            $record->email= $this->cleanStr($request->input("email"));
            $record->group= $this->cleanStr($request->input("group"));
            $record->signature= $this->cleanStr($request->input("signature"));
            // $record->group= 1;
            $record->password=Hash::make($request->input("password"));
            $record->status= 0;
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();

            if($record->save())
            {
                return redirect('/system-users')->with('status','Record created.'); 
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
        $User = User::findOrFail($id);
         $SubMenu = Menu::where("status",0)
        ->where("parent",1000)
        ->orderby("id","asc")->paginate(10);
        return view('admin.users.view',compact('User','SubMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
         $User = User::find($id);

        return view("admin.users.edit",compact("User"));
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
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8'],
            'group' => 'required|not_in:0',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{



            
            $record = User::find($id);
        //             if ($request->hasFile('signature')) {
        // $signature = $request->file('signature');
        // $filename = time()."_".$signature->getClientOriginalName();
        // $filename=preg_replace('/\s+/', '', $filename);
        // $request->signature->move(public_path('uploads'),$filename);

        // $record->signature= $filename;


        // }
        // else{


        // $record->signature=0;



        // }
        //     $record->name= $this->cleanStr($request->input("name"));
            $record->group= $this->cleanStr($request->input("group"));
            $record->status= $this->cleanStr($request->input("status"));
            $record->status= $this->cleanStr($request->input("status"));
            $record->updated_by= Auth::id();
            $record->signature= $this->cleanStr($request->input("signature"));

            if($record->save())
            {
                return redirect('/system-users')->with('status','Record created.'); 
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
        $record= User::findOrFail($id);
        $record->status=3;
        $record->save();
        
        return redirect("/system-users")->with('error','record disabled.'); 
    }

    public function resetpassword($id=null)
    {
        $User= User::find($id);
        return view('admin.users.resetpassword',compact("User"));
    }

    public function resetpasswordUpdate(Request $request)
    {


        $validator = Validator::make($request->all(), [
            
            'password' => ['required', 'string', 'min:8'],
          
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
             $id=$request->input("user_id");
            $record = User::find($id);
            $record->password=Hash::make($request->input("password"));
            $record->status= 0;
            $record->updated_by= Auth::id();

            if($record->save())
            {
                return redirect('/system-users')->with('status','Record created.'); 
            }


        }
        
    }
}
