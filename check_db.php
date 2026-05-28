<?php
require 'db.php';
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'nama_lengkap'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN nama_lengkap VARCHAR(100) DEFAULT ''");
        echo "Column 'nama_lengkap' added. ";
    }
    
    $stmt2 = $pdo->query("SHOW COLUMNS FROM users LIKE 'usia'");
    if ($stmt2->rowCount() == 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN usia INT DEFAULT 0");
        echo "Column 'usia' added.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
