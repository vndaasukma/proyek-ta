@extends('admin.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 font-weight-bold text-success" style="text-transform: lowercase;">moderasi review pelanggan</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-lowercase">
                            <th>nama</th>
                            <th>pelatihan</th>
                            <th>komentar</th>
                            <th>status</th>
                            <th class="text-center">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $rev)
                        <tr>
                            <td class="text-lowercase">{{ $rev->nama }}</td>
                            <td class="text-lowercase"><span class="badge bg-secondary">{{ $rev->pelatihan }}</span></td>
                            <td class="small">{{ $rev->komentar }}</td>
                            <td>
                                @if($rev->status == 'pending')
                                    <span class="badge bg-warning text-dark text-lowercase">pending</span>
                                @else
                                    <span class="badge bg-success text-lowercase">disetujui</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if($rev->status == 'pending')
                                    <form action="{{ route('admin.reviews.approve', $rev->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">setujui</button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('hapus review ini?')">hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted fst-italic">belum ada review masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
