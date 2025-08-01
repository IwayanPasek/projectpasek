<?php
// Informasi koneksi ke Azure SQL Database
$serverName = "tcp:wayan.database.windows.net,1433";
$database = "laundrydb";
$username = "wayan";
$password = "Jentung18";

try {
    // Membuat koneksi PDO
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    // Mengatur mode error untuk menampilkan exception jika terjadi kesalahan
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Menghentikan skrip dan menampilkan pesan error jika koneksi gagal
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>
