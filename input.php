<?php
include('koneksi.php');

date_default_timezone_set('Asia/Jakarta');
$waktu = date("H:i:s");
$tanggal = date("d F Y");

// Periksa apakah nilai kelembaban tanah tersedia
$suhu = $_POST['suhu'] ?? null; 
$kelembaban = $_POST['kelembaban'] ?? null; 
$kelembabantanah = $_POST['kelembabantanah'] ?? null;

if ($suhu === null || $kelembaban === null || $kelembabantanah === null) {
    echo "Data tidak lengkap. Pastikan semua parameter dikirim.";
    exit; 
}

// Menampilkan data yang diterima untuk debugging
echo "Suhu: $suhu, Kelembaban: $kelembaban, Kelembaban Tanah: $kelembabantanah<br>";

// Simpan data ke database
$kirim = mysqli_query($koneksi, "INSERT INTO tbmonitor (waktu, tanggal, suhu, kelembaban, kelembabantanah) VALUES ('$waktu', '$tanggal', '$suhu', '$kelembaban', '$kelembabantanah')");

if ($kirim) {
    echo "Data berhasil diinputkan...!";
} else {
    echo "Gagal diinputkan...! Error: " . mysqli_error($koneksi);
}
?>
