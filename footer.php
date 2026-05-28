<style>
  /* ===== FOOTER ===== */
  footer {
    text-align: center;
    background-color: #F57799;
    color: white;
    padding: 20px 15px; /* Padding atas-bawah ditambah sedikit agar seimbang dengan logo yang membesar */
    margin-top: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px; /* Jarak antar logo dan teks diperlebar agar tidak terlalu rapat */
    font-weight: 500;
  }

  footer img {
    height: 50px; /* UKURAN LOGO DIPERBESAR dari 30px menjadi 50px */
    width: auto;
    object-fit: contain;
    /* Latar belakang putih tetap terhapus secara mutlak */
  }

  /* Responsif untuk HP agar logo tidak terlalu raksasa saat layar sempit */
  @media (max-width: 576px) {
    footer {
      gap: 15px;
      font-size: 14px;
    }
    footer img {
      height: 35px; /* Sedikit mengecil di HP agar muat satu baris */
    }
  }
</style>

<footer>
  <img src="images/POLTEK.png" alt="Logo Polije">
  © 2026 Healthy Breath
  <img src="https://ayosehat.kemkes.go.id/image/logo_ayosehat.png" alt="Logo Promkes" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/d/dd/Logo_Kementerian_Kesehatan_Republik_Indonesia.png'">
</footer>

</body>
</html>