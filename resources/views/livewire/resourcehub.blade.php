<div wire:poll>

@if(!$Resourcehub->isEmpty())  

    @foreach($Resourcehub as $item)
            <div class="timeline timeline-one-side">
            <div class="timeline-block mb-3">
            <span class="timeline-step">

            <i class="fa-solid fa-bookmark text-primary text-gradient"></i>
            </span>
            <div class="timeline-content">
            <h6 class="text-dark text-sm font-weight-bold mb-0"> {{dataTitle($item->program_unit_id)}}</h6>
            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                    {{dataTitle($item->program_stage_id)}}
                    
            </p>
            </div>
            </div>
            </div>
    @endforeach        

@else

<p>No Materials have been upload yet.</p>

@endif


</div>


<?php

use App\Models\SetupConfig;
function dataTitle($id=null)
{

    $data = SetupConfig::find($id);
    if($data)
    {
        return $data->title;
    }
    else{

        return "";
    }
}
?>