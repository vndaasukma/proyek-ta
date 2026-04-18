<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Midtrans</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5 text-center">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h3>Pembayaran Pelatihan</h3>
                <hr>
                <p>Nama: <strong>{{ $pendaftaran->nama }}</strong></p>
                <h2 class="text-success">Rp {{ number_format($pendaftaran->total_harga) }}</h2>

                <button id="pay-button" class="btn btn-primary btn-lg w-100 mt-3">Bayar Sekarang</button>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = "{{ route('sukses.daftar') }}";
            },
            onPending: function (result) {
                alert("Menunggu pembayaran. Silakan cek email/aplikasi bank anda.");
            },
            onError: function (result) {
                alert("Pembayaran gagal!");
            }
        });
    };
    </script>
</body>
</html>