<?php
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

    <table border="1" cellpadding="8">
        <tr>
            <th>Nama</th>
            <th>No WA</th>
            <th>Layanan</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM pelanggan ORDER BY created_at DESC");

        if (!$result) {
            echo "<tr><td colspan='6'>Gagal mengambil data: " . $conn->error . "</td></tr>";
        } else {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['nama']}</td>";
                echo "<td>{$row['no_wa']}</td>";
                echo "<td>{$row['layanan']}</td>";
                echo "<td>" . ($row['harga'] ? 'Rp ' . number_format($row['harga'], 0, ',', '.') : '-') . "</td>";
                echo "<td>{$row['status']}</td>";
                echo "<td>
                    <form action='proses/isi_harga.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='number' name='harga' placeholder='Harga' required>
                        <button type='submit'>Isi Harga</button>
                    </form>
                    <form action='proses/tandai_selesai.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit'>Selesai</button>
                    </form>
                    <a target='_blank' href='https://wa.me/{$row['no_wa']}?text=" . urlencode("Halo {$row['nama']}, cucian Anda sudah selesai. Silakan diambil. Total: Rp " . number_format($row['harga'], 0, ',', '.')) . "'>Kirim WA</a>
                </td>";
                echo "</tr>";
            }
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
