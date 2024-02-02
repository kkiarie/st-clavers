<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class SettingController extends BaseController
{

    public function index()
    {
        //


        //         DB::table('settings')->insert([
        //     'title' => Str::random(10),
        // ]);
        $id=1;
        $Setting = Setting::find($id);
        return view("admin.setting.edit",compact("Setting"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
         $currentValue=User::where("user_role",3)
         ->orderby("id","desc")->first()->admission_no;   
         $validator = Validator::make($request->all(), [
            'title' => 'required',
            'email_address' => 'required|email',
            'kra_pin' => 'required',
            'phone_number' => 'required',
            'width' => 'required',
            'school_motto' => 'required',
            'logo'=>'mimes:jpeg,png,jpg,gif|max:2048',
            'admission_no'=>'required|numeric|min:'.(int)$currentValue,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $id=1;
            $admission_no=$this->cleanStr($request->input("admission_no"));
            $record = Setting::find($id);
            if ($request->hasFile('logo')) {

            $image = $request->file('logo');
            $filename = time()."_".$image->getClientOriginalName();
            $filename=preg_replace('/\s+/', '', $filename);

            $request->logo->move(public_path('uploads'),$filename);
            $record->title= $this->cleanStr($request->input("title"));
            $record->email_address= $this->cleanStr($request->input("email_address"));
            $record->kra_pin= $this->cleanStr($request->input("kra_pin"));
            $record->postal_address= $this->cleanStr($request->input("postal_address"));
            $record->phone_number= $this->cleanStr($request->input("phone_number"));
            $record->physical_address= $this->cleanStr($request->input("physical_address"));
            $record->logo= $filename;
            $record->updated_by= Auth::id();
            $record->width= $this->cleanStr($request->input("width"));
            $record->school_motto= $this->cleanStr($request->input("school_motto"));
            $record->admission_no= $admission_no;
  
            }
            else{


            $record->title= $this->cleanStr($request->input("title"));
            $record->email_address= $this->cleanStr($request->input("email_address"));
            $record->kra_pin= $this->cleanStr($request->input("kra_pin"));
            $record->postal_address= $this->cleanStr($request->input("postal_address"));
            $record->phone_number= $this->cleanStr($request->input("phone_number"));
            $record->width= $this->cleanStr($request->input("width"));
            $record->physical_address= $this->cleanStr($request->input("physical_address"));
            // $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
             $record->school_motto= $this->cleanStr($request->input("school_motto"));
 $record->admission_no= $admission_no;

            }


            


            if($record->save())
            {
                return redirect('/setting')->with('status','Record updated.'); 
            }


        }
    }


}
