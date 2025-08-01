<?php
include('../config/db.php');
$id = $_POST['id'];
$harga = $_POST['harga'];
$conn->query("UPDATE pelanggan SET harga=$harga WHERE id=$id");
header('Location: ../dashboard.php');
?>