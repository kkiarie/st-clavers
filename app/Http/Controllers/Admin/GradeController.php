<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
use App\Models\Menu;
use App\Models\SetupConfig;

class GradeController extends BaseController
{
    public function index()
    {
        //

        $Grades = Grade::sortable()->where("status",0)
        ->orderby("id","asc")->paginate(30);
        $GradesList= Grade::where("status",0)->get();
        return view('admin.grades.index',compact("Grades","GradesList"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $Remarks= SetupConfig::where("status",0)->where("setup_id",3)->get();
        $Grades= SetupConfig::where("status",0)->where("setup_id",4)->get();
        return view('admin.grades.create',compact("Remarks","Grades"));

    }


    public function gradesQuery(Request $request)
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
         $results = Grade::find($value);


        return redirect('/grades/'.$results->id."/edit")->with('status','Record found.'); 


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
            // 'points' => 'required',
            'points_closing' => 'required',
            'points_opening' => 'required',
            'grade_id' => 'required',
            'remark_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = new Grade();
            $record->points= $this->cleanStr($request->input("points"));
            $record->points_closing= $this->cleanStr($request->input("points_closing"));
            $record->points_opening= $this->cleanStr($request->input("points_opening"));
            $record->grade_id= $this->cleanStr($request->input("grade_id"));
            $record->remark_id= $this->cleanStr($request->input("remark_id"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
    
            $record->status=0;
     
            


            if($record->save())
            {
                return redirect('/grades')->with('status','Record updated.'); 
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
        $Grade= Grade::findOrFail($id);
        $Remarks= SetupConfig::where("status",0)->where("setup_id",3)->get();
        $Grades= SetupConfig::where("status",0)->where("setup_id",4)->get();
        return view('admin.grades.edit',compact("Grades","Grade","Remarks"));
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
            // 'points' => 'required',
            'points_closing' => 'required',
            'points_opening' => 'required',
            'grade_id' => 'required',
            'remark_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = Grade::findOrFail($id);
            $record->points= $this->cleanStr($request->input("points"));
            $record->points_closing= $this->cleanStr($request->input("points_closing"));
            $record->points_opening= $this->cleanStr($request->input("points_opening"));
            $record->grade_id= $this->cleanStr($request->input("grade_id"));
            $record->remark_id= $this->cleanStr($request->input("remark_id"));
            $record->updated_by= Auth::id();

            if($record->save())
            {
                return redirect('/grades')->with('status','Record updated.'); 
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
