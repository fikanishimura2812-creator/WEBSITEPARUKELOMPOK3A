<?php
// ============================================
// KONFIGURASI DATABASE MENGGUNAKAN PDO
// File: db.php
// ============================================

// Pengaturan koneksi database
 $DB_HOST = 'localhost';
 $DB_NAME = 'sistem_auth';
 $DB_USER = 'root';      // Sesuaikan dengan user MySQL kamu
 $DB_PASS = '';           // Sesuaikan dengan password MySQL kamu

// Mencoba koneksi ke database menggunakan PDO
try {
    // Data Source Name (DSN) untuk MySQL
    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";

    // Opsi PDO: aktifkan error mode exception dan emulasi prepared statement dimatikan untuk keamanan
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // Tampilkan error sebagai exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // Fetch default sebagai array asosiatif
        PDO::ATTR_EMULATE_PREPARES   => false,                    // Nonaktifkan emulasi (keamanan SQL injection)
    ];

    // Membuat instance PDO
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);

} catch (PDOException $e) {
    // Jika koneksi gagal, hentikan proses dan tampilkan pesan error
    die("Koneksi database gagal: " . $e->getMessage());
}
?>