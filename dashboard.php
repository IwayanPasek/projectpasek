<?php
// Mengatur zona waktu ke Asia/Makassar (WITA)
date_default_timezone_set('Asia/Makassar');
include('config/db.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Laundry</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard Laundry</h2>
        <a href="index.php" class="tambah-pelanggan-btn">Tambah Pelanggan Baru</a>
        
        <table class="laundry-table">
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
                $stmt = $conn->prepare("SELECT * FROM pelanggan ORDER BY tanggal_masuk DESC");
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Proses Tanggal Masuk
                    $tanggal_obj = new DateTime($row['tanggal_masuk'], new DateTimeZone('UTC'));
                    $tanggal_obj->setTimezone(new DateTimeZone('Asia/Makassar'));
                    $nama_hari_id = ['Sunday'=>'Minggu', 'Monday'=>'Senin', 'Tuesday'=>'Selasa', 'Wednesday'=>'Rabu', 'Thursday'=>'Kamis', 'Friday'=>'Jumat', 'Saturday'=>'Sabtu'];
                    $hari_en = $tanggal_obj->format('l');
                    $tanggal_formatted = $nama_hari_id[$hari_en] . ', ' . $tanggal_obj->format('d-m-Y H:i');

                    echo "<tr>";
                    echo "<td data-label='Tanggal Masuk'>" . $tanggal_formatted . "</td>";
                    echo "<td data-label='Nama'>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td data-label='No WA'>" . htmlspecialchars($row['no_wa']) . "</td>";
                    echo "<td data-label='Layanan'>" . htmlspecialchars($row['layanan']) . "</td>";
                    echo "<td data-label='Harga'>" . ($row['harga'] ? 'Rp ' . number_format($row['harga'], 0, ',', '.') : '-') . "</td>";
                    echo "<td data-label='Status'>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td data-label='Aksi'>
                            <div class='aksi-container'>
                                <form action='proses/isi_harga.php' method='POST' style='margin:0;'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <input type='number' name='harga' placeholder='Isi Harga' required>
                                    <button type='submit' class='btn simpan'>Simpan Harga</button>
                                </form>
                                <form action='proses/tandai_selesai.php' method='POST' style='margin:0;'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit' class='btn selesai'>Tandai Selesai</button>
                                </form>
                                <a class='btn whatsapp' target='_blank' href='https://wa.me/" . htmlspecialchars($row['no_wa']) . "?text=" . urlencode("Halo " . htmlspecialchars($row['nama']) . ", cucian Anda sudah selesai. Silakan diambil. Total: Rp " . number_format($row['harga'], 0, ',', '.')) . "'>Kirim WA</a>
                            </div>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
