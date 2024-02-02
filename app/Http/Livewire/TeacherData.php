<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
class TeacherData extends Component
{
    public function render()
    {
        $teacher = User::where("status",0)->where("user_role",2)->count("id");
        return view('livewire.teacher-data',compact("teacher"));
    }
}
