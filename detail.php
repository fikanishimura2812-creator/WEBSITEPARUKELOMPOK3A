<?php
require_once 'db.php';
require_once 'header.php';

// Mengambil parameter penyakit dari URL, jika tidak ada default ke 'asma'
$penyakit = isset($_GET['penyakit']) ? $_GET['penyakit'] : 'asma';

// Menyiapkan data lengkap untuk masing-masing penyakit (Teks dipertahankan 100% asli)
$data_penyakit = [
    'asma' => [
        'judul' => 'Asma',
        'gambar' => 'images/asma.jpeg',
        'pengertian' => 'Asma adalah penyakit pernapasan kronis yang ditandai dengan peradangan dan penyempitan saluran napas, sehingga menimbulkan sesak napas, dada terasa berat, dan batuk-batuk.',
        'penyebab' => 'Asma disebabkan oleh interaksi lingkungan dan genetika yang merupakan kombinasi yang rumit dan belum sepenuhnya dimengerti. Semua faktor ini memengaruhi baik tingkat keparahan dan juga respons terhadap terapi.Adanya peningkatan laju penderita asma belakangan ini disebabkan oleh perubahan faktor epigenetik (terwariskan selain adanya hubungan dengan urutan DNA) dan lingkungan hidup yang berubah.',
        'pencegahan' => 'Asma dapat dicegah dengan cara menghindari faktor-faktor yang memicu kambuhnya gangguan pernapasan. Pencegahan dilakukan dengan menjaga kebersihan lingkungan agar bebas dari debu, asap rokok, bulu hewan, dan polusi udara yang dapat mengiritasi saluran napas. Penderita asma juga dianjurkan menggunakan masker saat berada di tempat berdebu atau ketika kualitas udara buruk. Selain itu, menjaga kesehatan tubuh dengan mengonsumsi makanan bergizi, olahraga ringan secara teratur, istirahat yang cukup, dan minum air putih yang cukup sangat penting untuk meningkatkan daya tahan tubuh. Mengelola stres dan emosi juga diperlukan karena kondisi psikologis dapat memicu serangan asma. Pemeriksaan kesehatan secara rutin serta penggunaan obat atau inhaler sesuai anjuran dokter membantu mengontrol gejala asma dan mencegah kekambuhan yang lebih berat.',
        'penanganan' => 'Gunakan inhaler pelega saat serangan terjadi, tetap tenang, duduk tegak, and longgarkan pakaian. Cari tempat dengan udara bersih.',
        'obat' => 'Bronkodilator (inhaler pelega seperti Salbutamol) untuk serangan akut, dan Kortikosteroid inhalasi sebagai obat pengontrol jangka panjang.'
    ],
    'bronkitis' => [
        'judul' => 'Bronkitis',
        'gambar' => 'images/bronkitis1.jpeg',
        'pengertian' => 'Peradangan pada saluran bronkus (saluran utama yang membawa udara ke paru-paru) yang menyebabkan penebalan dinding saluran dan produksi lendir berlebih.',
        'penyebab' => 'Sekret menumpuk → bersihan jalan napas tidak efektif Produksi sekret berlebihan dan sekret yang menumpuk menghambat pembersihan saluran napas sehingga jalan napas menjadi tidak paten dan risiko gangguan napas meningkat,Sekret menyumbat/menimbulkan gangguan saluran napas → Sekresi yang menumpuk dapat mengakibatkan gangguan pada saluran napas sehingga penderita mengalami sesak napas; karena kebutuhan oksigen tidak terpenuhi.',
        'pencegahan' => 'Fokus intervensi: tingkatkan pembersihan sekret agar jalan napas tetap paten,Semi Fowler untuk membantu ekspansi paru dan memudahkan bernapas,Fisioterapi dada + latihan batuk efektif untuk mengeluarkan sekret,Pengaturan asupan cairan untuk membantu pengenceran sekret.',
        'penanganan' => 'Perbanyak istirahat, minum air putih hangat yang banyak untuk mengencerkan dahak, dan gunakan pelembap udara (humidifier) di ruangan.',
        'obat' => 'Obat batuk pengencer dahak (Ekspektoran), obat pereda nyeri/demam (Paracetamol), atau Antibiotik jika disebabkan oleh infeksi bakteri.'
    ],
    'tbc' => [
        'judul' => 'Tuberkulosis (TBC)',
        'gambar' => 'images/TBC1.jpeg',
        'pengertian' => 'Penyakit infeksi menular paru-paru yang berpotensi serius dan dapat menyebar ke organ tubuh lain jika tidak ditangani dengan benar.',
        'penyebab' => 'Infeksi bakteri bernama <em>Mycobacterium tuberculosis</em> yang menyerang paru-paru dapat menular melalui udara dan percikan ludah (droplet) saat penderita batuk atau bersin.',
        'pencegahan' => 'Terapkan Perilaku Hidup Bersih dan Sehat (PHBS) antara lain seperti mengonsumsi makanan bergizi seimbang,hindari perilaku merokok dan konsumsi alkohol,menjalankan etika batuk yang tepat,menggunakan masker,menjaga lingkungan sekitar tetap bersih,Vaksinasi BCG bagi bayi baru lahir,Terapi Pencegahan Tuberkulosis (TPT) sebagai obat pencegahan agar tidak tertular TBC, terutama bagi kontak serumah..',
        'penanganan' => 'Wajib mengisolasi diri di awal pengobatan agar tidak menularkan ke keluarga, serta patuh minum obat setiap hari tanpa terputus selama minimal 6 bulan.',
        'obat' => 'Kombinasi Obat Anti Tuberkulosis (OAT) seperti Isoniazid, Rifampisin, Pirasinamid, dan Etambutol yang diberikan di bawah pengawasan dokter.'
    ],
    'pneumonia' => [
        'judul' => 'Pneumonia (Paru-Paru Basah)',
        'gambar' => 'images/pneumoni1.jpeg',
        'pengertian' => 'Pneumonia merupakan infeksi pada paru-paru yang menyebabkan kantung udara di paru-paru terisi cairan atau nanah sehingga penderitanya mengalami batuk, demam, sesak napas, dan nyeri dada.',
        'penyebab' => 'Penyebab pneumonia umumnya berasal dari infeksi bakteri, virus, atau jamur. Bakteri yang paling sering menyebabkan pneumonia adalah <em>Streptococcus pneumoniae</em>, sedangkan virus flu dan beberapa jenis jamur juga dapat menjadi penyebab, terutama pada orang dengan daya tahan tubuh lemah. Risiko pneumonia meningkat pada bayi, lansia, perokok, penderita penyakit kronis, serta orang yang memiliki sistem imun rendah. Selain itu, paparan polusi udara, asap rokok, kebersihan lingkungan yang buruk, dan infeksi saluran pernapasan yang tidak ditangani dengan baik juga dapat memicu terjadinya pneumonia.',
        'pencegahan' => 'menjaga kebersihan diri dan lingkungan, seperti mencuci tangan secara rutin, menggunakan masker saat sakit atau berada di lingkungan berpolusi, serta menjaga sirkulasi udara rumah tetap baik. Menghindari rokok dan asap rokok juga penting karena dapat merusak paru-paru dan meningkatkan risiko infeksi. Selain itu, menjaga daya tahan tubuh dengan mengonsumsi makanan bergizi, olahraga teratur, istirahat cukup, dan minum air yang cukup dapat membantu tubuh melawan infeksi. Imunisasi seperti vaksin pneumonia dan vaksin influenza juga dianjurkan, terutama bagi anak-anak, lansia, dan orang yang memiliki risiko tinggi terkena pneumonia.',
        'penanganan' => 'Istirahat total, pastikan asupan cairan tubuh terpenuhi, pantau kadar oksigen darah secara berkala, dan segera ke rumah sakit jika sesak memburuk.',
        'obat' => 'Antibiotik (jika karena bakteri), Antivirus (jika karena virus), serta obat penurun demam dan pereda batuk.'
    ],
    'kanker' => [
        'judul' => 'Kanker Paru-Paru',
        'gambar' => 'images/kenker.jpeg',
        'pengertian' => 'Kondisi di mana sel-sel di dalam jaringan paru-paru tumbuh secara abnormal, tidak terkendali, dan merusak sel tubuh yang sehat di sekitarnya.',
        'penyebab' => 'Kebiasaan Merokok,Paparan Zat Karsinogenik,Faktor Genetik dan Mutasi Gen,Kondisi kekebalan tubuh, diet, dan riwayat keluarga juga dapat memengaruhi risiko seseorang terkena kanker paru.',
        'pencegahan' => 'Waspadai Gejala Klinis Sejak Dini: Gejala seperti sesak napas, batuk kronis, nyeri dada yang menjalar ke punggung, dan penurunan berat badan yang drastis (dalam kasus ini turun 20 kg dalam 6 bulan) adalah tanda peringatan penting yang harus segera diperiksa,Pentingnya Diagnosis yang Akurat:Pemeriksaan CT-Scan toraks, pemeriksaan histopatologik,Kemoterapi pada Stadium Lanjut,Manajemen Nyeri yang Komprehensif,Berhenti Merokok',
        'penanganan' => 'Pemeriksaan rutin (skrining) sejak dini, menjaga pola makan tinggi antioksidan, dan mengikuti prosedur medis yang disarankan dokter onkologi.',
        'obat' => 'Tergantung stadium: Tindakan operasi pengangkatan tumor, Kemoterapi, Radioterapi (terapi radiasi), atau Terapi Target.'
    ],
    'ispa' => [
        'judul' => 'ISPA (Infeksi Saluran Pernapasan Akut)',
        'gambar' => 'images/ispa1.jpeg',
        'pengertian' => 'ISPA yaitu Infeksi yang disebabkan oleh mikroorganisme distruktur saluran nafas atas yang tidak berfungsi untuk pertukuran gas, termasuk rongga hidung, faring dan laring, yang dikenal dengan ISPA antara lain pilek, faringitis (radang tenggorokan, laringitis, dan Influenza tanpak komplikas, ISPA terdiri dari 300 jenis bakteri, virus dan riketsia.',
        'penyebab' => 'ISPA disebabkan oleh infeksi berbagai jenis virus seperti genus Streptokokus, Stafilokokus, Pnemokokus, Hemofillus, Bordetelia dan korinebakterium.',
        'pencegahan' => 'Infeksi saluran pernafasan akut dapat dicegah dengan meningkatkan daya tahan tubuh (imunitas). Ada beberapa cara yang dilakukan oleh penderita antara lain : berjemur,rajin mencuci tangan,menghindari asap rokok,mengkomsumsi makanan yang sehat dan bergerak aktif.',
        'penanganan' => 'Istirahat yang cukup, konsumsi makanan bergizi untuk meningkatkan imun, dan minum ramuan hangat (seperti air lemon hangat madu) untuk meredakan tenggorokan.',
        'obat' => 'Obat-obatan simtomatik (hanya meredakan gejala) seperti Dekongestan untuk hidung tersumbat, Paracetamol untuk demam, dan vitamin penambah imun.'
    ]
];

