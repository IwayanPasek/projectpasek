<?php
include('../config/db.php');
$id = $_POST['id'];
$conn->query("UPDATE pelanggan SET status='Selesai' WHERE id=$id");
header('Location: ../dashboard.php');
?>