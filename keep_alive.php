<?php
// Memulai atau melanjutkan sesi yang sudah ada.
// Tindakan ini sudah cukup untuk memperbarui 'timestamp' sesi di server,
// sehingga mencegahnya dari kedaluwarsa (idle).
session_start();

// Pesan ini hanya untuk konfirmasi dan bisa dilihat di tab Network browser.
echo "Sesi tetap aktif.";
?>
