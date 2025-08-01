<?php include('config/db.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Laundry</title>
</head>
<body>
    <h2>Dashboard Laundry</h2>
    <a href="index.php">Tambah Pelanggan Baru</a><br><br>
    <table border="1" cellpadding="8" style="width:100%;">
        <thead>
            <tr>
                <th>Nama</th>
                <th>No WA</th>
                <th>Layanan</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menyiapkan dan menjalankan query untuk mengambil semua data pelanggan
            // Mengurutkan berdasarkan data yang paling baru dibuat (jika ada kolom created_at)
            // Jika tidak ada, ganti 'created_at' dengan 'id'
            $stmt = $conn->prepare("SELECT * FROM pelanggan ORDER BY id DESC");
            $stmt->execute();

            // Melakukan loop untuk setiap baris hasil query
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                // Menggunakan htmlspecialchars untuk keamanan dari XSS
                echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                echo "<td>" . htmlspecialchars($row['no_wa']) . "</td>";
                echo "<td>" . htmlspecialchars($row['layanan']) . "</td>";
                echo "<td>" . ($row['harga'] ? 'Rp ' . number_format($row['harga'], 0, ',', '.') : '-') . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "<td>
                        <form action='proses/isi_harga.php' method='POST' style='display:inline; margin-bottom: 5px;'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <input type='number' name='harga' placeholder='Isi Harga' required>
                            <button type='submit'>Simpan Harga</button>
                        </form>
                        <form action='proses/tandai_selesai.php' method='POST' style='display:inline; margin-bottom: 5px;'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit'>Tandai Selesai</button>
                        </form>
                        <a target='_blank' href='https://wa.me/" . htmlspecialchars($row['no_wa']) . "?text=" . urlencode("Halo " . htmlspecialchars($row['nama']) . ", cucian Anda sudah selesai. Silakan diambil. Total: Rp " . number_format($row['harga'], 0, ',', '.')) . "' style='display:inline-block;'>Kirim WA</a>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
