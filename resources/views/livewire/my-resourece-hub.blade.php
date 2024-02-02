<div wire:poll>
        <br/>
     <h3>Resources Material</h3>
     <br/>
      <div class="row" style="">
   

    @if(!$ResourceHubMaterials->isEmpty())
    @foreach($ResourceHubMaterials as $item)
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
   <a href="{{ asset("uploads/".$item->file) }}" target="_blank">   
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">{{dataTitle2($item->program_unit_id)}}</p>
                <h5 class="font-weight-bolder mb-0">
                  
                   {{dataTitle2($item->program_stage_id)}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fa-solid fa-book-bookmark"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
  </a>
  <br/>
    </div>
    @endforeach




@else

<h5>No Resources have been published yet</h5>

@endif
        


  </div>

</div>
<?php

use App\Models\SetupConfig;
function dataTitle2($id=null)
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