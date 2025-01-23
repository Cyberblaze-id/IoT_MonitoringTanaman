<?php 
	$server = "localhost:3306";
	$username = "monitori_monitor";
	$password = "monitoringsuhu";
	$database = "monitori_dbmonitor";

	$koneksi = mysqli_connect($server,$username,$password,$database);

	if (mysqli_connect_error()) {
		echo "Database gagal terhubung...!";
	}

 ?>