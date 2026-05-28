<?php
session_start();

// Proteksi halaman: Jika tidak ada session user_id, tendang ke login.php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';
require_once 'header.php';

// Mengambil nama lengkap dari session (jika ada), kalau tidak ada pakai username
$nama_user = $_SESSION['nama_lengkap'] ?? $_SESSION['username'] ?? 'Pengguna';
?>

<style>
/* ===== GLOBAL ===== */
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body{
  font-family: 'Segoe UI', Verdana, sans-serif;
  background-color: #fcf8f9;
  color: #333;
}

/* ===== FIX NAVBAR MARGIN ===== */
header,
nav,
.navbar{
  margin-bottom: 0 !important;
  padding-bottom: 0 !important;
}

/* ===== CONTAINER TENGAH MUTLAK DENGAN BACKGROUND ===== */
.main-content {
  position: relative; 
  overflow: hidden;   
  min-height: calc(100vh - 140px); 
  display: flex;
  align-items: center;     
  justify-content: center;   
  padding: 40px 20px;
  z-index: 1;
}

/* KODE RESOLUSI GAMBAR LATAR BELAKANG (BLUR & SCALE) */
.main-content::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: linear-gradient(rgba(252, 248, 249, 0.75), rgba(252, 248, 249, 0.75)), 
              url('images/medis.jpg') center / cover no-repeat fixed;
  filter: blur(8px); 
  transform: scale(1.05); 
  z-index: -1; 
}

/* ===== HERO SECTION ===== */
.hero-section{
  text-align: center;
  max-width: 1150px; /* Diperlebar agar barisan 1 baris card muat sempurna */
  animation: scaleIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  position: relative;
  z-index: 2;
  width: 100%;
}

/* TULISAN SELAMAT DATANG (WARNA DIPERTEGAS AGAR LEBIH KELIHATAN) */
.welcome-text {
  font-size: 1.8rem; 
  color: #4a5568; /* Diubah dari #7f8c8d ke abu-abu gelap solid agar lebih kontras */
  font-weight: 700; /* Dibuat lebih tebal */
  text-transform: uppercase;
  letter-spacing: 4px;
  margin-bottom: 15px;
  text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.9); /* Bayangan putih tipis di belakang huruf */
}

/* Judul Utama RAKSASA */
.hero-section h1{
  font-size: 5rem; /* Sedikit disesuaikan agar proporsional dengan layout 1 baris */
  color: #2c3e50;
  margin-bottom: 20px;
  font-weight: 900;    
  letter-spacing: -1px;
  line-height: 1.1;
}

.hero-section h1 span{
  color: #F57799;
  text-shadow: 0 4px 20px rgba(245, 119, 153, 0.2);
}

/* Deskripsi */
.hero-section p.description{
  font-size: 1.3rem; 
  color: #7f8c8d;
  max-width: 700px;
  margin: 0 auto 40px auto; 
  line-height: 1.6;
}

/* ===== STRUKTUR CARD BARU (DIPAKSA 1 BARIS DI DEKTOP) ===== */
.features-container {
  display: flex;
  justify-content: center;
  gap: 20px;
  flex-wrap: nowrap; /* MEMAKSA CARD TETAP SATU BARIS (TIDAK TURUN) */
  width: 100%;
  margin-top: 10px;
}

.feature-card {
  background: rgba(255, 255, 255, 0.95);
  border-radius: 18px;
  padding: 25px 20px;
  flex: 1; /* Membagi rata lebar baris ke semua card */
  min-width: 250px; /* Batas minimal lebar card sebelum layar mengecil */
  text-align: left;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-top: 5px solid #F57799; 
}

.feature-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(245, 119, 153, 0.15);
}

.feature-card h3 {
  color: #2c3e50;
  font-size: 1.25rem;
  margin-bottom: 12px;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 8px; 
}

.feature-card p {
  color: #555;
  font-size: 0.9rem;
  line-height: 1.5;
}

.feature-card strong {
  color: #c0392b; 
}

/* Animasi muncul */
@keyframes scaleIn {
  from { opacity: 0; transform: scale(0.96) translateY(20px); }
  to { opacity: 1; transform: scale(1) translateY(0); }
}

/* Responsif untuk Smartphone & Tablet (Otomatis Susun ke Bawah jika Layar Sempit) */
@media (max-width: 992px) {
  .features-container { 
    flex-wrap: wrap; /* Mengembalikan ke mode bungkus di tablet/HP agar tidak rusak */
  }
  .feature-card { 
    flex: none; 
    width: 100%; 
    max-width: 350px; 
  }
}

@media (max-width: 768px) {
  .hero-section h1 { font-size: 3.2rem; }
  .welcome-text { font-size: 1.2rem; letter-spacing: 2px; }
  .hero-section p.description { font-size: 1.1rem; margin-bottom: 30px; }
  .main-content { min-height: calc(100vh - 200px); padding: 30px 15px; }
}
</style>

<main class="main-content">
  <section class="hero-section">
    <p class="welcome-text">Selamat Datang, <?= htmlspecialchars($nama_user) ?>! 👋</p>
    <h1>Healthy <span>Breath</span></h1>
    <p class="description">
      Investasi terbaik untuk masa depan adalah menjaga setiap
      hembusan napas kita tetap bersih, segar, dan sehat.
    </p>

    <div class="features-container">
      
      <div class="feature-card">
        <h3>🦠 Infeksi Mikroorganisme</h3>
        <p>Sebagian besar kasus disebabkan serangan <strong>bakteri, virus, atau jamur</strong> yang merusak alveolus.</p>
      </div>

      <div class="feature-card">
        <h3>🚬 Polusi & Rokok</h3>
        <p>Paparan asap rokok dan <strong>polusi udara jalanan</strong> memicu radang kronis hingga kanker paru.</p>
      </div>

      <div class="feature-card">
        <h3>🧬 Genetik & Alergi</h3>
        <p>Faktor keturunan bawaan membuat saluran napas sensitif terhadap pemicu lingkungan seperti <strong>Asma</strong>.</p>
      </div>

    </div>
  </section>
</main>

<?php require_once 'footer.php'; ?>