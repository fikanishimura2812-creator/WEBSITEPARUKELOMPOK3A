<?php
// ============================================
// HALAMAN LOGIN USER
// File: login.php
// ============================================

session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: index.php');
    } else {
        header('Location: PRJK 6.php');
    }
    exit;
}

require_once 'db.php';

$error = '';
$old_email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $old_email = htmlspecialchars($email);

    if (empty($email) || empty($password)) {
        $error = 'Email dan Password wajib diisi.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, username, email, password, role, nama_lengkap, usia FROM users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user_id']      = $user['id'];
                $_SESSION['username']     = $user['username'];
                $_SESSION['email']        = $user['email'];
                $_SESSION['role']         = $user['role'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['usia']         = $user['usia'];

                if ($user['role'] === 'admin') {
                    header('Location: index.php');
                } else {
                    header('Location: PRJK 6.php');
                }
                exit;
            } else {
                $error = 'Email atau Password yang Anda masukkan salah.';
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan sistem. Silakan coba lagi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Healthy Breath</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg: #fcf8f9; 
            --card: #ffffff;
            --border: #e2e8f0;
            --fg: #1e293b;
            --muted: #64748b;
            --accent: #F57799; 
            --accent-dim: rgba(245, 119, 153, 0.15);
            --danger: #ef4444;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--fg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden; /* Mencegah horizontal scroll akibat efek transform scale */
            z-index: 1;
        }

        /* KODE RESOLUSI GAMBAR LATAR BELAKANG (BLUR & SCALE) */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(rgba(252, 248, 249, 0.75), rgba(252, 248, 249, 0.75)), 
                        url('images/medis.jpg') center / cover no-repeat fixed;
            filter: blur(8px); /* -> Mengurangi ketajaman gambar agar tidak terlalu terlihat */
            transform: scale(1.05); /* -> Menghilangkan garis putih di pinggiran akibat efek blur */
            z-index: -1; /* Berada di belakang kartu login */
        }

        /* --- UKURAN CARD --- */
        .auth-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            width: 100%; 
            max-width: 540px; 
            position: relative; 
            z-index: 10;
            box-shadow: 0 20px 40px rgba(0,0,0,0.06);
            animation: cardIn 0.6s cubic-bezier(0.16,1,0.3,1) forwards;
            overflow: hidden;
        }
        @keyframes cardIn { 
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); } 
        }

        /* --- BANNER GAMBAR --- */
        .card-header-img {
            width: 100%;
            height: 180px; 
            object-fit: cover;
            border-bottom: 1px solid var(--border);
        }

        /* --- PADDING DALAM CARD --- */
        .card-body { padding: 40px 48px; }
        .auth-card h1 { font-size: 26px; font-weight: 700; margin-bottom: 8px; text-align: center; color: #2c3e50; }
        .auth-card .subtitle { color: var(--muted); font-size: 15px; margin-bottom: 32px; text-align: center; }

        .input-group { margin-bottom: 24px; }
        .input-group label { display: block; font-size: 14px; font-weight: 600; color: var(--fg); margin-bottom: 10px; }
        .input-wrapper { position: relative; }
        .input-wrapper i.field-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; font-size: 15px; }
        
        .input-wrapper input {
            width: 100%; padding: 14px 46px; background: #f8fafc;
            border: 1px solid var(--border); border-radius: 12px;
            color: var(--fg); font-size: 15px; outline: none; transition: all 0.3s;
        }
        .input-wrapper input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-dim); background: #fff; }
        .input-wrapper input:focus ~ i.field-icon { color: var(--accent); }

        .btn-primary {
            width: 100%; padding: 14px; background: var(--accent); color: #fff;
            border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer;
            transition: all 0.2s; margin-top: 12px; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-primary:hover { background: #e06284; box-shadow: 0 8px 20px rgba(245, 119, 153, 0.3); }

        .alert { padding: 14px 18px; border-radius: 12px; font-size: 14px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; }
        .alert-error { background: #fef2f2; border: 1px solid #fca5a5; color: var(--danger); }
        
        .auth-footer { text-align: center; margin-top: 28px; font-size: 15px; color: var(--muted); }
        .auth-footer a { color: var(--accent); font-weight: 600; text-decoration: none; }
        .toggle-pass { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--muted); cursor: pointer; font-size: 15px; }

        .divider { display: flex; align-items: center; gap: 14px; margin: 24px 0; color: var(--muted); font-size: 13px; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        
        @media (max-width: 640px) {
            .card-body { padding: 30px 24px; }
        }
    </style>
</head>
<body>

    <main class="auth-card">
        <img class="card-header-img" src="https://ciputrahospital.com/wp-content/uploads/2024/08/shutterstock_2478618273-1-scaled.jpg" alt="Healthy Breath Header">

        <div class="card-body">
            <h1>Selamat Datang</h1>
            <p class="subtitle">Harap login terlebih dahulu untuk masuk ke sistem</p>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= $error ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="" novalidate>
                <div class="input-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="contoh@email.com" value="<?= $old_email ?>" required>
                        <i class="fa-solid fa-envelope field-icon"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <i class="fa-solid fa-lock field-icon"></i>
                        <button type="button" class="toggle-pass" onclick="togglePassword('password', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Sekarang
                </button>
            </form>

            <div class="divider">atau</div>

            <div class="auth-footer">
                Belum punya akun? <a href="register.php">Daftar sekarang</a>
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
    </script>
</body>
</html>