<?php
date_default_timezone_set('Asia/Makassar');
include('config/db.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Laundry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* ... CSS Anda tetap sama ... */
    </style>
</head>
<body>
    <h2>Dashboard Laundry</h2>
    <a href="index.php">Tambah Pelanggan Baru</a><br><br>
    
    <table cellpadding="8">
        <thead>
            <tr>
                <th>Tanggal Masuk</th>
                <th>Nama</th>
                <th>Tanggal Ambil</th> <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $conn->prepare("SELECT * FROM pelanggan ORDER BY tanggal_masuk DESC");
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // --- PROSES TANGGAL MASUK (DENGAN JAM) ---
                $tgl_masuk_obj = new DateTime($row['tanggal_masuk']);
                $tgl_masuk_obj->modify('+8 hours');
                $nama_hari_id = ['Sunday'=>'Minggu', 'Monday'=>'Senin', 'Tuesday'=>'Selasa', 'Wednesday'=>'Rabu', 'Thursday'=>'Kamis', 'Friday'=>'Jumat', 'Saturday'=>'Sabtu'];
                $hari_en_masuk = $tgl_masuk_obj->format('l');
                $tgl_masuk_formatted = $nama_hari_id[$hari_en_masuk] . ', ' . $tgl_masuk_obj->format('d-m-Y H:i');

                // --- PROSES TANGGAL AMBIL (HANYA TANGGAL) ---
                $tgl_ambil_formatted = '-'; // Default jika tanggal ambil kosong
                if (!empty($row['tanggal_ambil'])) {
                    $tgl_ambil_obj = new DateTime($row['tanggal_ambil']);
                    $hari_en_ambil = $tgl_ambil_obj->format('l');
                    $tgl_ambil_formatted = $nama_hari_id[$hari_en_ambil] . ', ' . $tgl_ambil_obj->format('d-m-Y');
                }

                echo "<tr>";
                echo "<td>" . $tgl_masuk_formatted . "</td>";
                echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                echo "<td>" . $tgl_ambil_formatted . "</td>"; // Menampilkan tanggal ambil
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "<td>
                        </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
