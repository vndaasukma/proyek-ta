@extends('layouts.frontend')

@section('content')
<style>
    .form-container {
        padding: 80px 0;
        background: #f8f9fa;
        min-height: 80vh;
    }
    .card-registration {
        border: none;
        border-radius: 30px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .header-registration {
        background: linear-gradient(135deg, #1a4d2e 0%, #2d6a4f 100%);
        color: white;
        padding: 40px;
        text-align: center;
    }
    .btn-submit {
        background: #198754;
        color: white;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 700;
        border: none;
        width: 100%;
        transition: 0.3s;
    }
    .btn-submit:hover {
        background: #146c43;
        transform: translateY(-3px);
    }
</style>

<div class="form-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card card-registration">
                    <div class="header-registration">
                        <h2 class="fw-bold text-none">Formulir Pendaftaran Pelatihan</h2>
                        <p class="mb-0 opacity-75">{{ $pelatihan->nama_pelatihan }}</p>
                    </div>
                    <div class="card-body p-5">
                        <form action="{{ route('pelatihan.store') }}" method="POST">
                            @csrf
                            
                            <input type="hidden" name="pelatihan_id" value="{{ $pelatihan->id }}">
                            <input type="hidden" name="total_harga" value="{{ $pelatihan->harga }}">
                            
                            <div class="mb-3">
                                <label class="fw-bold text-none">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control rounded-pill" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="fw-bold text-none">Nomor WhatsApp</label>
                                <input type="text" name="no_hp" class="form-control rounded-pill" placeholder="08..." required>
                            </div>

                            <div class="mb-4">
                                <label class="fw-bold text-none">Email</label>
                                <input type="email" name="email" class="form-control rounded-pill" required>
                            </div>

                            <button type="submit" class="btn-submit">Kirim Pendaftaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection