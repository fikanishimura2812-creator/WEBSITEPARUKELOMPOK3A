<?php
// ============================================
// SCRIPT LOGOUT
// File: logout.php
// Fungsi: Menghapus semua data session dan
//         mengarahkan user kembali ke login
// ============================================

// Mulai session (wajib sebelum mengakses $_SESSION)
session_start();

// Hapus semua variabel session
 $_SESSION = [];

// Jika session menggunakan cookie, hapus cookie session juga
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),          // Nama cookie session
        '',                      // Kosongkan nilainya
        time() - 42000,          // Set waktu expired ke masa lalu (hapus cookie)
        $params["path"],         // Path cookie
        $params["domain"],       // Domain cookie
        $params["secure"],       // Flag secure
        $params["httponly"]      // Flag httpOnly
    );
}

// Hancurkan session di server
session_destroy();

// Redirect ke halaman login dengan parameter status=logout
// (parameter ini bisa digunakan login.php untuk menampilkan pesan)
header('Location: login.php?status=logout');
exit;
?>