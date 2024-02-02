<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
class StudentData extends Component
{
    public function render()
    {
        $student = User::where("status",0)->where("user_role",3)->count("id");
        return view('livewire.student-data',compact("student"));
    }
}
