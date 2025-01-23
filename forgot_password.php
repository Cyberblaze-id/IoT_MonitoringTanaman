<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $koneksi = new mysqli("localhost:3306", "monitori_monitor", "monitoringsuhu", "monitori_dbmonitor");

    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    $email = $koneksi->real_escape_string($_POST['email']); // Mencegah SQL Injection

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email tidak valid!";
        $message_class = "error";
        echo "<div class='message $message_class'>$message</div>";
        exit();
    }

    // Cek apakah email ada di database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $token = bin2hex(random_bytes(16)); // Generate token
        $token_expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token valid 1 jam
        $update_sql = "UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?";
        
        $update_stmt = $koneksi->prepare($update_sql);
        $update_stmt->bind_param("sss", $token, $token_expiry, $email);
        
        if ($update_stmt->execute()) {
            // Kirim email dengan token reset password
            $message = "Link reset password telah dikirim ke email Anda!";
            $message_class = "success";

            // Menggunakan PHPMailer untuk mengirim email
            require 'vendor/autoload.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server Anda
            $mail->SMTPAuth = true;
            $mail->Username = 'blazeheart.id@gmail.com'; // Ganti dengan email pengirim
            $mail->Password = 'BlazeheartInferno136'; // Ganti dengan password email pengirim
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Pengaturan email
            $mail->setFrom('blazeheart.id@gmail.com', 'Monitoring Suhu');
            $mail->addAddress($email); // Menambahkan penerima email
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body    = 'Klik link berikut untuk reset password Anda: <br>' .
                             '<a href="https://monitoringtanaman.my.id/reset_password.php?token=' . $token . '">Reset Password</a>';

            // Mengirim email
            if (!$mail->send()) {
                $message = 'Terjadi kesalahan dalam mengirim email: ' . $mail->ErrorInfo;
                $message_class = "error";
            }
        } else {
            $message = "Terjadi kesalahan saat mengupdate token: " . $koneksi->error;
            $message_class = "error";
        }
    } else {
        $message = "Email tidak ditemukan!";
        $message_class = "error";
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
    <style>
   body {
            font-family: 'Arial', sans-serif;
            background-color: #0d0d0d;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: linear-gradient(145deg, #1a1a1a, #0f0f0f);
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5), 0 -4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .container h2 {
            margin-bottom: 20px;
            color: #ff3333;
            font-size: 24px;
            text-shadow: 0 2px 4px rgba(255, 51, 51, 0.6);
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
            padding-left: 15px;
            padding-right: 15px;
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #ff6666;
        }
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ff3333;
            border-radius: 5px;
            background-color: #121212;
            color: #fff;
            font-size: 14px;
            margin: 0;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        input[type="email"]:focus {
            border-color: #ff6666;
            box-shadow: 0 0 5px rgba(255, 102, 102, 0.6);
        }
        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(145deg, #ff3333, #ff1a1a);
            color: #fff;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        button:hover {
            background: linear-gradient(145deg, #ff6666, #ff3333);
            transform: scale(1.05);
        }
        .message {
            margin-top: 15px;
            color: #fff;
            font-size: 14px;
        }
        .message.success {
            color: #00ff00;
        }
        .message.error {
            color: #ff0000;
        }
        .message a {
            color: #ff3333;
            text-decoration: none;
            font-size: 14px;
        }
        .message a:hover {
            text-decoration: underline;
            color: #ff6666;
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            h2 {
                font-size: 20px;
            }
            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Reset Password</h2>
    <form action="reset_password.php" method="POST">
        <div class="form-group">
            <label for="email">Masukkan email Anda</label>
            <input type="email" id="email" name="email" required placeholder="Email Anda" />
        </div>
        <button type="submit">Kirim Link Reset</button>
    </form>

    <?php if (isset($message)) : ?>
        <div class="message <?php echo $message_class; ?>"><?php echo $message; ?></div>
    <?php endif; ?>
        <div class="message">
            <p><a href="login.php">Kembali ke Login</a></p>
        </div>
    </div>
</div>

</body>
</html>
