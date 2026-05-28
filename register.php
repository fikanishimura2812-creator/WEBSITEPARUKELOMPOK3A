<?php
// ============================================
// HALAMAN REGISTRASI USER
// File: register.php
// ============================================

session_start();
require_once 'db.php';

$error = '';
$success = '';
$old_username = '';
$old_email = '';
$nama_lengkap = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $username     = trim($_POST['username'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $password     = $_POST['password'] ?? '';
    $confirm      = $_POST['confirm_password'] ?? '';

    $nama_lengkap = htmlspecialchars($nama_lengkap);
    $old_username     = htmlspecialchars($username);
    $old_email        = htmlspecialchars($email);

    if (empty($nama_lengkap) || empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $error = 'Semua field wajib diisi.';
    }
    elseif (strlen($username) < 3 || !preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = 'Username minimal 3 karakter dan hanya boleh berisi huruf, angka, dan underscore.';
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    }
    elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    }
    elseif ($password !== $confirm) {
        $error = 'Password dan konfirmasi password tidak cocok.';
    }
    else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
            $stmt->execute([
                ':username' => $username,
                ':email'    => $email
            ]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                $error = 'Username atau email sudah terdaftar. Silakan gunakan yang lain.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $pdo->prepare("INSERT INTO users (nama_lengkap, username, email, password) VALUES (:nama_lengkap, :username, :email, :password)");
                $stmt->execute([
                    ':nama_lengkap' => $nama_lengkap,
                    ':username'     => $username,
                    ':email'        => $email,
                    ':password'     => $hashedPassword
                ]);

                $success = 'Registrasi berhasil! Silakan login.';
                $nama_lengkap = '';
                $old_username = '';
                $old_email = '';
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan sistem. Silakan coba lagi nanti.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi — Healthy Breath</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg: #fcf8f9; 
            --card: #ffffff;
            --border: #e0e0e0;
            --fg: #333333;
            --muted: #777777;
            --accent: #F57799; 
            --accent-dim: rgba(245, 119, 153, 0.1);
            --danger: #ff4d6a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Verdana, sans-serif;
            background: var(--bg);
            color: var(--fg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 40px 20px;
            overflow-x: hidden; /* Mencegah horizontal scroll akibat efek transform scale latar belakang */
            z-index: 1;
        }

        /* KODE RESOLUSI GAMBAR LATAR BELAKANG (BLUR & SCALE) */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(rgba(252, 248, 249, 0.75), rgba(252, 248, 249, 0.75)), 
                        url('images/medis.jpg') center / cover no-repeat fixed;
            filter: blur(8px); /* -> Mengurangi ketajaman gambar agar tidak terlalu mencolok */
            transform: scale(1.05); /* -> Menghilangkan garis putih di pinggiran akibat efek blur */
            z-index: -1; /* Berada tepat di belakang komponen utama card */
        }

        /* --- UKURAN CARD --- */
        .auth-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            width: 100%;
            max-width: 540px; 
            position: relative; z-index: 10;
            box-shadow: 0 20px 40px rgba(0,0,0,0.06);
            animation: cardIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            overflow: hidden;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-header-img {
            width: 100%;
            height: 180px; 
            object-fit: cover;
            border-bottom: 1px solid var(--border);
        }

        /* --- PADDING DALAM CARD --- */
        .card-body { padding: 40px 48px; }
        .auth-card h1 { font-size: 26px; font-weight: 700; margin-bottom: 8px; color: #2c3e50; text-align: center; }
        .auth-card .subtitle { color: var(--muted); font-size: 15px; margin-bottom: 24px; text-align: center; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px; 
        }

        .input-group { margin-bottom: 18px; position: relative; }
        .full-width { grid-column: span 2; }
        .input-group label { display: block; font-size: 13.5px; font-weight: 500; color: var(--muted); margin-bottom: 8px; }
        .input-wrapper { position: relative; }
        .input-wrapper i.input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 14px; pointer-events: none; }
        
        .input-wrapper input {
            width: 100%; padding: 12px 14px 12px 40px; border: 1px solid var(--border); border-radius: 10px;
            color: var(--fg); font-size: 15px; outline: none; transition: all 0.3s;
        }
        .input-wrapper input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-dim); }
        .input-wrapper input:focus + i.input-icon { color: var(--accent); }

        .btn-primary {
            width: 100%; padding: 13px; background: var(--accent); color: #fff;
            border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer;
            transition: all 0.2s; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-primary:hover { background: #e06284; box-shadow: 0 4px 12px rgba(245, 119, 153, 0.3); }

        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
        .alert-error { background: rgba(255,77,106,0.08); border: 1px solid rgba(255,77,106,0.15); color: var(--danger); }
        .alert-success { background: rgba(0,212,170,0.08); border: 1px solid rgba(0,212,170,0.15); color: #00b38f; }

        .auth-footer { text-align: center; margin-top: 24px; font-size: 14.5px; color: var(--muted); }
        .auth-footer a { color: var(--accent); font-weight: 600; text-decoration: none; }
        .toggle-pass { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--muted); cursor: pointer; font-size: 14px; }

        .strength-bar { height: 3px; border-radius: 3px; margin-top: 6px; background: var(--border); overflow: hidden; }
        .strength-bar-fill { height: 100%; width: 0%; transition: all 0.4s ease; }
        .strength-text { font-size: 11px; margin-top: 4px; min-height: 14px; }

        @media (max-width: 640px) {
            .card-body { padding: 30px 24px; }
            .form-grid { grid-template-columns: 1fr; gap: 0; }
            .full-width { grid-column: span 1; }
        }
    </style>
</head>
<body>

    <main class="auth-card" role="main">
        <img class="card-header-img" src="https://ciputrahospital.com/wp-content/uploads/2024/08/shutterstock_2478618273-1-scaled.jpg" alt="Healthy Breath Header">

        <div class="card-body">
            <h1>Buat Akun Baru</h1>
            <p class="subtitle">Isi data di bawah ini untuk bergabung</p>

            <?php if ($error): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success" role="status">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= htmlspecialchars($success) ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="" autocomplete="on" novalidate>
                <div class="form-grid">
                    <div class="input-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="John Doe" value="<?= $nama_lengkap ?>" required>
                            <i class="fa-solid fa-address-card input-icon"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <input type="text" id="username" name="username" placeholder="john_doe" value="<?= $old_username ?>" required>
                            <i class="fa-solid fa-at input-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="input-group full-width">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="contoh@email.com" value="<?= $old_email ?>" required>
                        <i class="fa-solid fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="input-group full-width">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>
                        <i class="fa-solid fa-lock input-icon"></i>
                        <button type="button" class="toggle-pass" onclick="togglePassword('password', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <div class="strength-bar"><div class="strength-bar-fill" id="strength-fill"></div></div>
                    <div class="strength-text" id="strength-text"></div>
                </div>

                <div class="input-group full-width">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>
                        <i class="fa-solid fa-lock input-icon"></i>
                        <button type="button" class="toggle-pass" onclick="togglePassword('confirm_password', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
                </button>
            </form>

            <div class="auth-footer">
                Sudanya punya akun? <a href="login.php">Login di sini</a>
            </div>
        </div>
    </main>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strength-fill');
        const strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', function() {
            const val = this.value;
            let score = 0;

            if (val.length >= 6) score++;
            if (val.length >= 10) score++;
            if (/[a-z]/.test(val) && /[A-Z]/.test(val)) score++;
            if (/\d/.test(val)) score++;
            if (/[^a-zA-Z0-9]/.test(val)) score++;

            const levels = [
                { width: '0%',   color: 'transparent', text: '' },
                { width: '25%',  color: '#ff4d6a',     text: 'Lemah' },
                { width: '50%',  color: '#ffd166',     text: 'Cukup' },
                { width: '100%', color: '#00d4aa',     text: 'Kuat' }
            ];

            let lvl = levels[0];
            if (val.length > 0) {
                if (score <= 2) lvl = levels[1];
                else if (score === 3) lvl = levels[2];
                else lvl = levels[3];
            }

            strengthFill.style.width = lvl.width;
            strengthFill.style.background = lvl.color;
            strengthText.textContent = lvl.text;
            strengthText.style.color = lvl.color;
        });
    </script>
</body>
</html>