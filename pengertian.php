<?php
require_once 'db.php';
require_once 'header.php';
?>

<style>
  /* ===== SEKSI UTAMA DENGAN LATAR GAMBAR MEDIS ===== */
  #pengertian {
    padding: 80px 20px; 
    text-align: center;
    position: relative;
    min-height: 100vh; 
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    overflow: hidden; /* Mencegah efek blur meluber keluar seksi */
  }

  /* TRIK CSS: Membuat background terpisah agar bisa di-blur dan dikurangi resolusi visualnya */
  #pengertian::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(rgba(252, 248, 249, 0.75), rgba(252, 248, 249, 0.75)), 
                url('images/medis.jpg') center / cover no-repeat fixed;
    filter: blur(8px); /* -> Mengurangi ketajaman gambar agar tidak terlalu terlihat */
    transform: scale(1.05); /* -> Menghilangkan garis putih di pinggiran akibat efek blur */
    z-index: 1;
  }

  /* Judul diperbesar signifikan mengikuti ukuran card baru */
  #pengertian h2 {
    font-size: 3rem; 
    color: #2c3e50;
    margin-top: 0;
    margin-bottom: 35px;
    font-weight: 800;
    position: relative;
    display: inline-block;
    letter-spacing: 0.5px;
    z-index: 2; /* Naikkan z-index agar berada di atas background blur */
  }

  /* Garis dekoratif kecil di bawah judul dipertebal */
  #pengertian h2::after {
    content: '';
    display: block;
    width: 100px; 
    height: 5px;  
    background-color: #F57799; 
    margin: 12px auto 0 auto;
    border-radius: 3px;
  }

  /* ===== KONTEN UTAMA (CARD) DIUBAH MENJADI JAUH LEBIH BESAR & MEMANJANG ===== */
  .pengertian-content {
    max-width: 1350px; 
    width: 100%;
    margin: 0 auto;
    background-color: rgba(255, 255, 255, 0.95); 
    padding: 55px 65px; 
    border-radius: 20px; 
    box-shadow: 0 15px 40px rgba(245, 119, 153, 0.15); 
    line-height: 2.0; 
    color: #222; 
    text-align: left;
    backdrop-filter: blur(5px); 
    border-left: 8px solid #F57799; 
    box-sizing: border-box;
    z-index: 2; /* Naikkan z-index agar berada di atas background blur */
  }

  /* TULISAN PARAGRAF KEDUA (UKURAN STANDAR) */
  .pengertian-content p {
    margin-bottom: 25px; 
    font-size: 21px; /* Ukuran standar paragraf bawah */
    font-weight: 500; 
  }

  /* PENGATURAN KHUSUS: PARAGRAF PERTAMA MENJADI LEBIH BESAR */
  .pengertian-content p:first-of-type {
    font-size: 26px; /* Dibuat lebih besar dari paragraf kedua */
    font-weight: 600; /* Sedikit lebih tebal agar kontras */
    color: #1a252f;  /* Warna sedikit lebih tegas */
  }

  .pengertian-content p:last-child {
    margin-bottom: 0;
  }

  /* ===== MODIFIKASI KHUSUS CARD PENGERTIAN 70% ===== */
  .container-pengertian {
    display: flex;
    justify-content: center;
    width: 100%;
    padding: 40px 0;
  }

  .card-pengertian {
    width: 70% !important; 
    max-width: 1200px;
    background-color: #ffffff;
    border-radius: 20px;
    padding: 50px 60px; 
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    box-sizing: border-box;
  }

  .card-pengertian h2 {
    font-size: 36px !important; 
    color: #F57799;
    margin-bottom: 24px;
  }

  .card-pengertian p {
    font-size: 20px !important; 
    line-height: 1.8 !important; 
    color: #444;
    text-align: justify;
  }

  /* Optimasi Responsif untuk Layar HP */
  @media (max-width: 768px) {
    #pengertian {
      padding: 40px 15px;
    }
    #pengertian h2 {
      font-size: 2rem;
    }
    .pengertian-content {
      padding: 30px 25px;
    }
    /* Responsif untuk teks paragraf pertama di HP */
    .pengertian-content p:first-of-type {
      font-size: 20px;
    }
    .pengertian-content p {
      font-size: 17px;
    }
  }
</style>

<section id="pengertian">
  <h2>Pengertian Penyakit Paru-Paru</h2>
  <div class="pengertian-content">
    <p>
      Penyakit paru merupakan kondisi patologis pada organ paru yang menyebabkan gangguan fungsi respirasi dan pertukaran gas dalam tubuh.

    </p>
    <p>
      Beberapa penyakit paru yang umum dijumpai meliputi pneumonia, tuberkulosis (TBC), penyakit paru obstruktif kronis
      (PPOK), asma, dan kanker paru. Gejala yang sering muncul antara lain batuk berkepanjangan, sesak napas, nyeri
      dada, dan demam.
    </p>
  </div>
</section>

<?php require_once 'footer.php'; ?>