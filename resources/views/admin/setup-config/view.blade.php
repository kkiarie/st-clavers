 @extends('layouts.user_type.auth')

@section('content')
<div>
  <div class="container-fluid mt--7">
       <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">{{$Setup->title}}</h3>
              <hr/>
              
                 <a href="{{ URL::to("/setup/$Setup->id/edit") }}" >
            <button class="btn btn-primary mt-4"><i class="far fa-edit"></i> Edit {{$Setup->title}}</button>
          </a>
     
          <a href="{{ URL::to("/setup-config/create/$Setup->id") }}" >
            <button class="btn btn-success mt-4"><i class="fas fa-plus"></i> New Menu Item </button>
          </a>
 
          <form action="{{action('App\Http\Controllers\Admin\SetupController@destroy', $Setup->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button class="btn btn-danger mt-2" onclick="return confirm('Are you sure ?')"><i class="far fa-trash-alt"></i> Delete {{$Setup->title}}</button>
        </form>
            </div>
            <!-- Light table -->
            
            
            <div class="table-responsive">
              @if(!$SetupConfig->isEmpty())   
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                    <th scope="col" class="sort" data-sort="budget">Title</th>
                    <th scope="col">Created</th>
                    
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach ($SetupConfig as $item)
                  <tr>
                    <td class="budget">
                      {{$loop->iteration}}.
                    </td>
                    <td>
                    {{$item->title}}
                    </td>
                    <td>
                      {{$item->created_at}}
                    </td>
                    <td>
                      <a href="{{ URL::to("/menu-setup/".$item->id) }}" >
            <button class="btn btn-primary "><i class="far fa-eye"></i> View </button>
          </a>
<form action="{{action('App\Http\Controllers\Admin\MenuController@destroy', $item->id)}}" method="POST" role="form">
            {{ csrf_field() }}
        <input name="_method" type="hidden" value="DELETE">
        <button class="btn btn-danger mt-2"><i class="far fa-trash-alt"></i> Delete </button>
        </form>
        </td>
                  </tr>

                  @endforeach
                </tbody>
              </table>
<div class="card-footer py-4">
  <nav aria-label="...">
        <div class="pagination">
          {{ $SetupConfig->links() }}
          </div>
        </nav>
        </div>
          @else
            <p style="padding:10px">No records added to <b>{{$Setup->title}}</b> at the moment.</p>
          @endif
            </div>
            <!-- Card footer -->

          </div>
        </div>
      </div>

</div>
@endsection