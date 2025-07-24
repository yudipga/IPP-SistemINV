<?php
session_start();
include 'koneksi.php'; // Ganti jika nama file koneksi beda

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Ganti jika tidak pakai md5 di database

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit;
    } else {
        $error = "Login gagal! Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Inventory Inti Paket Prima</title>
    <link rel="icon" href="img/logo ipp.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('img/indomaret-banner1.jpg') no-repeat center center fixed;
            background-size: cover;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .login-box {
            width: 380px;
            padding: 35px 30px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); /* ✅ SHADOW ditambahkan */
        }

        .logo-login {
            width: 70px;
        }

        .brand-text {
            font-size: 12px;
            font-weight: bold;
            color: #444;
            margin-top: 5px;
        }

        .login-title {
            font-weight: bold;
            font-size: 20px;
            margin-top: 8px;
            margin-bottom: 20px;
            color: #0a1f44;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            border-radius: 8px;
            background-color: #0a1f44;
            border: none;
            font-weight: bold;
        }

        .eye-icon {
            cursor: pointer;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <form method="POST" class="login-box">
        <div class="text-center mb-3">
            <img src="img/logo ipp.png" alt="Logo Indopaket" class="logo-login">
             <div class="brand-text">PT. INTI PAKET PRIMA</div>
            <div class="login-title">SILAKAN LOGIN</div>
        </div>

        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <div class="mb-3">
            <label for="username" class="form-label">Email / Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan email/username" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="position-relative">
                <input type="password" name="password" id="password" class="form-control pe-5" placeholder="Masukkan password" required>
                <span class="position-absolute top-50 end-0 translate-middle-y pe-3 eye-icon" onclick="togglePassword()">👁️</span>
            </div>
        </div>

        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
    </form>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const icon = event.target;

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.textContent = "🙈";
        } else {
            passwordInput.type = "password";
            icon.textContent = "👁️";
        }
    }
    </script>

</body>
</html>
