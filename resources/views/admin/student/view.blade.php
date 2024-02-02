@extends('layouts.user_type.auth')

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            @include('layouts.feedback')
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-0">Student Name : {{$Student->name}}</h5>
                                </div>

                             

                                 <div class="col-md-6">
                                    <h5 class="mb-0">Admission Date ::
                                     {{date("dS F, Y ", strtotime($Student->created_at))}}</h5>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="mb-0">Gender : 
                                         @if($Student->gender>0)
                                        {{$Student->MetaData->title}}
                                        @endif
                                    </h5>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="mb-0">DOB : {{date("dS F, Y ", strtotime($Student->dob))}}</h5>
                                </div>
@if($Student->program_id>2)
                                  <div class="col-md-6">
                                    <h5 class="mb-0">
                                        Program : {{$Student->ProgramData->name}}
                                    </h5>
                                </div>

@else
                                  <div class="col-md-6">
                                    <h5 class="mb-0">Class  :

                                        @if($ClassDetails==0)
                                            No Class Assigned
                                        @else
                                            {{$ClassDetails}}
                                        @endif
                                    </h5>
                                </div>

@endif

                                <div class="col-md-6">
                                    <h5 class="mb-0">Student No.  :
{{$Student->admission_no}}
                                    </h5>
                                </div>

                                <div class="col-xs-4">
                                    
                                    
                                         @if(isset($Student))<br/>

          <?php if(strlen($Student->file) >2): ?>
          
          <img src="{{ asset("uploads/".$Student->file) }}" alt="logo" width="15%" >
          <?php endif; ?>

         @endif
                                </div>
                            </div>
                     <a href="{{ URL::to("/students/$Student->id/edit") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-edit"></i> Edit {{$Student->name}}</button>
          </a>

@if($Student->program_id>2)

        <a href="{{ URL::to("assign-student-class/create/$Student->id") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-plus"></i> Assign Year</button>
        </a>
@else

        <a href="{{ URL::to("assign-student-class/create/$Student->id") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-plus"></i> Assign Class</button>
        </a>

@endif


        <a href="{{ URL::to("/students-link-parent/$Student->id") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-plus"></i> Link to Parent Account</button>
        </a>


             <a href="{{ URL::to("/student-subject-clusters/$Student->id") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-plus"></i> Subject Clusters</button>
        </a>


          
 


                        </div>

                    </div>
                </div>



      
     
 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

<div class="card mb-4 mx-4">
            <h5>Units</h5>
            @if(!$StudentUnits->isEmpty()) 

            <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget" width="10%">@sortablelink('id','ID')
                                        
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','Unit Name')
                                        
                                    </th>
                                   
                                </tr>

                            </thead>


                            <tbody>
                                @foreach($StudentUnits as $item)

                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>

                                    <td class="text-left">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->SubjectData->title}}</p>
                                    </td>

                                    <td class="text-left">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->AcademicData->title}}</p>
                                    </td>
                                    <td class="text-left">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->ClassData->title}}</p>
                                    </td>
                              
                                </tr>
                                @endforeach
                                
                            </tbody>

                        </table>
                    </div>
            </div>        


            @endif

</div>


  <div class="card mb-4 mx-4">
            <h5>Parents History</h5>
            @if(!$Parents->isEmpty()) 

            <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget" width="10%">@sortablelink('id','ID')
                                        
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','Parent Name')
                                        
                                    </th>
                                    <th>&nbsp;</th>
                                </tr>

                            </thead>


                            <tbody>
                                @foreach($Parents as $item)

                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->ParentData->name}}</p>
                                    </td>
                                    <td>
                    <a onclick="return confirm('Are you sure ?')" href="{{ URL::to("/student-parent-unmerge/$item->id") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-plus"></i> Unmerge</button>
        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>

                        </table>
                    </div>
            </div>        


            @endif

</div>

            <div class="card mb-4 mx-4">
            <h5>Class History</h5>
            
    @if(!$StudentClass->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('title','Class')
                                       
                                    </th>
                                 @if($Student->program_id<2)   
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('created_at','Stream')
                                    </th>
                                    @endif

                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($StudentClass as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>
                                @if($Student->program_id<2)
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->ClassData->title}}</p>
                                    </td>

                                   

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->StreamData->title}}</p>
                                    </td>
 @endif
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->year}}</p>
                                    </td>
                                   
                                    <td class="text-center">
                         
                                    </td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>
 <div class="pagination">
          {{ $StudentClass->links() }}
          </div>
@else

<p style="padding:20px">
    No Class History has been added.
</p>


@endif




        </div>



           <div class="card mb-4 mx-4">
            <h5>Subject Clusters being Taken</h5>
            
    @if(!$StudentSubjects->isEmpty())  


                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('id','ID')
                                        
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('subject_id','Subject')
                                       
                                    </th>

                                     <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" scope="col"  data-sort="budget">@sortablelink('cluster_id','Cluster ')
                                       
                                    </th>
                            

                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Academic Year
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($StudentSubjects as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$loop->iteration}}.</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$item->SubjectData->title}}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$item->ClusterData->title}}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$item->academic_year}}</p>
                                    </td>
                                   
                                    <td class="text-center">
                         
                                    </td>
                                </tr>
                                @endforeach
                        
                            </tbody>
                        </table>
                    </div>
                </div>
 <div class="pagination">
          {{ $StudentSubjects->links() }}
          </div>
@else

<p style="padding:20px">
    No Class History has been added.
</p>


@endif




        </div>
    </div>
</div>
</div>
</div>
 
@endsection