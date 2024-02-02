<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class MenuController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $Menus = Menu::sortable()->where("status",0)->where("parent",0)
        ->orderby("id","asc")->paginate(30);
        return view('admin.menu.index',compact("Menus"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null,$pid=null)
    {
        //
         return view('admin.menu.create');
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            
            $record = new Menu();
            $record->title= $this->cleanStr($request->input("title"));
            $record->action= $this->cleanStr($request->input("action"));
            $record->icon= $request->input("icon");
            $record->level= $this->cleanStr($request->input("level"));
            $record->parent= $this->cleanStr($request->input("parent"));
            $record->created_by= Auth::id();
            $record->updated_by= Auth::id();
            $record->status=0;
            if($record->save())
            {
                return redirect('/menu-setup')->with('status','Record created.'); 
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

        $Menu = Menu::find($id);
        $SubMenu = Menu::sortable()->where("status",0)
        ->where("parent",$Menu->id)
        ->orderby("id","asc")->paginate(10);

        return view("admin.menu.view",compact("Menu","SubMenu"));
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

        $Menu = Menu::find($id);

        return view("admin.menu.edit",compact("Menu"));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            
            $record =Menu::findOrFail($id);
            $record->title= $this->cleanStr($request->input("title"));
            $record->action= $this->cleanStr($request->input("action"));
            $record->icon= $request->input("icon");
            $record->updated_by= Auth::id();
            if($record->save())
            {
                return redirect('/menu-setup')->with('status','Record created.'); 
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

        $record= Menu::findOrFail($id);
        $record->status=3;
        $record->save();
        
        return redirect('/menu-setup')->with('error','record deleted.');
    }
}
