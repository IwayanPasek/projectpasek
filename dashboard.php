<?php
// Mengatur zona waktu ke Asia/Makassar (WITA)
date_default_timezone_set('Asia/Makassar');
include('config/db.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Laundry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* CSS Anda tetap sama, tidak perlu diubah */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 15px;
            background-color: #f4f4f9;
            color: #333;
        }
        h2 {
            color: #4a4a4a;
            text-align: center;
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a[href="index.php"] {
            display: block;
            width: fit-content;
            margin: 0 auto 25px auto;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background-color: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
            font-size: 14px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        td form {
            display: flex;
            flex-direction: column;
            margin-bottom: 8px;
        }
        input[type="number"] {
            padding: 8px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        button, a[target="_blank"] {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            text-align: center;
            display: inline-block;
            width: 100%;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #17a2b8;
            color: white;
        }
        form[action='proses/tandai_selesai.php'] button {
            background-color: #ffc107;
            color: #212529;
        }
        a[target="_blank"] {
            background-color: #28a745;
            color: white;
            margin-top: 5px;
        }
        @media screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                border: 1px solid #ccc;
                margin-bottom: 15px;
                border-radius: 5px;
                overflow: hidden;
            }
            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 45%;
                min-height: 30px;
                text-align: right;
            }
            td:before {
                position: absolute;
                left: 10px;
                width: 40%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
                color: #555;
            }
            td:nth-of-type(1):before { content: "Tanggal"; }
            td:nth-of-type(2):before { content: "Nama"; }
            td:nth-of-type(3):before { content: "No WA"; }
            td:nth-of-type(4):before { content: "Layanan"; }
            td:nth-of-type(5):before { content: "Harga"; }
            td:nth-of-type(6):before { content: "Status"; }
            td:nth-of-type(7):before { content: "Aksi"; }
            td:last-child {
                border-bottom: 0;
            }
        }
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

                // -- PERUBAHAN DIMULAI DI SINI --
                // Array untuk menerjemahkan nama hari ke bahasa Indonesia
                $nama_hari_id = array(
                    'Sunday'    => 'Minggu',
                    'Monday'    => 'Senin',
                    'Tuesday'   => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday'  => 'Kamis',
                    'Friday'    => 'Jumat',
                    'Saturday'  => 'Sabtu'
                );

                // Mengambil nama hari dalam bahasa Inggris (misal: "Saturday")
                $hari_en = $tanggal_obj->format('l');

                // Menerjemahkan dan menggabungkan dengan format tanggal yang sudah ada
                // Contoh hasil: "Sabtu, 02-08-2025 18:20"
                $tanggal_formatted = $nama_hari_id[$hari_en] . ', ' . $tanggal_obj->format('d-m-Y H:i');
                // -- PERUBAHAN SELESAI --

                echo "<tr>";
                echo "<td>" . $tanggal_formatted . "</td>";
                echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                echo "<td>" . htmlspecialchars($row['no_wa']) . "</td>";
                echo "<td>" . htmlspecialchars($row['layanan']) . "</td>";
                echo "<td>" . ($row['harga'] ? 'Rp ' . number_format($row['harga'], 0, ',', '.') : '-') . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "<td>
                        <form action='proses/isi_harga.php' method='POST'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <input type='number' name='harga' placeholder='Isi Harga' required>
                            <button type='submit'>Simpan Harga</button>
                        </form>
                        <form action='proses/tandai_selesai.php' method='POST'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit'>Tandai Selesai</button>
                        </form>
                        <a target='_blank' href='https://wa.me/" . htmlspecialchars($row['no_wa']) . "?text=" . urlencode("Halo " . htmlspecialchars($row['nama']) . ", cucian Anda sudah selesai. Silakan diambil. Total: Rp " . number_format($row['harga'], 0, ',', '.')) . "'>Kirim WA</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
