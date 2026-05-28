<?php
require_once 'db.php';
require_once 'header.php';
?>

<style>
  #macam-penyakit {
    position: relative;
    padding: 50px 20px;
    overflow: hidden;
    z-index: 1;
  }

  /* Membuat background terpisah agar bisa di-blur tanpa merusak teks di dalamnya */
  #macam-penyakit::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(rgba(252, 248, 249, 0.75), rgba(252, 248, 249, 0.75)), 
                url('images/medis.jpg') center / cover no-repeat fixed;
    filter: blur(8px); /* -> Mengurangi ketajaman gambar agar tidak terlalu terlihat */
    transform: scale(1.05); /* -> Menghilangkan garis putih di pinggiran akibat efek blur */
    z-index: -1; /* Dipertahankan -1 agar berada di bawah teks dan card */
  }

  #macam-penyakit h2 {
    text-align: center;
    color: #F57799;
    margin-bottom: 40px;
    font-size: 34px;
    /* Menambahkan bayangan halus agar teks judul tetap kontras dengan gambar */
    text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.8);
    position: relative;
    z-index: 2;
  }

  .cards-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* Tetap 3 card per baris */
    gap: 30px;
    position: relative;
    z-index: 2;
  }

  .disease-card {
    background: rgba(255, 255, 255, 0.95); /* Sedikit transparan agar serasi dengan background */
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transition: 0.3s;
    display: flex;
    flex-direction: column;
  }

  .disease-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
  }

  .disease-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
  }

  .disease-info {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Menjaga tombol tetap sejajar di bagian bawah */
  }

  .disease-title {
    color: #F57799;
    font-size: 24px;
    margin-top: 0;
    margin-bottom: 15px;
  }

  .disease-detail {
    margin-bottom: 20px;
    color: #555;
    line-height: 1.6;
    font-size: 15px;
  }

  .disease-detail strong {
    color: #333;
  }

  /* CSS Tombol Pelajari Lebih Lanjut */
  .btn-detail {
    display: block;
    text-align: center;
    background-color: #F57799;
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 25px;
    font-weight: bold;
    font-size: 14px;
    transition: background 0.3s, transform 0.2s;
  }

  .btn-detail:hover {
    background-color: #d65c7d;
    transform: scale(1.02);
  }

  /* Responsive Tablet */
  @media (max-width: 992px) {
    .cards-container {
      grid-template-columns: repeat(2, 1fr); /* Layar tablet otomatis jadi 2 baris */
    }
  }

  /* Responsive HP */
  @media (max-width: 600px) {
    .cards-container {
      grid-template-columns: 1fr; /* Layar HP otomatis jadi 1 kolom ke bawah */
    }
  }
</style>

<section id="macam-penyakit">
  <h2>Macam-Macam Penyakit Paru-Paru</h2>

  <div class="cards-container">

    <div class="disease-card">
      <img src="images/asma.jpeg" alt="Asma">
      <div class="disease-info">
        <div>
          <h3 class="disease-title">Asma</h3>
          <div class="disease-detail">
            <strong>Pengertian:</strong> Asma adalah penyakit pernapasan kronis umum yang mempengaruhi 1–18% populasi di berbagai negara.
          </div>
        </div>
        <a href="detail.php?penyakit=asma" target="_blank" class="btn-detail">Pelajari Lebih Lanjut</a>
      </div>
    </div>

    <div class="disease-card">
      <img src="images/bronkitis1.jpeg" alt="Bronkitis">
      <div class="disease-info">
        <div>
          <h3 class="disease-title">Bronkitis</h3>
          <div class="disease-detail">
            <strong>Pengertian:</strong> Bronkitis adalah peradangan pada saluran bronkus yang menyebabkan pembengkakan dan produksi lendir berlebih.
          </div>
        </div>
        <a href="detail.php?penyakit=bronkitis" target="_blank" class="btn-detail">Pelajari Lebih Lanjut</a>
      </div>
    </div>

    <div class="disease-card">
      <img src="images/TBC1.jpeg" alt="TBC">
      <div class="disease-info">
        <div>
          <h3 class="disease-title">Tuberkulosis (TBC)</h3>
          <div class="disease-detail">
            <strong>Pengertian:</strong> Tuberculosis (TB) adalah penyakit yang disebabkan oleh Mycobacterium tuberculosis.
          </div>
        </div>
        <a href="detail.php?penyakit=tbc" target="_blank" class="btn-detail">Pelajari Lebih Lanjut</a>
      </div>
    </div>

    <div class="disease-card">
      <img src="images/pneumoni1.jpeg" alt="Pneumonia">
      <div class="disease-info">
        <div>
          <h3 class="disease-title">Pneumonia</h3>
          <div class="disease-detail">
            <strong>Pengertian:</strong> Pneumonia merupakan suatu infeksi atau peradangan akut pada parenkim paru yang ditandai adanya infiltrat pada paru.
          </div>
        </div>
        <a href="detail.php?penyakit=pneumonia" target="_blank" class="btn-detail">Pelajari Lebih Lanjut</a>
      </div>
    </div>

    <div class="disease-card">
      <img src="images/kenker.jpeg" alt="Kanker Paru-Paru">
      <div class="disease-info">
        <div>
          <h3 class="disease-title">Kanker Paru-Paru</h3>
          <div class="disease-detail">
            <strong>Pengertian:</strong> Kanker paru-paru adalah penyakit yang terjadi akibat pertumbuhan sel abnormal yang tidak terkendali pada jaringan paru-paru.
          </div>
        </div>
        <a href="detail.php?penyakit=kanker" target="_blank" class="btn-detail">Pelajari Lebih Lanjut</a>
      </div>
    </div>

    <div class="disease-card">
      <img src="images/ispa1.jpeg" alt="ISPA">
      <div class="disease-info">
        <div>
          <h3 class="disease-title">ISPA</h3>
          <div class="disease-detail">
            <strong>Pengertian:</strong> Infeksi saluran Pernafasan akut merupakan penyakit saluran pernapasan atas atau bawah yang bersifat akut.
          </div>
        </div>
        <a href="detail.php?penyakit=ispa" target="_blank" class="btn-detail">Pelajari Lebih Lanjut</a>
      </div>
    </div>

  </div>
</section>

<?php require_once 'footer.php'; ?>