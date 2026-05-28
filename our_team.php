<?php
require_once 'db.php';
require_once 'header.php';
?>

<style>
  /* ===== TEAM MODERN ===== */
  .team-section {
    padding: 80px 20px; 
    position: relative;
    overflow: hidden;
    min-height: 80vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 1;
  }

  /* KODE RESOLUSI GAMBAR LATAR BELAKANG (BLUR & SCALE) */
  .team-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(rgba(252, 248, 249, 0.75), rgba(252, 248, 249, 0.75)), 
                url('images/medis.jpg') center / cover no-repeat fixed;
    filter: blur(8px); /* -> Mengurangi ketajaman gambar agar tidak terlalu terlihat */
    transform: scale(1.05); /* -> Menghilangkan garis putih di pinggiran akibat efek blur */
    z-index: -1; /* Berada di belakang konten utama */
  }

  .team-section h2 {
    color: #F57799;
    margin-bottom: 50px;
    font-size: 42px; 
    font-weight: 800;
    text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.8);
    position: relative;
    z-index: 2;
  }

  /* BARIS TEAM */
  .team-row {
    display: flex;
    justify-content: center;
    gap: 35px; 
    margin-bottom: 35px;
    flex-wrap: wrap;
    position: relative;
    z-index: 2;
  }

  /* CARD DENGAN KURSOR POINTER (TANDA BISA DIKLIK) */
  .team-card {
    background: rgba(255, 255, 255, 0.95); 
    width: 320px; 
    padding: 35px 25px; 
    text-align: center;
    border-radius: 20px; 
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    cursor: pointer; /* Indikator bahwa kartu ini interaktif */
    overflow: hidden;
  }

  .team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(245, 119, 153, 0.2); 
  }

  /* FOTO PROFIL */
  .team-card img {
    width: 160px; 
    height: 160px; 
    border-radius: 50%;
    border: 5px solid #F57799; 
    margin-bottom: 20px;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  /* TULISAN NAMA */
  .team-card h4 {
    margin: 15px 0 8px;
    color: #F57799;
    font-size: 22px; 
    font-weight: 700;
    letter-spacing: 0.5px;
  }

  /* TULISAN NIM & WA */
  .team-card p {
    margin: 6px 0;
    font-size: 16px; 
    color: #444; 
    font-weight: 500;
  }

  /* CONTAINER UNTUK JOBDESK (DIBUAT SEMBUNYI DI AWAL) */
  .jobdesk-container {
    max-height: 0;
    opacity: 0;
    overflow: hidden;
    transition: max-height 0.4s ease, opacity 0.4s ease, margin-top 0.4s ease;
    text-align: left;
    background: #fff5f7;
    border-radius: 10px;
    border-left: 4px solid #F57799;
  }

  .jobdesk-container p {
    padding: 15px;
    margin: 0;
    font-size: 14px;
    line-height: 1.5;
    color: #555;
  }

  /* CLASS AKTIF SAAT CARD DIKLIK (AKAN DITAMBAHKAN LEWAT JAVASCRIPT) */
  .team-card.active {
    box-shadow: 0 15px 35px rgba(245, 119, 153, 0.3);
    border: 1px solid rgba(245, 119, 153, 0.3);
  }

  .team-card.active .jobdesk-container {
    max-height: 200px; /* Batas tinggi maksimal saat terbuka */
    opacity: 1;
    margin-top: 20px;
  }

  .team-card.active img {
    transform: scale(0.9); /* Sedikit mengecilkan foto agar komposisi tetap seimbang saat terbuka */
  }

  /* Petunjuk Klik */
  .click-hint {
    font-size: 12px !important;
    color: #bbb !important;
    font-style: italic;
    margin-top: 10px !important;
  }
  .team-card.active .click-hint {
    display: none;
  }

  /* RESPONSIVE HP */
  @media (max-width: 768px) {
    .team-row {
      flex-direction: column;
      align-items: center;
      gap: 25px;
    }
    .team-card {
      width: 85%; 
      max-width: 320px;
    }
  }
</style>

<section id="team" class="team-section">
  <h2>Our Team</h2>

  <div class="team-row">

    <div class="team-card" onclick="toggleJobdesk(this)">
      <img src="images/ACA.jpeg" alt="Luisca Firnanda">
      <h4>LUISCA FIRNANDA</h4>
      <p>NIM: G43250239</p>
      <p>WA: 081234567890</p>
      <p class="click-hint">Klik untuk lihat Jobdesk</p>
      <div class="jobdesk-container">
        <p><strong>Jobdesk : Project Manager</strong><br> bertanggung jawab atas manajemen waktu pengembangan sistem dan koordinasi antar anggota tim.</p>
      </div>
    </div>

    <div class="team-card" onclick="toggleJobdesk(this)">
      <img src="images/fika.jpeg" alt="Fika Febrianti">
      <h4>FIKA FEBRIANTI</h4>
      <p>NIM: G43250045</p>
      <p>WA: 081234567891</p>
      <p class="click-hint">Klik untuk lihat Jobdesk</p>
      <div class="jobdesk-container">
        <p><strong>Jobdesk : Frontend Developer</strong><br> bertugas menyusun layout antarmuka (UI/UX) dan menerapkan struktur CSS/styling halaman web.</p>
      </div>
    </div>

    <div class="team-card" onclick="toggleJobdesk(this)">
      <img src="images/liya.jpeg" alt="Siti Kamaliyah">
      <h4>SITI KAMALIYAH</h4>
      <p>NIM: G43250701</p>
      <p>WA: 081234567892</p>
      <p class="click-hint">Klik untuk lihat Jobdesk</p>
      <div class="jobdesk-container">
        <p><strong>Jobdesk : Backend Developer</strong><br> mengurus arsitektur database, koneksi file db.php, serta logika pengolahan data aplikasi PHP.</p>
      </div>
    </div>

  </div>

  <div class="team-row">

    <div class="team-card" onclick="toggleJobdesk(this)">
      <img src="images/sep.jpeg" alt="Iriana Septia">
      <h4>IRYANA SEPTIA RAMADHANI</h4>
      <p>NIM: G43250396</p>
      <p>WA: 081234567893</p>
      <p class="click-hint">Klik untuk lihat Jobdesk</p>
      <div class="jobdesk-container">
        <p><strong>Jobdesk : System Analyst & Content Writer</strong><br> meriset materi medis penyakit paru-paru dan menyusun alur pengkondisian data informasi.</p>
      </div>
    </div>

    <div class="team-card" onclick="toggleJobdesk(this)">
      <img src="images/ney.jpeg" alt="Naysha Arifah">
      <h4>NAYSHA PURTI ARIFAH</h4>
      <p>NIM: G43250499</p>
      <p>WA: 081234567894</p>
      <p class="click-hint">Klik untuk lihat Jobdesk</p>
      <div class="jobdesk-container">
        <p><strong>Jobdesk : quality Assurance & Tester</strong><br>melakukan uji coba fungsionalitas sistem (link detail, responsive testing) serta mendeteksi bug.</p>
      </div>
    </div>

  </div>
</section>

<script>
  function toggleJobdesk(card) {
    // Opsional: Hapus komentar baris di bawah jika ingin card lain otomatis tertutup saat ada card baru yang diklik
    /*
    document.querySelectorAll('.team-card').forEach(c => {
      if(c !== card) c.classList.remove('active');
    });
    */
    
    // Toggle class active pada card yang diklik
    card.classList.toggle('active');
  }
</script>

<?php require_once 'footer.php'; ?>