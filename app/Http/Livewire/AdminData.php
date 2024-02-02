<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
class AdminData extends Component
{
    public function render()
    {

        $admin = User::where("status",0)->where("user_role",1)->count("id");
        return view('livewire.admin-data',compact("admin"));
    }
}
