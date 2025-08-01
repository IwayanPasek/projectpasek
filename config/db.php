<?php
// Menggunakan informasi koneksi ke Azure SQL Database
$serverName = "tcp:wayan.database.windows.net,1433";
$database = "laundrydb";
$username = "wayan";
$password = "Jentung18";

try {
    // Membuat koneksi PDO baru
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    // Mengatur mode error untuk menampilkan exception jika terjadi kesalahan
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // HAPUS BARIS INI DARI FILE ANDA: echo "Connected successfully!";

} catch (PDOException $e) {
    // Menghentikan skrip dan menampilkan pesan error jika koneksi gagal
    die("Koneksi gagal: " . $e->getMessage());
}
?>
