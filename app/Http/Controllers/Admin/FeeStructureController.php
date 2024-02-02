<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\Program;

use App\Models\SetupConfig;
use App\Models\FeeStructure;
use PDF;
use App\Models\FeePayment;
class FeeStructureController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdf($id=null)
    {
        $setting= Setting::find(1);
        $FeeStructure = FeeStructure::findOrFail($id);
        $FeeStructureItems = FeeStructure::sortable()->where("status","!=",3)
        ->where("parent_id",$FeeStructure->id)
        ->get();
        $Amount =FeeStructure::where("status","!=",3)
        ->where("parent_id",$FeeStructure->id)
        ->sum("amount");
      
    $title="Fee Structure";

$pdf = PDF::loadView('report.fee-structure',compact('setting',"FeeStructure","FeeStructureItems","Amount",'title'))->setPaper('A4', 'potrait');
       return $pdf->stream("Fee_Structure".time().".pdf");

    }
    public function index()
    {
        //

        // FeeStructure::truncate();
        // FeePayment::truncate();

        $FeeStructures = FeeStructure::sortable()
        ->where("status","!=",3)
        ->where("parent_id",0)
        ->paginate(50);


        return view("admin.fee-structure.index",compact("FeeStructures"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        //
        $parent_id=$id;
$ProgramList = Program::where("status",0)->get();
        $Exclusion=FeeStructure::where("parent_id",$parent_id)
        ->where("status","!=",3)
        ->get(["fee_item"])->toArray();
        $ClassList=SetupConfig::where("status",0)->where("setup_id",7)
        ->get(["id","title"]);
        $StageList=SetupConfig::where("status",0)->where("setup_id",9)
        ->get(["id","title"]);
        $FeeItems=SetupConfig::where("status",0)->where("setup_id",12)
        ->whereNotIn("id",$Exclusion)
        ->get(["id","title"]);
        return view("admin.fee-structure.create",compact("parent_id","ClassList","StageList","FeeItems","ProgramList"));
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


        $program_id=$this->cleanStr(strtoupper($request->input("program_id")));
        $parent_id=$this->cleanStr(strtoupper($request->input("parent_id")));
        $amount=$this->cleanStr(strtoupper($request->input("amount")));
        $academic_year=date("Y");
        $academic_stage_id=$this->cleanStr(strtoupper($request->input("academic_stage_id")));
        $class_program=$this->cleanStr(strtoupper($request->input("class_program")));
        $fee_item=$this->cleanStr(strtoupper($request->input("fee_item")));

        if($parent_id==0)
        {
        $validator = Validator::make($request->all(), [
            'class_program' => 'required|not_in:0',
            'academic_stage_id' => 'required|not_in:0',
            'program_id' => 'required|not_in:0',
        ]);

        $entry=FeeStructure::where("academic_year",$academic_year)
            ->where("academic_stage_id",$academic_stage_id)
            ->where("program_id",$program_id)
            ->where("class_program",$class_program)
            ->orderBy("id","desc")
            ->first();
            if($entry)
            {


            return redirect()->back()->with('error','This setup already exist.');

            }   

        }
        else{
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'fee_item' => 'required|not_in:0',
        ]);

        }


        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

    
            $record = new FeeStructure();
            $record->fee_item= $fee_item;
            $record->amount= $amount;
            $record->academic_stage_id= $academic_stage_id;
            $record->class_program= $class_program;
            $record->parent_id= $parent_id;
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->academic_year=$academic_year;
            $record->program_id=$program_id;
            $record->status=0;
            if($record->save())
            {

                if($record->parent_id>0)
                {
                     return redirect('/fee-structure/'.$record->parent_id)->with('status','Record updated.');
                }
                else{

                    return redirect('/fee-structure/'.$record->id)->with('status','Record updated.');
                }
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
        $FeeStructure = FeeStructure::findOrFail($id);
        $FeeStructureItems = FeeStructure::sortable()->where("status","!=",3)
        ->where("parent_id",$FeeStructure->id)
        ->get();
        $Amount =FeeStructure::where("status","!=",3)
        ->where("parent_id",$FeeStructure->id)
        ->sum("amount");
        if($FeeStructure->status==1)
        {
            return view("admin.fee-structure.preview",compact("FeeStructure","FeeStructureItems","Amount"));
        }
        else{

            return view("admin.fee-structure.view",
                compact("FeeStructure","FeeStructureItems","Amount"));
        }
    }

   
    public function destroy($id)
    {
        //

        $record= FeeStructure::findOrFail($id);
        $record->status=3;
        if($record->save())
        {
            return redirect()->back()->with('error','item has been removed succesfully.');
        }
    }


        public function complete($id)
    {
        //

        $record= FeeStructure::findOrFail($id);
        $record->status=1;
        if($record->save())
        {   $data= FeeStructure::where("parent_id",$record->id)->where("status",0)
            ->update(["status"=>1]);
            return redirect()->back()->with('success','Record updated succesfully.');
        }
    }
}
