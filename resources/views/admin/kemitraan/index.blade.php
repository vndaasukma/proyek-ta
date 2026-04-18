@extends('layouts.admin') {{-- Sesuaikan dengan nama layout admin kamu --}}

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">manajemen kemitraan.</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>nama/instansi</th>
                            <th>no wa</th>
                            <th>proposal</th>
                            <th>status</th>
                            <th>aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kemitraan as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->nama_instansi }}</strong><br>
                                <small>oleh: {{ $item->nama_perwakilan }}</small>
                            </td>
                            <td>{{ $item->no_wa }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $item->proposal_path) }}" target="_blank" class="btn btn-info btn-sm">lihat file</a>
                            </td>
                            <td>
                                <span class="badge {{ $item->status == 'approved' ? 'badge-success' : ($item->status == 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                @if($item->status == 'pending')
                                    <a href="{{ route('admin.kemitraan.approve', $item->id) }}" class="btn btn-success btn-sm">acc</a>
                                    <a href="{{ route('admin.kemitraan.reject', $item->id) }}" class="btn btn-secondary btn-sm">tolak</a>
                                @endif
                                
                                @if($item->status == 'approved')
                                    <a href="{{ route('admin.kemitraan.cetak', $item->id) }}" class="btn btn-danger btn-sm" target="_blank">
                                        <i class="fas fa-file-pdf"></i> cetak surat
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection