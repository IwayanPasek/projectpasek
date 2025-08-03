<?php
// Informasi koneksi ke Azure SQL Database
$serverName = "tcp:wayan.database.windows.net,1433";
$database = "laundrydb";
$username = "wayan";
$password = "Jentung18";

// --- Penambahan untuk Retry Logic ---
$max_attempts = 3; // Jumlah maksimal percobaan koneksi
$retry_delay = 5;  // Waktu tunggu dalam detik sebelum mencoba lagi
$conn = null;      // Inisialisasi variabel koneksi
// ------------------------------------

for ($attempt = 1; $attempt <= $max_attempts; $attempt++) {
    try {
        // Membuat koneksi PDO dengan LoginTimeout
        $conn = new PDO("sqlsrv:server=$serverName;Database=$database;LoginTimeout=30", $username, $password);
        
        // Mengatur mode error untuk menampilkan exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Jika koneksi berhasil, hentikan loop
        break; 

    } catch (PDOException $e) {
        // Jika ini bukan percobaan terakhir, tunggu sebelum mencoba lagi
        if ($attempt < $max_attempts) {
            sleep($retry_delay);
        } else {
            // Jika semua percobaan gagal, hentikan skrip dan tampilkan pesan error
            die("Koneksi ke database gagal setelah $max_attempts percobaan: " . $e->getMessage());
        }
    }
}

// Jika Anda ingin menampilkan pesan sukses setelah koneksi berhasil
// echo "Koneksi berhasil dibuat!";

?>
