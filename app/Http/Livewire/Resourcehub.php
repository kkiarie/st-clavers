<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ResourceHubMaterial;

class Resourcehub extends Component
{
    public function render()
    {
        $Resourcehub = ResourceHubMaterial::where("status",1)
        ->orderby("id","desc")
        ->limit(5)
        ->get(["id","program_unit_id","program_stage_id"]);
        return view('livewire.resourcehub',compact("Resourcehub"));
    }
}
