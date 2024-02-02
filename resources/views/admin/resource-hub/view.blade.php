@extends('layouts.user_type.auth')

@section('content')
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
<div>

    <div class="row">
        <div class="col-12">
            @include('layouts.feedback')
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <div class="row">
                                <div class="col-md-12">
        @if($ResourceHubMaterial->status==0)                            
        <a href="{{ URL::to("/resources-hub/$ResourceHubMaterial->id"."/edit") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-edit"></i> Edit</button>
        </a>

        <a onclick="return confirm('Are you sure ?')" 
         href="{{ URL::to("/resources-hub-publish/$ResourceHubMaterial->id") }}" >
            <button class="btn btn-primary mt-4"><i class="fa-solid fa-check"></i> Publish</button>
        </a>


                  <form action="{{action('App\Http\Controllers\Admin\ResourceHubMaterialController@destroy', $ResourceHubMaterial->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button class="btn btn-danger mt-2" onclick="return confirm('Are you sure ?')"><i class="far fa-trash-alt"></i> Delete Resource</button>
        </form>
        @endif


                                    <h4 class="mb-0">

                                        Resource Material &raquo;
                                        
                                        {{dataTitle($ResourceHubMaterial->program_unit_id)}}
                                        {{dataTitle($ResourceHubMaterial->program_stage_id)}}
                                    </h5>
                                </div>


                                <div class="col-md-12">
                                <h5>Resource Description:</h5> 
                                <p>{{$ResourceHubMaterial->description}}</p>


                @if(isset($ResourceHubMaterial))<br/>

                <?php if(strlen($ResourceHubMaterial->file) >2): ?>

                <a href="{{ asset("uploads/".$ResourceHubMaterial->file) }}" target="_blank">
                <button class="btn btn-primary"><i class="fa fa-file-pdf"></i> Download</button>
                </a>
                <?php endif; ?>

                @endif
                                </div>

                             

               
       
                            </div>





          
 


                        </div>

                    </div>
                </div>



      
     


</div>
</div>
</div>
 
@endsection