<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Kunjungan - P4S Gubuk Sayur</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            P4S Gubuk Sayur
        </a>
    </div>
</nav>

<section class="hero d-flex align-items-center" style="height: 40vh;">
    <div class="container text-center">
        <h1 class="fw-bold">Form Pengajuan Kunjungan</h1>
        <p class="mt-2">Silahkan isi data dengan lengkap</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <p class="text-center mb-3">
                            Tanggal dipilih:
                            <strong id="tanggal"></strong>
                        </p>

                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <form action="{{ url('/daftar-kunjungan') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Instansi / Pengunjung</label>
                            <input type="text" name="nama_instansi" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Pengunjung</label>
                            <input type="number" name="jumlah_pengunjung" class="form-control" min="1" placeholder="Contoh: 30" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control" required>
                        </div>

                        <input type="hidden" name="tanggal"
                            value="{{ request('tanggal') }}">

                        <div class="mb-3">
                            <label class="form-label">Pilih Sesi</label>
                            <select name="sesi" class="form-select" required>
                                <option value="08:00">08.00 WIB</option>
                                <option value="11:00">11.00 WIB</option>
                                <option value="14:00">14.00 WIB</option>
                            </select>
                        </div>

                        <button class="btn btn-primary w-100">
                            Ajukan Kunjungan
                        </button>
                    </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-white text-center py-4">
    © 2026 P4S Gubuk Sayur Lumajang
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById("tanggal").innerText =
        localStorage.getItem("tanggal_kunjungan");
</script>

</body>
</html>