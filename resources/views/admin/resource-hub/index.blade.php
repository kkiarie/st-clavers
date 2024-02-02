@extends('layouts.user_type.auth')

@section('content')
<?php


$clients_list="";
foreach($ResourceMaterialList as $item):
$clients_list.="<option value='".$item->id."'>$item->name </option>"; 
endforeach; 
$clients_list.="";


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
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Resources</h5>
                        </div>
                        <a href="{{ URL::to("/resources-hub/create") }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Resources Material</a>
                    </div>
                </div>
                @include('layouts.feedback')

@if(!$ResourceHubMaterials->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('program_unit_id','Subject')
                                       
                                    </th>

                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('program_stage_id','Grade')
                                       
                                    </th>
                                   
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($ResourceHubMaterials as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>
                                
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{dataTitle($item->program_unit_id)}}</p>
                                    </td>

                                       <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{dataTitle($item->program_stage_id)}}</p>
                                    </td>                            

                          
                                   
                                    <td class="text-center">
                <a href="{{ URL::to("/resources-hub/".$item->id) }}" >
            <button class="btn btn-primary "><i class="far fa-eye"></i> View </button>
          </a>
                                       
                                    </td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>
 <div class="pagination">
          {{ $ResourceHubMaterials->links() }}
          </div>
@else

<p style="padding:20px">
    No Student(s) added.
</p>


@endif

            </div>
        </div>
    </div>
</div>
 
@endsection