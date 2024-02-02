@extends('layouts.user_type.auth')

@section('content')
    
    <div class="container-fluid mt--7">
       <div class="row">
        @include('admin.inventory-request._form',
      ["button"=>"Save Record","label"=>"Choose Inventory Item","id"=>0,"labels"=>"New"])
      </div>

       
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush