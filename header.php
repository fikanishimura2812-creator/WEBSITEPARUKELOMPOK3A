<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Helper to get current page for active nav item
$current_page = basename($_SERVER['PHP_SELF']);
// Fix for spaces in filename URL decoding
$current_page = urldecode($current_page);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edukasi Paru-Paru</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      background-color: #f4f6f9;
    }

    /* ===== UKURAN KOTAK NAVBAR DIPERBESAR ===== */
    .topnav {
      position: sticky;
      top: 0;
      z-index: 1000;
      overflow: hidden;
      background-color: #FFF7CD;
      display: flex;
      align-items: center;
      padding: 0 32px; /* Padding samping diperluas dari 20px menjadi 32px */
      min-height: 80px; /* Ditambahkan min-height agar area box navbar lebih tinggi dan besar */
      box-shadow: 0 6px 12px -2px rgba(0, 0, 0, 0.12); /* Shadow disesuaikan agar lebih kokoh */
    }
    
    .nav-logos {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-right: 32px;
    }

    /* Logo dibuat lebih besar */
    .nav-logos img {
      height: 52px; /* Ukuran tinggi logo dinaikkan dari 40px ke 52px */
    }

    .nav-links {
      flex-grow: 1;
      display: flex;
      gap: 8px; /* Memberi jarak antar menu */
    }

    /* ===== UKURAN TULISAN MENU DIPERBESAR ===== */
    .nav-links a {
      color: #444;
      text-align: center;
      padding: 24px 22px; /* Padding ditambah dari 18px 16px menjadi 24px 22px agar box menu membesar */
      text-decoration: none;
      font-size: 18px; /* Ukuran teks menu dinaikkan dari 16px menjadi 18px */
      font-weight: 700; /* Font dibuat menjadi Bold tebal */
      transition: all 0.3s ease;
    }

    .nav-links a:hover {
      background-color: #F57799;
      color: white;
    }

    .nav-links a.active {
      background-color: #F57799;
      color: white;
    }

    .nav-user {
      display: flex;
      align-items: center;
      gap: 20px; /* Jarak komponen user disisihkan lebih lebar */
    }

    /* Teks sapaan nama user diperbesar */
    .user-greeting {
      color: #222;
      font-weight: 700;
      font-size: 17px; /* Ukuran teks sapaan dinaikkan */
      margin-right: 8px;
    }

    /* Tombol Logout dibuat lebih besar */
    .btn-logout {
      background-color: #ff4d6a;
      color: white;
      padding: 12px 26px; /* Padding diperbesar dari 10px 20px */
      text-decoration: none;
      font-weight: 700;
      font-size: 15px; /* Teks tombol diperbesar */
      border-radius: 24px; /* Radius melengkung disesuaikan */
      transition: all 0.3s ease;
    }

    .btn-logout:hover {
      background-color: #e63956;
      transform: translateY(-1px);
    }
    
    /* Tombol Dashboard/Login dibuat lebih besar */
    .btn-dashboard {
      background-color: #00d4aa;
      color: black;
      padding: 12px 26px; /* Padding diperbesar dari 10px 20px */
      text-decoration: none;
      font-weight: 700;
      font-size: 15px; /* Teks tombol diperbesar */
      border-radius: 24px;
      transition: all 0.3s ease;
    }

    .btn-dashboard:hover {
      background-color: #00b390;
      transform: translateY(-1px);
    }

    /* ===== SECTION ===== */
    section {
      padding: 50px;
      min-height: 70vh;
    }

    h2 {
      text-align: center;
      color: #F57799;
      margin-bottom: 20px;
    }

  </style>
</head>
<body>

<div class="topnav">
  <div class="nav-logos">
    <img src="images/POLTEK.png" alt="Logo Polije">
  </div>
  
  <div class="nav-links">
    <a class="<?= ($current_page == 'PRJK 6.php') ? 'active' : '' ?>" href="PRJK 6.php">Home</a>
    <a class="<?= ($current_page == 'pengertian.php') ? 'active' : '' ?>" href="pengertian.php">Pengertian</a>
    <a class="<?= ($current_page == 'macam_penyakit.php') ? 'active' : '' ?>" href="macam_penyakit.php">Macam Penyakit</a>
    <a class="<?= ($current_page == 'our_team.php') ? 'active' : '' ?>" href="our_team.php">Our Team</a>
  </div>
  
  <div class="nav-user">
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <a href="index.php" class="btn-dashboard"><i class="fa-solid fa-arrow-left"></i> Dashboard</a>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['user_id'])): ?>
      <span class="user-greeting">
          Halo, <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? $_SESSION['username']) ?>
      </span>
      <a href="logout.php" class="btn-logout">Logout</a>
    <?php else: ?>
      <a href="login.php" class="btn-dashboard">Login</a>
    <?php endif; ?>
  </div>
</div>