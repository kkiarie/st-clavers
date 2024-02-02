@extends('layouts.app')

@section('content')
@include('layouts.headers.cards2')
    
    <div class="container-fluid mt--7">
       <div class="row">
        @include('admin.procurement._form',
      ["button"=>"Update RFQ","label"=>"Update Record","id"=>$Procurement->id,"labels"=>"Edit"])
      </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush