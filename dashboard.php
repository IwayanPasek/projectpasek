<?php include('config/db.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelanggan - Laundry</title>
</head>
<body>
    <h2>Form Tambah Pelanggan Baru</h2>
    <form action="proses/simpan_pelanggan.php" method="POST">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br>
        
        <label>No. WhatsApp:</label><br>
        <input type="text" name="no_wa" required><br><br>
        
        <label>Layanan:</label><br>
        <select name="layanan" required>
            <option value="Laundry Komplit">Laundry Komplit</option>
            <option value="Hanya Keringkan">Hanya Keringkan</option>
            <option value="Hanya Setrika">Hanya Setrika</option>
        </select><br><br>
        
        <button type="submit">Simpan</button>
    </form>
    <br>
    <a href="dashboard.php">Lihat Dashboard</a>
</body>
</html>
