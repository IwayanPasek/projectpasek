<?php
// Menyertakan file koneksi database
include('config/db.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelanggan - Aplikasi Laundry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Pengaturan dasar untuk seluruh halaman */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
        }

        /* Styling untuk judul */
        h2 {
            color: #4a4a4a;
            text-align: center;
            margin-bottom: 25px;
        }

        /* Container untuk form agar lebih terpusat dan rapi */
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Styling untuk label */
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block; /* Agar label berada di baris sendiri */
        }

        /* Styling untuk input dan select agar mudah digunakan di HP */
        input[type="text"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px; /* Jarak antar input */
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Penting untuk kalkulasi width */
            font-size: 16px; /* Ukuran font lebih besar agar mudah dibaca */
        }

        /* Styling untuk tombol submit */
        button[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Styling untuk link kembali ke Dashboard */
        a[href="dashboard.php"] {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Tambah Pelanggan Kumpul2 Laundry</h2>
    
    <form action="proses/simpan_pelanggan.php" method="POST">
        <label>Nama Pelanggan:</label>
        <input type="text" name="nama" required>
        
        <label>Nomor WhatsApp:</label>
        <input type="text" name="no_wa" placeholder="Contoh: 628123456789" required>
        
        <label>Pilih Layanan:</label>
        <select name="layanan" required>
            <option value="Laundry Komplit">Laundry Komplit</option>
            <option value="Hanya Keringkan">Hanya Keringkan</option>
            <option value="Hanya Setrika">Hanya Setrika</option>
        </select>
        
        <button type="submit">Simpan Pelanggan</button>
    </form>

    <br>
    <a href="dashboard.php">Lihat Dashboard</a>
</body>
</html>
