<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Diary;
use App\Models\SetupConfig;
use App\Models\SubjectCluster;

class SubjectClusterController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $SubjecClusters= SubjectCluster::sortable()->where("parent_id",0)
        ->where("status",0)
        ->paginate(30);


        return view('admin.subject-cluster.index',compact("SubjecClusters"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        //

        $SubjectList = SetupConfig::where("status",0)->where("setup_id",5)
        ->get();

        $ClassList = SetupConfig::where("status",0)->where("setup_id",7)
        ->get();

         return view('admin.subject-cluster.create',compact("SubjectList","ClassList"));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $parent_id=$request->input("parent_id");

        if($parent_id==0)
        {
            $validator = Validator::make($request->all(), [
                'title' => 'required|not_in:0',
                'class_id' => 'required|not_in:0',

            ]);
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'subject_id' => 'required|not_in:0',

            ]);
        }



        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            if($parent_id==0)
            {
                $record = new SubjectCluster();
                $record->title= $this->cleanStr($request->input("title"));
                $record->parent_id= $this->cleanStr($request->input("parent_id"));
                $record->class_id= $this->cleanStr($request->input("class_id"));
                $record->created_by= Auth::id();
                $record->updated_by= Auth::id();
                $record->status=0;
                if($record->save())
                {
                return redirect('/subject-clusters/create/'.$record->id)->with('status','Record add subject clusters.'); 
                }              
            }
            else{

                $subjects =$request->input("subject_id");


                SubjectCluster::where("status",0)
                ->where("parent_id",$parent_id)
                ->update(["status"=>3]);
                $Parent=SubjectCluster::findOrFail($parent_id);


                for($x=0;$x<count($subjects);$x++)
                {
                    $record = new SubjectCluster();
                    $record->title= "";
                    $record->parent_id= $parent_id;
                    $record->class_id=$Parent->class_id;
                    $record->created_by= Auth::id();
                    $record->updated_by= Auth::id();
                    $record->status=0;
                    $record->subject_id=$subjects[$x];
                    $record->save();
                }

                return redirect('/subject-clusters/create/'.$parent_id)->with('status','Record add subject clusters.');

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
        //
        $SubjectCluster = SubjectCluster::findOrFail($id);
         $ClassList = SetupConfig::where("status",0)->where("setup_id",7)
        ->get();
        return view('admin.subject-cluster.edit',compact("SubjectCluster","ClassList"));
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
                'title' => 'required|not_in:0',
                'class_id' => 'required|not_in:0',

            ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $record = SubjectCluster::findOrFail($id);
            $record->title=$request->input("title");
            $record->class_id= $this->cleanStr($request->input("class_id"));
            if($record->save())
            {
                SubjectCluster::where("parent_id",$record->id)
                ->where("status",0)
                ->update(["class_id"=>$record->class_id]);

                return redirect('/subject-clusters/')->with('status','Record updated.');
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
