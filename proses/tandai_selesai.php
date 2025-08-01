<?php
include('../config/db.php');

$id = $_POST['id'];

try {
    $sql = "UPDATE pelanggan SET status = 'Selesai' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    header('Location: ../dashboard.php');
} catch (PDOException $e) {
    die("Error menandai selesai: " . $e->getMessage());
}
?>
