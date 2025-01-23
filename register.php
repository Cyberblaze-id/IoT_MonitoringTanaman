<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $koneksi = new mysqli("localhost:3306", "monitori_monitor", "monitoringsuhu", "monitori_dbmonitor");

    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    $username = $koneksi->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $koneksi->real_escape_string($_POST['email']);

    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    if ($koneksi->query($sql) === TRUE) {
        $message = "Registrasi berhasil! Silakan login.";
    } else {
        $message = "Error: " . $koneksi->error;
    }
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
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
        input[type="text"], input[type="password"], input[type="email"] {
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
        input[type="text"]:focus, input[type="password"]:focus, input[type="email"]:focus {
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

        .success-message {
            color: #66ff66;
            font-size: 16px;
            margin-top: 15px;
            background-color: rgba(0, 255, 0, 0.1);
            padding: 10px;
            border-radius: 5px;
        }

        .error-message {
            color: #ff3333;
            font-size: 16px;
            margin-top: 15px;
            background-color: rgba(255, 0, 0, 0.1);
            padding: 10px;
            border-radius: 5px;
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
        <h2>Daftar Akun</h2>
        <form method="post" action="register.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button type="submit">Daftar</button>
        </form>
        <div class="message">
            <p>Sudah punya akun? <a href="login.php">Login</a></p>
        </div>
        <?php if (isset($message)) { ?>
            <div class="success-message">
                <?php echo $message; ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>
