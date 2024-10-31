<?php
$conn = new mysqli('localhost', 'root', '', 'sijawaruang');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    // Cek apakah email sudah terdaftar
    $checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        $message = "Email sudah terdaftar!";
        $alertType = "danger"; // Kategori alert untuk error
    } else {
        $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $message = "Registrasi berhasil! Anda sekarang bisa login.";
            $alertType = "success"; // Kategori alert untuk sukses
        } else {
            $message = "Error: " . $conn->error;
            $alertType = "danger"; // Kategori alert untuk error
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di SijawaRuang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Background lembut */
        }
        .registration-container {
            max-width: 400px;
            margin: auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
        h1 {
            text-align: center;
            color: #b30000; /* Warna judul */
        }
        .btn-custom {
            background-color: #b30000;
            color: white;
        }
        .btn-custom:hover {
            background-color: #a70000;
        }
        .alert {
            margin-top: 20px;
        }
        .login-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h1>Selamat Datang di SijawaRuang</h1>
        
        <?php if (isset($message)): ?>
            <div class="alert alert-<?php echo $alertType; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
            </div>
            <button type="submit" class="btn btn-custom">Daftar</button>
        </form>

        <a href="login.php" class="login-link">Sudah punya akun? Login di sini</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
