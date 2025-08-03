<?php
// TAMBAHKAN 3 BARIS INI DI PALING ATAS UNTUK MENAMPILKAN PESAN ERROR
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Mengatur zona waktu ke Asia/Makassar (WITA)
date_default_timezone_set('Asia/Makassar');
include('config/db.php'); // Pastikan path ke file koneksi database sudah benar
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Laundry</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="container">
        <h2>Kumpul2 Laundry</h2>
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
                try {
                    // Mengambil semua data pelanggan diurutkan berdasarkan tanggal terbaru
                    $stmt = $conn->prepare("SELECT * FROM pelanggan ORDER BY tanggal_masuk DESC");
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // 1. FORMAT TANGGAL
                        $tanggal_obj = new DateTime($row['tanggal_masuk'], new DateTimeZone('UTC'));
                        $tanggal_obj->setTimezone(new DateTimeZone('Asia/Makassar'));
                        $nama_hari_id = [
                            'Sunday'    => 'Minggu', 'Monday'    => 'Senin', 'Tuesday'   => 'Selasa', 
                            'Wednesday' => 'Rabu', 'Thursday'  => 'Kamis', 'Friday'    => 'Jumat', 'Saturday'  => 'Sabtu'
                        ];
                        $hari_en = $tanggal_obj->format('l');
                        $tanggal_formatted = $nama_hari_id[$hari_en] . ', ' . $tanggal_obj->format('d-m-Y H:i');

                        // 2. FORMAT NOMOR WHATSAPP
                        $no_wa_asli = $row['no_wa'];
                        $no_wa_bersih = preg_replace('/[^0-9]/', '', $no_wa_asli);
                        if (substr($no_wa_bersih, 0, 1) === '0') {
                            $nomor_wa_formatted = '62' . substr($no_wa_bersih, 1);
                        } else {
                            $nomor_wa_formatted = $no_wa_bersih; 
                        }

                        // 3. PERSIAPKAN PESAN WHATSAPP
                        $nama_pelanggan = htmlspecialchars($row['nama']);
                        $nomor_rekening_bri = "8006-0100-5655-505"; // GANTI DENGAN NOMOR REKENING ANDA
                        
                        // Link langsung ke gambar QRIS di Google Drive
                        $link_qris = "https://drive.google.com/uc?export=view&id=1pGtDLxLxluzpzIy3tHAF8YHZZqj6ru90"; // Ganti ID jika perlu

                        $pesan_wa = "Halo {$nama_pelanggan}, cucian anda sudah selesai dan siap di ambil. Total tagihan: Rp " . number_format($row['harga'] ?? 0, 0, ',', '.') . "\n\n";
                        $pesan_wa .= "Bisa bayar cash\n";
                        $pesan_wa .= "Dan bisa tf ke bank Bri nomer:\n";
                        $pesan_wa .= "{$nomor_rekening_bri}\n\n";
                        $pesan_wa .= "Bisa lewat QRIS (lihat kode di: {$link_qris} )\n";
                        $pesan_wa .= "Trimakasi atas kerjasamanya dan mohon maaf atas kekurangannya🙏";

                        // 4. TAMPILKAN DATA DALAM TABEL
                        echo "<tr>";
                        echo "<td data-label='Tanggal Masuk'>" . $tanggal_formatted . "</td>";
                        echo "<td data-label='Nama'>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td data-label='No WA'>" . htmlspecialchars($row['no_wa']) . "</td>";
                        echo "<td data-label='Layanan'>" . htmlspecialchars($row['layanan']) . "</td>";
                        
                        // --- BAGIAN YANG DIPERBAIKI ---
                        echo "<td data-label='Harga'>";
                        if (isset($row['harga']) && is_numeric($row['harga'])) {
                            echo 'Rp ' . number_format($row['harga'], 0, ',', '.');
                        } else {
                            echo '-'; // Tampilkan strip jika harga kosong atau bukan angka
                        }
                        echo "</td>";
                        // --- BATAS AKHIR PERBAIKAN ---

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
                                    <a class='btn whatsapp' target='_blank' href='https://wa.me/{$nomor_wa_formatted}?text=" . urlencode($pesan_wa) . "'>Kirim WA</a>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='7'>Error: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        setInterval(function() {
            fetch('keep_alive.php').then(response => {
                if (response.ok) {
                    console.log('Sesi tetap aktif pada ' + new Date().toLocaleTimeString());
                }
            }).catch(error => {
                console.error('Gagal menjaga sesi tetap aktif:', error);
            });
        }, 300000); // 5 menit
    </script>
</body>
</html>
