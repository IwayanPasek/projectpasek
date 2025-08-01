<?php
// Menghubungkan ke database
include('config/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelanggan - Aplikasi Laundry</title>
</head>
<body>
    <h2>Formulir Tambah Pelanggan Baru</h2>
    
    <form action="proses/simpan_pelanggan.php" method="POST">
        <label>Nama Pelanggan:</label><br>
        <input type="text" name="nama" required><br><br>
        
        <label>Nomor WhatsApp:</label><br>
        <input type="text" name="no_wa" required><br><br>
        
        <label>Pilih Layanan:</label><br>
        <select name="layanan" required>
            <option value="Laundry Komplit">Laundry Komplit</option>
            <option value="Hanya Keringkan">Hanya Keringkan</option>
            <option value="Hanya Setrika">Hanya Setrika</option>
        </select><br><br>
        
        <button type="submit">Simpan Pelanggan</button>
    </form>

    <br>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
