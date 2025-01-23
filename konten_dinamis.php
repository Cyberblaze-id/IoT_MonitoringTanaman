<?php 
include "koneksi.php";

// Mengambil data terbaru dari database
$query_latest = mysqli_query($koneksi, "SELECT * FROM tbmonitor ORDER BY id DESC LIMIT 1");
$latest_data = mysqli_fetch_array($query_latest);

if ($latest_data): ?>
    <div class="update-info">
        Waktu update terakhir: <strong><?php echo htmlspecialchars($latest_data['waktu']); ?></strong> | 
        Tanggal: <strong><?php echo htmlspecialchars($latest_data['tanggal']); ?></strong>
    </div>
    
    <div class="container">
        <div class="kotak">
            <h2 class="h2">TEMPERATUR</h2>
            <div class="nilai">
                <?php echo htmlspecialchars($latest_data['suhu']); ?><font>°C</font>
            </div>
        </div>
        <div class="kotak">
            <h2 class="h2">HUMIDITY</h2>
            <div class="nilai">
                <?php echo htmlspecialchars($latest_data['kelembaban']); ?><font>%</font>
            </div>
        </div>
        <div class="kotak">
            <h2 class="h2">SOIL MOISTURE</h2>
            <div class="nilai">
                <?php echo htmlspecialchars($latest_data['kelembabantanah']); ?><font>%</font>
            </div>
        </div>
    </div>

    <!-- Status LED -->
    <div class="led-status">
        <?php
            $kelembabantanah = (int)$latest_data['kelembabantanah']; // Mengambil kelembaban tanah sebagai integer

            // Memeriksa kondisi untuk menyalakan LED berdasarkan kelembaban tanah
            if ($kelembabantanah > 70) {
                echo '<div class="led on">TANAH LEMBAB</div>'; // LED ON
            } else {
                echo '<div class="led off">TANAH KERING</div>'; // LED OFF
            }
        ?>
    </div>
<?php else: ?>
    <p class="ket">Data belum tersedia.</p>
<?php endif; ?>
