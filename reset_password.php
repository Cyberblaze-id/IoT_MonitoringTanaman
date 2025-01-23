<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $koneksi = new mysqli("localhost:3306", "monitori_monitor", "monitoringsuhu", "monitori_dbmonitor");

    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    $token = $koneksi->real_escape_string($_GET['token']);
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Cek token di database
    $sql = "SELECT * FROM users WHERE reset_token = '$token'";
    $result = $koneksi->query($sql);

    if ($result->num_rows == 1) {
        // Token valid, update password
        $update_sql = "UPDATE users SET password = '$new_password', reset_token = NULL WHERE reset_token = '$token'";

        if ($koneksi->query($update_sql)) {
            echo "Password berhasil diubah!";
        } else {
            echo "Terjadi kesalahan saat memperbarui password: " . $koneksi->error;
        }
    } else {
        echo "Token tidak valid!";
    }

    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <form method="post" action="reset_password.php?token=<?php echo $_GET['token']; ?>">
        <label for="new_password">Password Baru:</label>
        <input type="password" name="new_password" id="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
