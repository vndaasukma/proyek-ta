<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Admin P4S Gubuk Sayur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --g400: #4ade80;
            --g500: #22c55e;
            --g600: #16a34a;
            --g700: #15803d;
            --g800: #166534;
            --panel: #0d1f14;
        }

        html, body { height: 100%; font-family: 'DM Sans', sans-serif; background: #0b150e; }

        .page {
            display: grid;
            grid-template-columns: 1fr 480px;
            min-height: 100vh;
        }

        /* LEFT PANEL: Branding & Info */
        .left-panel {
            background: var(--panel);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem 3.5rem;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 520px; height: 520px;
            border-radius: 50%;
            border: 1px solid rgba(34,197,94,0.07);
            top: -140px; left: -160px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 360px; height: 360px;
            border-radius: 50%;
            border: 1px solid rgba(34,197,94,0.05);
            bottom: -80px; right: 20px;
        }
        .left-inner { position: relative; z-index: 2; }

        .logo-row { display: flex; align-items: center; gap: 12px; margin-bottom: 4.5rem; }
        .logo-box {
            width: 38px; height: 38px;
            background: var(--g700);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-box i { color: #fff; font-size: 18px; }
        .logo-name { font-size: 1rem; font-weight: 700; color: #d1fae5; letter-spacing: -0.2px; text-transform: lowercase; }

        .left-headline {
            font-family: 'Instrument Serif', serif;
            font-size: clamp(2.2rem, 3.5vw, 3.8rem);
            line-height: 1;
            color: #ecfdf5;
            margin-bottom: 1.2rem;
            text-transform: lowercase;
        }
        .left-headline em { font-style: italic; color: var(--g400); }

        .left-sub {
            font-size: 0.95rem;
            color: #4b7a5e;
            line-height: 1.6;
            max-width: 400px;
            margin-bottom: 2.5rem;
        }

        .stat-row { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 3rem; }
        .stat-pill {
            background: rgba(34,197,94,0.06);
            border: 1px solid rgba(34,197,94,0.12);
            border-radius: 999px;
            padding: 7px 16px;
            display: flex; align-items: center; gap: 7px;
        }
        .stat-pill .num { font-size: 0.85rem; font-weight: 600; color: var(--g400); text-transform: uppercase; }
        .stat-pill .lbl { font-size: 0.7rem; color: #4b7a5e; }

        .feature-list { display: flex; flex-direction: column; gap: 12px; }
        .feature-item { display: flex; align-items: center; gap: 12px; font-size: 0.85rem; color: #4b7a5e; }
        .feature-item i { color: var(--g700); font-size: 14px; flex-shrink: 0; }

        /* RIGHT PANEL: Form */
        .right-panel {
            background: #0a0f0b;
            border-left: 1px solid rgba(34,197,94,0.06);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
            position: relative;
        }

        .corner-badge {
            position: absolute;
            top: 1.25rem; right: 1.25rem;
            background: rgba(34,197,94,0.05);
            border: 1px solid rgba(34,197,94,0.1);
            border-radius: 6px;
            padding: 3px 9px;
            font-size: 0.65rem;
            color: var(--g700);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .form-section { max-width: 350px; width: 100%; margin: 0 auto; }

        .form-eyebrow {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--g700);
            margin-bottom: 0.4rem;
        }
        .form-title { font-size: 1.6rem; font-weight: 700; color: #ecfdf5; letter-spacing: -0.5px; margin-bottom: 0.25rem; }
        .form-subtitle { font-size: 0.85rem; color: #2d4a35; margin-bottom: 2rem; }

        .err-alert {
            background: rgba(239,68,68,0.07);
            border: 1px solid rgba(239,68,68,0.18);
            border-radius: 10px;
            padding: 12px;
            display: flex; align-items: center; gap: 10px;
            font-size: 0.8rem; color: #fca5a5;
            margin-bottom: 1.5rem;
        }

        .field { margin-bottom: 1.2rem; }
        .field-label {
            display: block;
            font-size: 0.75rem; font-weight: 600;
            color: #3d6645;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .field-wrap { position: relative; }
        .field-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #1e3325; font-size: 16px;
            pointer-events: none;
            transition: color 0.18s;
        }
        .field-input {
            width: 100%;
            height: 48px;
            background: rgba(255,255,255,0.02);
            border: 1px solid #1a2e20;
            border-radius: 10px;
            padding: 0 12px 0 44px;
            color: #d1fae5;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
        }
        .field-input:focus {
            border-color: var(--g600);
            background: rgba(22,163,74,0.04);
            box-shadow: 0 0 0 4px rgba(34,197,94,0.08);
        }
        .field-input:focus ~ .field-icon { color: var(--g400); }

        .toggle-btn {
            position: absolute; right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: #1e3325; cursor: pointer; font-size: 16px;
        }

        .btn-submit {
            width: 100%; height: 50px;
            background: var(--g600);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 0.9rem; font-weight: 700;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: all 0.2s;
            margin-top: 2rem;
        }
        .btn-submit:hover { background: var(--g500); transform: translateY(-2px); box-shadow: 0 10px 20px rgba(22,163,74,0.15); }

        .security-row { display: flex; justify-content: center; gap: 1.5rem; margin-top: 2rem; }
        .sec-item { display: flex; align-items: center; gap: 6px; font-size: 0.7rem; color: #1e3325; }
        .sec-item i { color: var(--g700); }

        .right-footer { text-align: center; margin-top: 3rem; font-size: 0.7rem; color: #141f17; }

        @media (max-width: 992px) {
            .page { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { border-left: none; }
        }
    </style>
</head>
<body>

<div class="page">

    <div class="left-panel">
        <div class="left-inner">
            <div class="logo-row">
                <div class="logo-box"><i class="bi bi-tree-fill"></i></div>
                <span class="logo-name">P4S Gubuk Sayur.</span>
            </div>
            <h1 class="left-headline">
                kendali penuh<br>ekosistem <em>pertanian</em><br>modern.
            </h1>
            <p class="left-sub">
                Portal administrasi terpadu untuk manajemen pelatihan, kunjungan edukasi, dan kolaborasi mitra strategis secara real-time.
            </p>
            <div class="stat-row">
                <div class="stat-pill"><span class="num">Official</span><span class="lbl">Admin Portal</span></div>
                <div class="stat-pill"><span class="num">Secured</span><span class="lbl">Database</span></div>
                <div class="stat-pill"><span class="num">Private</span><span class="lbl">Access</span></div>
            </div>
        </div>
        <div class="left-inner">
            <div class="feature-list">
                <div class="feature-item"><i class="bi bi-check-circle-fill"></i>Verifikasi otomatis dokumen kemitraan strategis</div>
                <div class="feature-item"><i class="bi bi-check-circle-fill"></i>Penjadwalan presisi sesi kunjungan edukatif</div>
                <div class="feature-item"><i class="bi bi-check-circle-fill"></i>Manajemen pembayaran pelatihan via Midtrans</div>
                <div class="feature-item"><i class="bi bi-check-circle-fill"></i>Laporan digital otomatis format PDF & Invoice</div>
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="corner-badge">PORTAL RESMI</div>
        <div class="form-section">

            <div class="form-eyebrow">Akses Administrator</div>
            <div class="form-title">Masuk Dashboard</div>
            <div class="form-subtitle">Silakan masukkan akun pengelola P4S</div>

            @if(session('error'))
            <div class="err-alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <div class="field">
                    <label class="field-label">Alamat Email</label>
                    <div class="field-wrap">
                        <input type="email" name="email" class="field-input"
                            placeholder="admin@gubuksayur.com"
                            value="{{ old('email') }}" required autofocus>
                        <i class="bi bi-person-badge field-icon"></i>
                    </div>
                </div>

                <div class="field">
                    <label class="field-label">Kata Sandi</label>
                    <div class="field-wrap">
                        <input type="password" id="password" name="password" class="field-input"
                            placeholder="••••••••••" required>
                        <i class="bi bi-shield-lock field-icon"></i>
                        <button type="button" class="toggle-btn" id="togglePass">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-2">
                    <label class="form-check" style="cursor: pointer;">
                        <input type="checkbox" name="remember" class="form-check-input">
                        <span style="font-size: 0.8rem; color: #2d4a35; margin-left: 5px;">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    Masuk ke Sistem <i class="bi bi-chevron-right"></i>
                </button>
            </form>

            <div class="security-row">
                <div class="sec-item"><i class="bi bi-shield-check"></i> Enkripsi Data</div>
                <div class="sec-item"><i class="bi bi-activity"></i> Log Terpantau</div>
            </div>

            <div class="right-footer">&copy; 2026 P4S Gubuk Sayur Lumajang. Seluruh akses diaudit.</div>
        </div>
    </div>

</div>

<script>
    const passInput = document.getElementById('password');
    const eyeBtn = document.getElementById('togglePass');
    const eyeIcon = document.getElementById('eyeIcon');

    eyeBtn.addEventListener('click', () => {
        const isPass = passInput.type === 'password';
        passInput.type = isPass ? 'text' : 'password';
        eyeIcon.className = isPass ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
</script>
</body>
</html>