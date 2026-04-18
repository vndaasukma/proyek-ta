@extends('admin.layout')

@section('content')
<h1>Data Pelatihan</h1>

<a href="/admin/trainings/create" class="btn btn-success mb-3">
    Tambah Pelatihan
</a>

<table class="table table-bordered">
    <tr>
        <th>Judul</th>
        <th>Harga</th>
        <th>Kuota</th>
        <th>Status</th>
    </tr>

    @foreach($trainings as $training)
    <tr>
        <td>{{ $training->title }}</td>
        <td>{{ $training->price }}</td>
        <td>{{ $training->quota }}</td>
        <td>{{ $training->status }}</td>
    </tr>
    @endforeach
</table>
@endsection
