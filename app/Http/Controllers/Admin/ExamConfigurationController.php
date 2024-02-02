<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SetupConfig;
use App\Models\StudentUnits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamConfiguration;
class ExamConfigurationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ExamConfigurations = ExamConfiguration::where("status",0)
        ->where("parent_id",0)->paginate(30);

        return view('admin.exam-config.index',compact('ExamConfigurations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        //

        $Examstype= SetupConfig::where("status",0)->where("setup_id",14)->get();
        if($id==0)
        {
            $child= ExamConfiguration::where("parent_id",0)
            ->where("status",0)
            ->orderby("id","desc")
            ->first();
            if(!$child)
            {
            $data = new ExamConfiguration();
            $data->title="Exam Setup";
            $data->parent_id=0;
            $data->status=0;
                if($data->save())
                {
                       return redirect('/exams-configuration/'.$data->id)->with('status','Record created.');
                }
            }
            else{


                return redirect('/exams-configuration/'.$child->id)->with('status','Record created.');
            }

        }
        else{
            $Record=ExamConfiguration::findOrFail($id);
            // $Exclusion=ExamConfiguration::where("status",0)
            // ->where("parent_id",$id)
            return view('admin.exam-config.create',compact('Record','Examstype'));
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

        $value = ExamConfiguration::where("status","!=",3)
        ->where("parent_id",$request->parent_id)
        ->sum('marks');
        $examsTotal=(int)$value;

        $validator = Validator::make($request->all(), [
            'item_id' => 'required|not_in:0',
            'marks' => 'required|max:100',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $data = new ExamConfiguration();
            $data->title="Exam Setup";
            $data->parent_id=$request->input('parent_id');
            $data->marks=$request->input('marks');
            $data->item_id=$request->input('item_id');
            $data->status=0;
                if($data->save())
                {
                       return redirect('/exams-configuration/'.$data->parent_id)->with('status','Record created.');
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
        
        $ExamConfiguration = ExamConfiguration::findOrFail($id);
        $ExamTotal = ExamConfiguration::where("status","!=",3)
        ->where("parent_id",$ExamConfiguration->id)
        ->sum('marks');
        $ExamConfigurationList=ExamConfiguration::where("parent_id",$id)
        ->where("status","!=",3)->get();
        return view('admin.exam-config.view',compact('ExamConfiguration','ExamConfigurationList','ExamTotal'));
    }

   

   
    public function destroy($id)
    {
        //

        $setup=ExamConfiguration::findOrFail($id);
        $setup->status=3;
        $setup->save();
        
        return redirect()->back()->with('error','record deleted.');
    }
}