// Jika penyakit tidak ditemukan di daftar, arahkan kembali atau tampilkan pesan aman
if (!array_key_exists($penyakit, $data_penyakit)) {
    echo "<div style='text-align:center; padding:50px;'><h2>Data Penyakit Tidak Ditemukan.</h2></div>";
    include_once 'footer.php';
    exit;
}

$detail = $data_penyakit[$penyakit];
?>

<style>
  #detail-penyakit {
    background-image: linear-gradient(rgba(252, 248, 249, 0.65), rgba(252, 248, 249, 0.65)), 
                      url('images/medis.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed; 
  }

  .btn-close-page {
    display: inline-block;
    background-color: #e25c80;
    color: white !important;
    text-decoration: none;
    padding: 14px 28px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    margin-bottom: 25px;
    letter-spacing: 0.5px;
  }
  
  .btn-close-page:hover {
    background-color: #c44569;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
  }

  .btn-close-page:active {
    transform: translateY(1px);
  }

  .large-card {
    max-width: 1350px; 
    margin: 0 auto;
    background: rgba(255, 255, 255, 0.97);
    border-radius: 16px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    overflow: hidden;
  }

  /* Bagian Box Banner */
  .card-banner {
    width: 100%;
    height: 360px; 
    position: relative;
    background-color: #f8f9fa; /* Latar belakang abu netral jika gambar rasionya berbeda */
  }

  /* CSS Gambar Banner: Menampilkan utuh tanpa terpotong */
  .card-banner img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Gambar akan mengecil secara proporsional agar muat sepenuhnya */
    padding: 15px 0;
    box-sizing: border-box;
  }

  .card-banner-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.75)); 
    padding: 30px;
    z-index: 2;
  }

  .card-banner-overlay h1 {
    color: #fff;
    margin: 0;
    font-size: 36px;
    text-shadow: 2px 2px 5px rgba(0,0,0,0.8);
  }

  .card-content {
    padding: 40px;
  }

  .section-box {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px dashed #ffd6e0;
  }

  .section-box:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
  }

  .section-title {
    color: #F57799;
    font-size: 22px;
    margin-top: 0;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    font-weight: bold;
  }

  .section-title::before {
    content: "✦";
    margin-right: 10px;
    color: #F57799;
  }

  .section-text {
    color: #333;
    font-size: 16px;
    line-height: 1.8;
    margin: 0;
  }

  @media (max-width: 768px) {
    .card-banner {
      height: 220px;
    }
    .card-banner-overlay h1 {
      font-size: 24px;
    }
    .card-content {
      padding: 25px;
    }
    .btn-close-page {
      width: 100%;
      text-align: center;
      box-sizing: border-box;
    }
  }
