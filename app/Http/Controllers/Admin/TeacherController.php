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
class TeacherController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function teachersImport()
    {
        return view('admin.teacher.import');
    }

     public function teacherImportProc(Request $request)
    {


        $validator = Validator::make($request->all(), [
            // 'grade'=>'required|not_in:0',
            'document' => 'required|mimes:csv',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

$errors=array();
              $image = $request->file('document');
            if ($image) {
            $image = $request->file('document');
            $filename = time()."_".$image->getClientOriginalName();
            $filename=preg_replace('/\s+/', '', $filename);
            $request->document->move(public_path('uploads'),$filename);
            $filepath = public_path("uploads" . "/" . $filename);
            // Reading file
            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;
            //Read the contents of the uploaded file 
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
            // Skip first row (Remove below comment if you want to skip the first row)
            if ($i == 0) {
            $i++;
            continue;
            }
            for ($c = 0; $c < $num; $c++) {
            $importData_arr[$i][] = $filedata[$c];
            }
            $i++;
            }
            fclose($file); //Close after reading
            $j = 0;

            // return $importData_arr;
           
            // $grade = $request->input("grade");
            
            // $error
            $d=0;
            

            // return $importData_arr;
            foreach ($importData_arr as $importData) {
                $d++;
                // echo $im
                $email=$importData[1];
                $check=User::where("email",$email)->first();
                if(!$check)
                {
                $data = new User();
                $data->name=$importData[0];
                $data->email=$email;
                $data->password=Hash::make("secret123");
                $data->user_role=2;
                $data->status=1;
                $data->with_email=0;
                $data->temp_password=Hash::make("secret123");
                $data->created_by=Auth::id();
                $data->updated_by=Auth::id();
                $data->save(); 
                }
                else{
                    $errors[]=[
                        "invalid"=>$email
                    ];

                }


    


            }

            if(count($errors)>0)
            {
                return redirect('/teachers')->with('error','Import complete with errors.'.json_encode($errors)); 
            }
            else{

                return redirect('/teachers')->with('status','Import complete.'); 
            }


            


        }
    }

}


    public function index()
    {
        //
        
        $Teachers = User::sortable()->where("user_role",2)
        ->orderby("id","desc")->paginate(70);

        // dd($Teachers);
        $Clients= User::where("status",0)->where("user_role",2)->get();
        return view('admin.teacher.index',compact("Teachers","Clients"));
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
        return view('admin.teacher.create',compact("GenderList"));

    }


    public function teachersQuery(Request $request)
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


        return redirect('/teachers/'.$results->id."/edit")->with('status','Record found.'); 


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
        $email=$request->input("email");
        if(isset($email))
        {
          $validator = Validator::make($request->all(), [
            'name' => 'required',
            'dob' => 'required',
            'email'=>'email|unique:users,email'
        ]);
          
        }
        else{

            $validator = Validator::make($request->all(), [
            'name' => 'required',
            'dob' => 'required',
            ]);

        }


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
            $record->name= $this->cleanStr($request->input("name"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->email= $email;
            $record->status=1;
            $record->user_role=2;
          $record->temp_password=$p;
            $record->password=Hash::make($p);
            $record->gender= $this->cleanStr($request->input("gender"));
            $record->dob= $this->cleanStr($request->input("dob"));
            $record->admission_no= $this->cleanStr($request->input("admission_no"));
             $record->phone= $this->cleanStr($request->input("phone"));
            $record->with_email=0;
          
        }
        else{

            $record->name= $this->cleanStr($request->input("name"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
            $record->user_role=2;
            $record->with_email=1;
            $record->gender= $this->cleanStr($request->input("gender"));
            $record->dob= $this->cleanStr($request->input("dob"));
            $record->admission_no= $this->cleanStr($request->input("admission_no"));
             $record->email=time()."@mail.com";
             $record->phone= $this->cleanStr($request->input("phone"));
        }


            if($record->save())
            {
                if(isset($record->email))
                {
                    dispatch(new \App\Jobs\MailOnboardingJob($record))
                    ->delay(Carbon::now()
                    ->addSeconds(20)); 
                }
                return redirect('/teachers')->with('status','Record created.'); 
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
        $Teacher= User::findOrFail($id);
        $GenderList= SetupConfig::where("status",0)->where("setup_id",2)->get();
        return view('admin.teacher.edit',compact("GenderList","Teacher"));
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
            'dob' => 'required',
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
            $record->user_role=2;
 $record->phone= $this->cleanStr($request->input("phone"));
            $record->admission_no= $this->cleanStr($request->input("admission_no"));
            


            if($record->save())
            {
                return redirect('/teachers')->with('status','Record updated.'); 
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
