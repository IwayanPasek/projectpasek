<?php
$serverName = "tcp:wayan.database.windows.net,1433";
$database = "laundrydb";
$username = "wayan";
$password = "Jentung18";

try {
    // Koneksi
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2>Koneksi Berhasil!</h2>";

    // Query semua data dari tabel pelanggan
    $sql = "SELECT * FROM pelanggan ORDER BY created_at DESC";
    $stmt = $conn->query($sql);

    // Cek apakah ada data
    if ($stmt->rowCount() > 0) {
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Nama</th><th>No WA</th><th>Layanan</th><th>Harga</th><th>Status</th><th>Created At</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['no_wa']}</td>";
            echo "<td>{$row['layanan']}</td>";
            echo "<td>" . ($row['harga'] ? 'Rp ' . number_format($row['harga'], 0, ',', '.') : '-') . "</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Tidak ada data dalam tabel pelanggan.";
    }

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
