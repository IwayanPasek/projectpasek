<?php
include('../config/db.php');

$nama = $_POST['nama'];
$no_wa = $_POST['no_wa'];
$layanan = $_POST['layanan'];

$sql = "INSERT INTO pelanggan (nama, no_wa, layanan) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$nama, $no_wa, $layanan]);

header('Location: ../dashboard.php');
exit;
?>
