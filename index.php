<?php
// ============================================
// HALAMAN DASHBOARD / BERANDA
// File: index.php
// Proteksi: Hanya bisa diakses setelah login
// ============================================

// Mulai session
session_start();

// --- PROTEKSI HALAMAN ---
// Jika user belum login, redirect ke login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Jika user bukan admin, redirect ke halaman edukasi
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: PRJK 6.php');
    exit;
}

// Include koneksi database untuk mengambil data lengkap user
require_once 'db.php';

try {
    // Ambil data user dari database berdasarkan session user_id
    $stmt = $pdo->prepare("SELECT id, username, email, nama_lengkap, usia, created_at FROM users WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $currentUser = $stmt->fetch();

    // Jika data user tidak ditemukan di database (aneh tapi mungkin terjadi)
    if (!$currentUser) {
        // Hapus session dan redirect ke login
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit;
    }

    // Format tanggal registrasi ke format Indonesia
    $tglDaftar = date('d F Y, H:i', strtotime($currentUser['created_at']));

} catch (PDOException $e) {
    die("Error mengambil data user.");
}

// Ambil data dari session/database (sebagai fallback)
 $displayUsername = htmlspecialchars($currentUser['username']);
 $displayEmail    = htmlspecialchars($currentUser['email']);
 $displayNama     = htmlspecialchars($currentUser['nama_lengkap'] ?? 'Tidak diketahui');
 $displayUsia     = htmlspecialchars($currentUser['usia'] ?? '0');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Sistem Auth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2 family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg: #fcf8f9;
            --card: #ffffff;
            --card-hover: #fafafa;
            --border: #e0e0e0;
            --fg: #333333;
            --muted: #64748b;
            --accent: #F57799;
            --accent-dim: rgba(245, 119, 153, 0.1);
            --accent-glow: rgba(245, 119, 153, 0.25);
            --danger: #ff4d6a;
            --warning: #f59e0b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--fg);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* --- Background grid --- */
        .bg-grid {
            position: fixed; inset: 0;
            background-color: #FFF7CD;
            background-image:
                linear-gradient(rgba(245,119,153,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(245,119,153,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridMove 25s linear infinite;
            z-index: 0; pointer-events: none;
        }
        @keyframes gridMove {
            0% { transform: translate(0,0); }
            100% { transform: translate(60px,60px); }
        }

        .glow-orb {
            position: fixed; border-radius: 50%;
            filter: blur(120px); opacity: 0.5; z-index: 0;
            animation: orbFloat 10s ease-in-out infinite alternate;
            pointer-events: none;
        }
        .glow-orb-1 { width: 400px; height: 400px; background: rgba(245, 119, 153, 0.2); top: -150px; left: -100px; }
        .glow-orb-2 { width: 350px; height: 350px; background: rgba(255, 247, 205, 0.6); bottom: -120px; right: -80px; animation-delay: -5s; }
        @keyframes orbFloat { 0% { transform: translate(0,0) scale(1); } 100% { transform: translate(40px,-30px) scale(1.15); } }

        /* --- Navbar --- */
        .navbar {
            position: sticky; top: 0; z-index: 50;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 32px; height: 72px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .nav-brand { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 18px; }
        .nav-brand-icon { width: 38px; height: 38px; background: var(--accent-dim); border: 1px solid rgba(245,119,153,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 16px; }
        .nav-user { display: flex; align-items: center; gap: 20px; }
        .nav-user-info { text-align: right; }
        .nav-user-name { font-size: 15px; font-weight: 600; }
        .nav-user-email { font-size: 12px; color: var(--muted); font-family: 'JetBrains Mono', monospace; }
        .nav-avatar { width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, var(--accent), #ff9eb5); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px; color: #fff; text-transform: uppercase; }

        .btn-logout {
            padding: 10px 20px; background: rgba(255,77,106,0.1); border: 1px solid rgba(255,77,106,0.15);
            border-radius: 10px; color: var(--danger); font-size: 14px; font-weight: 600;
            cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-logout:hover { background: rgba(255,77,106,0.18); border-color: rgba(255,77,106,0.3); }

        /* --- Konten utama (Dilebarkan) --- */
        .main-content { position: relative; z-index: 10; max-width: 1100px; margin: 0 auto; padding: 56px 24px; }

        /* --- Welcome banner --- */
        .welcome-banner {
            background: linear-gradient(135deg, rgba(255,227,236,0.6), rgba(255,247,205,0.4));
            border: 1px solid var(--border); border-radius: 20px; padding: 48px 56px; margin-bottom: 40px;
            animation: fadeUp 0.5s cubic-bezier(0.16,1,0.3,1) forwards; opacity: 0; transform: translateY(20px);
            position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        }
        @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }

        .welcome-label { font-size: 13px; font-weight: 600; color: var(--accent); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12px; }
        .welcome-title { font-size: 34px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 12px; color: #1e293b; }
        .welcome-title span { color: var(--accent); }
        .welcome-sub { color: #475569; font-size: 17px; max-width: 650px; line-height: 1.6; }

        /* --- Info cards grid (Diperbesar Menjadi 2 Kolom Agar Lebih Mantap) --- */
        .info-grid {
            display: grid; grid-template-columns: repeat(2, 1fr);
            gap: 24px; margin-bottom: 40px;
        }

        /* --- UKURAN CARD & TEKS DIPERBESAR --- */
        .info-card {
            background: var(--card); border: 1px solid var(--border); border-radius: 18px; padding: 36px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); animation: fadeUp 0.5s cubic-bezier(0.16,1,0.3,1) forwards; opacity: 0; transform: translateY(20px);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01);
        }
        .info-card:hover { border-color: var(--accent); transform: translateY(-4px); box-shadow: 0 20px 35px rgba(245,119,153,0.12); }

        /* Icon didalam card diperbesar */
        .info-card-icon { width: 54px; height: 54px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 24px; }
        .info-card-icon.green { background: rgba(245,119,153,0.15); color: var(--accent); border: 1px solid rgba(245,119,153,0.2); }
        .info-card-icon.blue { background: rgba(59,130,246,0.1); color: #2563eb; border: 1px solid rgba(59,130,246,0.2); }
        .info-card-icon.yellow { background: rgba(245,158,11,0.1); color: var(--warning); border: 1px solid rgba(245,158,11,0.2); }

        /* Label & value diperbesar sasarannya */
        .info-card-label { font-size: 14px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .info-card-value { font-size: 22px; font-weight: 700; color: #1e293b; word-break: break-all; }
        .info-card-value.mono { font-family: 'JetBrains Mono', monospace; font-size: 18px; color: #334155; }

        /* --- Tips keamanan diperbesar --- */
        .tips-section { background: var(--card); border: 1px solid var(--border); border-radius: 18px; padding: 40px; animation: fadeUp 0.5s cubic-bezier(0.16,1,0.3,1) forwards; opacity: 0; transform: translateY(20px); }
        .tips-title { font-size: 20px; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; color: #1e293b; }
        .tips-title i { color: var(--warning); font-size: 22px; }
        .tips-list { list-style: none; display: flex; flex-direction: column; gap: 16px; }
        .tips-list li { font-size: 15px; color: #475569; display: flex; align-items: flex-start; gap: 12px; line-height: 1.6; }
        .tips-list li i { color: var(--accent); font-size: 11px; margin-top: 7px; flex-shrink: 0; }

        /* --- Session info --- */
        .session-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; background: rgba(245,119,153,0.12); border: 1px solid rgba(245,119,153,0.2); color: var(--accent); margin-top: 24px; }
        .session-badge .dot { width: 8px; height: 8px; border-radius: 50%; background: var(--accent); animation: pulse 2s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

        /* --- TOMBOL UTAMA DIPERBESAR --- */
        .btn-main-action {
            display: inline-flex; align-items: center; gap: 12px; background: var(--accent); color: #fff; 
            padding: 18px 40px; border-radius: 14px; text-decoration: none; font-weight: 700; font-size: 18px; 
            transition: all 0.2s; box-shadow: 0 8px 25px var(--accent-glow);
        }
        .btn-main-action:hover { background: #e06284; transform: translateY(-2px); box-shadow: 0 12px 30px rgba(245,119,153,0.4); }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            .info-grid { grid-template-columns: 1fr; gap: 20px; }
            .navbar { padding: 0 20px; }
            .nav-user-info { display: none; }
            .main-content { padding: 32px 20px; }
            .welcome-banner { padding: 36px 28px; }
            .welcome-title { font-size: 26px; }
            .info-card { padding: 28px; }
            .info-card-value { font-size: 18px; }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="glow-orb glow-orb-1"></div>
    <div class="glow-orb glow-orb-2"></div>

    <nav class="navbar" role="navigation" aria-label="Navigasi utama">
        <div class="nav-brand">
            <div class="nav-brand-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <span>Sistem Auth Admin</span>
        </div>
        <div class="nav-user">
            <div class="nav-user-info">
                <div class="nav-user-name"><?= $displayUsername ?></div>
                <div class="nav-user-email"><?= $displayEmail ?></div>
            </div>
            <div class="nav-avatar" aria-hidden="true">
                <?= mb_substr($displayUsername, 0, 1) ?>
            </div>
            <a href="logout.php" class="btn-logout" role="button" aria-label="Keluar dari akun">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Keluar</span>
            </a>
        </div>
    </nav>

    <main class="main-content">
        <section class="welcome-banner" aria-label="Pesan selamat datang">
            <div class="welcome-label">Pusat Kendali</div>
            <h1 class="welcome-title">Selamat Datang, <span><?= $displayUsername ?></span></h1>
            <p class="welcome-sub">
                Anda berhasil masuk ke sistem. Ini adalah halaman dashboard khusus admin yang dilindungi dan hanya bisa diakses setelah melewati proses autentikasi ketat.
            </p>
            <div class="session-badge">
                <div class="dot"></div>
                Sesi Administrator Aktif
            </div>
        </section>

        <section class="info-grid" aria-label="Informasi akun">
            <div class="info-card" style="animation-delay: 0.05s;">
                <div class="info-card-icon green">
                    <i class="fa-solid fa-address-card"></i>
                </div>
                <div class="info-card-label">Nama Lengkap</div>
                <div class="info-card-value"><?= $displayNama ?></div>
            </div>

            <div class="info-card" style="animation-delay: 0.1s;">
                <div class="info-card-icon yellow">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div class="info-card-label">Usia Pengguna</div>
                <div class="info-card-value"><?= $displayUsia ?> Tahun</div>
            </div>

            <div class="info-card" style="animation-delay: 0.15s;">
                <div class="info-card-icon green">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="info-card-label">Username Sistem</div>
                <div class="info-card-value">@<?= $displayUsername ?></div>
            </div>

            <div class="info-card" style="animation-delay: 0.2s;">
                <div class="info-card-icon blue">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="info-card-label">Alamat Email</div>
                <div class="info-card-value mono"><?= $displayEmail ?></div>
            </div>

            <div class="info-card" style="grid-column: span 2; animation-delay: 0.25s;">
                <div class="info-card-icon yellow">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="info-card-label">Tanggal Registrasi Akun</div>
                <div class="info-card-value"><?= $tglDaftar ?></div>
            </div>
        </section>

        <section style="margin-bottom: 48px; text-align: center; animation: fadeUp 0.5s cubic-bezier(0.16,1,0.3,1) forwards; animation-delay: 0.3s; opacity: 0; transform: translateY(20px);">
            <a href="PRJK 6.php" class="btn-main-action">
                <i class="fa-solid fa-notes-medical"></i> Buka Halaman Edukasi Paru-Paru
            </a>
        </section>

        <section class="tips-section" aria-label="Tips keamanan" style="animation-delay: 0.35s;">
            <h2 class="tips-title">
                <i class="fa-solid fa-lightbulb"></i>
                Tips Mengelola Keamanan Akun Admin
            </h2>
            <ul class="tips-list">
                <li>
                    <i class="fa-solid fa-circle"></i>
                    Gunakan password berkombinasi tinggi — minimal 8 karakter dengan campuran huruf kapital, angka, serta simbol khusus demi menghindari serangan brute-force.
                </li>
                <li>
                    <i class="fa-solid fa-circle"></i>
                    Jangan pernah membagikan kredensial login atau session token Anda kepada siapapun melalui platform pesan teks non-aman.
                </li>
                <li>
                    <i class="fa-solid fa-circle"></i>
                    Biasakan menekan tombol "Keluar" secara formal setelah selesai mengelola sistem, terutama jika Anda membukanya di komputer publik.
                </li>
                <li>
                    <i class="fa-solid fa-circle"></i>
                    Sistem enkripsi database menggunakan metode hash BCrypt satu arah otomatis, mengamankan password Anda secara menyeluruh.
                </li>
            </ul>
        </section>
    </main>
</body>
</html>