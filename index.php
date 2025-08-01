<!DOCTYPE html>
<html>
<head>
    <title>Input Pelanggan</title>
</head>
<body>
    <h2>Tambah Pelanggan Baru</h2>
    <form action="proses/tambah_pelanggan.php" method="POST">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br>
        <label>No WA:</label><br>
        <input type="text" name="no_wa" required><br>
        <label>Layanan:</label><br>
        <input type="text" name="layanan" required><br><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
