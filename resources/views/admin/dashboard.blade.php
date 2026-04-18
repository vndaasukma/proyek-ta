@extends('layouts.admin')

@section('content')
<h4 class="mb-4">Dashboard</h4>

<div class="row">

    <div class="col-md-3">
        <div class="card card-dashboard p-3">
            <h6>Total Pelatihan</h6>
            <h3>{{ $total }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-dashboard p-3">
            <h6>Pelatihan Open</h6>
            <h3 class="text-primary">{{ $open }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-dashboard p-3">
            <h6>Pelatihan Closed</h6>
            <h3 class="text-success">{{ $closed }}</h3>
        </div>
    </div>

</div>
@endsection
