<?php
include('../config/db.php');

// Mengambil ID dari form
$id = $_POST['id'];

try {
    // Menyiapkan query UPDATE dengan placeholder
    $sql = "UPDATE pelanggan SET status = 'Selesai' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Menjalankan query dengan ID yang sesuai
    $stmt->execute([$id]);

    // Mengalihkan kembali ke dashboard
    header('Location: ../dashboard.php');
} catch (PDOException $e) {
    die("Error menandai selesai: " . $e->getMessage());
}
?>
