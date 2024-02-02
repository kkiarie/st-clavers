@extends('layouts.pdf')
@section('content')


@if(!$ProgramSubjects->isEmpty())  
<table border="1" style="border:solid 1px #000">
        <tr style="background:#ccc">
       <th colspan="4" style="text-align: center; font-size: 15px;">Program Name : {{$record->name}}<br/>
        Program Period:: {{$record->period}} <br/>


         </th> 
    </tr>
    <tr  style="background:#ccc">
        <th colspan="4">{{$record->description}}</th>
    </tr>
    <tr style="background:#ccc;">
       <th colspan="4" style="text-align: center;"><b>Units Covered ::</b></th> 
    </tr>
    <tr style="background:#ccc">
        <th width="5%">#</th>
        <th width="50%">Course</th>
        <th width="15%">Year</th>
        <th width="15%">Semester</th>
    </tr>
 @foreach ($ProgramSubjects as $item)

                                <tr>
                                           <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>


                   
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            
{{$item->ProgamUnitData->title}}

                                        </p>
                                    </td>

                                                     <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            
{{$item->ProgamYear->title}}

                                        </p>
                                    </td>
                                
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->ProgramStageData->title}}</p>
                                    </td>
    
</tr>

 @endforeach


</table>

@endif

<br/>



<br>



@endsection