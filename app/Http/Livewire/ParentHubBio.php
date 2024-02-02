<?php

namespace App\Http\Livewire;
use App\Models\StudentParent;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class ParentHubBio extends Component
{
    public function render()
    {
        $kids=StudentParent::where("status",0)
        ->where("parent_id",Auth::id())
        ->count("id");
        return view('livewire.parent-hub-bio',compact('kids'));
    }
}
