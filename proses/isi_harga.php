<?php
include('../config/db.php');

$id = $_POST['id'];
$harga = $_POST['harga'];

try {
    // Query UPDATE yang aman menggunakan prepared statement
    $sql = "UPDATE pelanggan SET harga = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$harga, $id]);

    // Redirect kembali ke dashboard
    header('Location: ../dashboard.php');
    exit();

} catch (PDOException $e) {
    die("Error memperbarui harga: " . $e->getMessage());
}
?>
