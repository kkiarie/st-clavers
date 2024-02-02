<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
class ParentsData extends Component
{
    public function render()
    {
        $parent = User::where("status",0)->where("user_role",4)->count("id");
        return view('livewire.parents-data',compact("parent"));
    }
}
