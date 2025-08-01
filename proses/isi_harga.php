<?php
include('../config/db.php');

// Mengambil data dari form
$id = $_POST['id'];
$harga = $_POST['harga'];

try {
    // Menyiapkan query UPDATE dengan placeholder
    $sql = "UPDATE pelanggan SET harga = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Menjalankan query dengan data yang sesuai
    $stmt->execute([$harga, $id]);

    // Mengalihkan kembali ke dashboard
    header('Location: ../dashboard.php');
} catch (PDOException $e) {
    die("Error memperbarui harga: " . $e->getMessage());
}
?>
