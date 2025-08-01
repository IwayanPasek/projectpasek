<?php
include('../config/db.php');

// Mengambil data dari form
$nama = $_POST['nama'];
$no_wa = $_POST['no_wa'];
$layanan = $_POST['layanan'];

try {
    // Menyiapkan query INSERT dengan placeholder (?) untuk keamanan
    $sql = "INSERT INTO pelanggan (nama, no_wa, layanan) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Menjalankan query dengan data yang diikat ke placeholder
    $stmt->execute([$nama, $no_wa, $layanan]);

    // Mengalihkan kembali ke dashboard setelah berhasil
    header('Location: ../dashboard.php');
} catch (PDOException $e) {
    // Menampilkan pesan error jika query gagal
    die("Error menyimpan data: " . $e->getMessage());
}
?>
