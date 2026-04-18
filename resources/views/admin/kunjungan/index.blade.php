@extends('admin.layout')

@section('content')

<h4 class="mb-3">Manajemen Jadwal Kunjungan</h4>

<div class="card p-3">

    <div class="mb-3">
        <a href="{{ route('kunjungan.create') }}" class="btn btn-primary">
            ➕ Tambah Jadwal
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Kuota</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($kunjungan as $item)
            <tr>
                <td>{{ $item->judul }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $item->jam }}</td>
                <td>{{ $item->terisi }} / {{ $item->kuota }}</td>

                <td>
                    <a href="{{ route('kunjungan.edit', $item->id) }}"
                       class="btn btn-sm btn-warning">
                        ✏ Edit
                    </a>

                    <form action="{{ route('kunjungan.destroy', $item->id) }}"
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            🗑 Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Belum ada jadwal kunjungan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
