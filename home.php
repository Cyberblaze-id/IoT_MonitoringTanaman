<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring Suhu dan Kelembaban</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Refresh hanya bagian konten data setiap 1 detik
            setInterval(function() {
                $("#konten").load("konten_dinamis.php"); // Muat ulang data dari konten_dinamis.php
            }, 1000); // Refresh setiap 1000ms (1 detik)
        });
    </script>
</head>
<body>

    <h1 class="h1">MONITORING SUHU DAN KELEMBABAN</h1>
    <p class="ket">Ini adalah website untuk memonitoring suhu, kelembaban ruangan dan kelembaban tanah.</p>

    <!-- Kontainer untuk konten dinamis -->
    <div id="konten">
        <!-- Konten ini akan di-load dari konten_dinamis.php -->
    </div>
    
    <!-- Tombol Export, Reset, dan Logout -->
    <div class="links-container">
        <a href="hapus.php">Reset Data..!</a>
        <a href="export_csv.php" class="btn export-btn">Export Data ke CSV</a>
        <a href="logout.php">Logout</a>
    </div>

</body>
</html>
