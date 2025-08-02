<?php
// ... (kode Anda yang lain di atas) ...
?>
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

        // --- AWAL MODIFIKASI: Format Nomor WA ke +62 ---
        $no_wa_asli = $row['no_wa'];
        // Hapus semua karakter yang bukan angka
        $no_wa_bersih = preg_replace('/[^0-9]/', '', $no_wa_asli);
        // Cek jika nomor dimulai dengan '0', ganti dengan '62'
        if (substr($no_wa_bersih, 0, 1) === '0') {
            $nomor_wa_formatted = '62' . substr($no_wa_bersih, 1);
        } else {
            // Jika sudah '62' atau format lain, biarkan saja
            $nomor_wa_formatted = $no_wa_bersih;
        }
        // --- AKHIR MODIFIKASI ---

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
                    
                    <a class='btn whatsapp' target='_blank' href='https://wa.me/" . $nomor_wa_formatted . "?text=" . urlencode("Halo " . htmlspecialchars($row['nama']) . ", cucian Anda sudah selesai. Silakan diambil. Total: Rp " . number_format($row['harga'], 0, ',', '.')) . "'>Kirim WA</a>
                </div>
              </td>";
        echo "</tr>";
    }
    ?>
</tbody>
<?php
// ... (sisa kode Anda di bawah) ...
?>
