<?php
session_start();
include 'koneksi.php'; // masukan konekasi DB
// ambil variable ID dari URL
//Proses query hapus data
$del=mysqli_query($koneksi,"TRUNCATE TABLE tbmonitor");
$sql =mysqli_query($koneksi,"INSERT INTO tbmonitor (id, waktu, tanggal, suhu, kelembaban, kelembabantanah)
VALUES ('0', '00:00:00', '00/00/0000', '0', '0', '0')");

header("location:index.php"); // kembali ke tampil data
?>