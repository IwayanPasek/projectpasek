<?php
include('../config/db.php');

// Ambil data dari form
$nama = $_POST['nama'];
$no_wa = $_POST['no_wa'];
$layanan = $_POST['layanan'];

// Simpan ke database
try {
    $sql = "INSERT INTO pelanggan (nama, no_wa, layanan, status) VALUES (?, ?, ?, 'proses')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nama, $no_wa, $layanan]);

    // Redirect ke dashboard setelah sukses
    header("Location: ../dashboard.php");
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
