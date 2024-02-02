<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ResourceHubMaterial;
class MyResoureceHub extends Component
{
    public function render()
    {
        $ResourceHubMaterials = ResourceHubMaterial::where("status",1)
        ->orderby("id","desc")
        ->limit(9)
        ->get(["id","program_unit_id","program_stage_id","file"]);
        return view('livewire.my-resourece-hub',compact("ResourceHubMaterials"));
    }
}