</style>

<section id="detail-penyakit">
  <div style="max-width: 1350px; margin: 0 auto; text-align: left;">
    <a href="javascript:window.close();" class="btn-close-page">← Tutup Halaman Ini</a>
  </div>

  <div class="large-card">
    <div class="card-banner">
      <img src="<?php echo $detail['gambar']; ?>" alt="<?php echo $detail['judul']; ?>">
      <div class="card-banner-overlay">
        <h1>Informasi Lengkap: <?php echo $detail['judul']; ?></h1>
      </div>
    </div>

    <div class="card-content">
      
      <div class="section-box">
        <h2 class="section-title">Pengertian</h2>
        <p class="section-text"><?php echo $detail['pengertian']; ?></p>
      </div>

      <div class="section-box">
        <h2 class="section-title">Penyebab Utama</h2>
        <p class="section-text"><?php echo $detail['penyebab']; ?></p>
      </div>

      <div class="section-box">
        <h2 class="section-title">Cara Pencegahan</h2>
        <p class="section-text"><?php echo $detail['pencegahan']; ?></p>
      </div>

      <div class="section-box">
        <h2 class="section-title">Cara Penanganan (Pertolongan Pertama)</h2>
        <p class="section-text"><?php echo $detail['penanganan']; ?></p>
      </div>

      <div class="section-box">
        <h2 class="section-title">Rekomendasi Obat / Medis</h2>
        <p class="section-text"><?php echo $detail['obat']; ?></p>
      </div>

    </div>
  </div>
</section>

<?php require_once 'footer.php'; ?>