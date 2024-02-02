<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\SetupConfig;
use App\Models\ProgramSubject;
use PDF;


class ProgramController extends BaseController
{
    public function index()
    {
        //

        $Programs = Program::sortable()->where("status",0)
        ->orderby("id","asc")->paginate(30);
        $ProgramsList= Program::where("status",0)->get();
        return view('admin.program.index',compact("Programs","ProgramsList"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        $ProgramCategory= SetupConfig::where("status",0)->where("setup_id",6)->get();
        return view('admin.program.create',compact("ProgramCategory"));

    }


    public function programQuery(Request $request)
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
         $results = Program::find($value);


        return redirect('/program/'.$results->id."/edit")->with('status','Record found.'); 


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
            'description' => 'required',
            'period' => 'required',
            'cost' => 'required',
            'program_level' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = new Program();
            $record->name= $this->cleanStr($request->input("name"));
            $record->description= $this->cleanStr($request->input("description"));
            $record->period= $this->cleanStr($request->input("period"));
            $record->cost= $this->cleanStr($request->input("cost"));
            $record->program_level= $this->cleanStr($request->input("program_level"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
     
            


            if($record->save())
            {
                return redirect('/program')->with('status','Record updated.'); 
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
        $Program= Program::findOrFail($id);
        $ProgramSubjects= ProgramSubject::sortable()->where("status",0)->where("program_id",$Program->id)->paginate(30);
        return view('admin.program.view',compact("Program","ProgramSubjects"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Program= Program::findOrFail($id);
        $ProgramCategory= SetupConfig::where("status",0)->where("setup_id",6)->get();
        return view('admin.program.edit',compact("Program","ProgramCategory"));
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
            'description' => 'required',
            'period' => 'required',
            'cost' => 'required',
            'program_level' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
       
            $record = Program::findOrFail($id);
            $record->name= $this->cleanStr($request->input("name"));
            $record->description= $this->cleanStr($request->input("description"));
            $record->period= $this->cleanStr($request->input("period"));
            $record->cost= $this->cleanStr($request->input("cost"));
            $record->program_level= $this->cleanStr($request->input("program_level"));
            $record->updated_by= Auth::id();
            if($record->save())
            {
                return redirect('/program')->with('status','Record updated.'); 
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

        $record= Program::findOrFail($id);
        $record->status=3;
        if($record->save())
        {

             return redirect('/program')->with('status','Record deleted.'); 
        }
    }

    public function pdf($id=null)
    {

        
        $setting= Setting::find(1);
        $record= Program::findOrFail($id);
         $title=$record->name;
        $ProgramSubjects= ProgramSubject::where("status",0)
        ->where("program_id",$record->id)->get();
        $pdf = PDF::loadView('report.program',compact('setting','record','ProgramSubjects','title'))->setPaper('A4', 'potrait');
       return $pdf->stream("Program_Print".time().".pdf");
    }
}
