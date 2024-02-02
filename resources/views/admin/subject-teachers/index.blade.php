@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Subject Teachers</h5>
                        </div>
                        <a href="{{ URL::to("/subject-teachers/create") }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Subject Teacher</a>
                    </div>
                </div>
                @include('layouts.feedback')
          
@if(!$SubjectTeachers->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('teacher_id','Teacher')
                                       
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('stream_id','Stream ')
                                       
                                    </th>
                                           <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('class_id','Class ')
                                       
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('academic_year','Academic Year ')
                                       
                                    </th>
                                       <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('subject_id','Subject ')
                                       
                                    </th>
                                    
                   
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($SubjectTeachers as $item)
                                <tr>
<td class="ps-4">
<p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
</td>

<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{$item->TeacherData->name}}</p>
</td>

<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{$item->ClassData->title}}</p>
</td>



<td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{$item->StreamData->title}}</p>
</td>


                                  
   <td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{$item->academic_year}}</p>
</td>                        
      <td class="text-center">
<p class="text-xs font-weight-bold mb-0">{{$item->SubjectData->title}}</p>
</td>                         
                                   
                                    <td class="text-center">
                                        <a href="{{ URL::to("/subject-teachers/".$item->id."/edit") }}" >
            <button class="btn btn-primary "><i class="fa-solid fa-pen-to-square"></i> Edit </button>
          </a>



          <form action="{{action('App\Http\Controllers\Admin\SubjectTeacherController@destroy', $item->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button onclick="return confirm('Are you sure ?')" class="btn btn-danger mt-2"><i class="far fa-trash-alt"></i> Delete </button>
        </form>  
                                       
                                    </td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>
 <div class="pagination">
          {{ $SubjectTeachers->links() }}
          </div>
@else

<p style="padding:20px">
    No Subject Teacher(s) added.
</p>


@endif

            </div>
        </div>
    </div>
</div>
 
@endsection