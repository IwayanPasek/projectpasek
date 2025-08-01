<?php
include('../config/db.php');

$id = $_POST['id'];

try {
    // Query UPDATE yang aman
    $sql = "UPDATE pelanggan SET status = 'Selesai' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    // Redirect kembali ke dashboard
    header('Location: ../dashboard.php');
    exit();

} catch (PDOException $e) {
    die("Error menandai selesai: " . $e->getMessage());
}
?>
