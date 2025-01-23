<?php
// Koneksi ke database
$koneksi = new mysqli("localhost:3306", "monitori_monitor", "monitoringsuhu", "monitori_dbmonitor");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk mendapatkan data
$sql = "SELECT * FROM tbmonitor ORDER BY id ASC";
$result = $koneksi->query($sql);

// Buat file CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');
$output = fopen('php://output', 'w');

// Tulis header kolom ke file CSV
fputcsv($output, array('id', 'waktu', 'tanggal', 'suhu', 'kelembaban', 'kelembabantanah'), ';');

// Tulis data ke file CSV
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row, ';');  // Gunakan titik koma sebagai pemisah
    }
} else {
    echo "Tidak ada data dalam database.";
}
fclose($output);
exit();
?>
