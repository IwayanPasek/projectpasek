<?php
include('../config/db.php');
$nama = $_POST['nama'];
$no_wa = $_POST['no_wa'];
$layanan = $_POST['layanan'];
$conn->query("INSERT INTO pelanggan (nama, no_wa, layanan) VALUES ('$nama', '$no_wa', '$layanan')");
header('Location: ../dashboard.php');
?>