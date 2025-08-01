<?php 
// Mengatur zona waktu ke Asia/Makassar (WITA)
date_default_timezone_set('Asia/Makassar');
include('config/db.php'); 
?>
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
                <th>Tanggal Masuk</th>
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
            // Mengambil data pelanggan dan mengurutkannya berdasarkan tanggal masuk terbaru
            $stmt = $conn->prepare("SELECT * FROM pelanggan ORDER BY tanggal_masuk DESC");
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Membuat objek DateTime dari string tanggal database
                $tanggal_obj = new DateTime($row['tanggal_masuk']);
                // Memformat tanggal ke format Indonesia (Hari-Bulan-Tahun Jam:Menit)
                $tanggal_formatted = $tanggal_obj->format('d-m-Y H:i');

                echo "<tr>";
                echo "<td>" . $tanggal_formatted . "</td>";
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
