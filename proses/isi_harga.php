<?php
include('../config/db.php');

$id = $_POST['id'];
$harga = $_POST['harga'];

try {
    $sql = "UPDATE pelanggan SET harga = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$harga, $id]);

    header('Location: ../dashboard.php');
} catch (PDOException $e) {
    die("Error memperbarui harga: " . $e->getMessage());
}
?>
