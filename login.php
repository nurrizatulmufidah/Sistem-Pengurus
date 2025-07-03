<?php
session_start();
include 'koneksi.php';

if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

if (isset($_POST['login'])) {
  $user = mysqli_real_escape_string($koneksi, $_POST['username']);
  $pass = mysqli_real_escape_string($koneksi, $_POST['password']);

  $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
  if (mysqli_num_rows($cek) > 0) {
    $_SESSION['user'] = $user;
    header("Location: index.php");
    exit();
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Sistem Pengurus Pendidikan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 0;
    }

    .container-login {
      display: flex;
      height: 100vh;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      width: 900px;
      height: 500px;
      background: #fff;
      box-shadow: 0 10px 40px rgba(0,0,0,0.15);
      border-radius: 10px;
      display: flex;
      overflow: hidden;
    }

    .login-form {
      flex: 1;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-form h3 {
      color: #007bff;
      margin-bottom: 15px;
    }

    .login-form .social {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .login-form .social a {
      color: white;
      background: #007bff;
      width: 35px;
      height: 35px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      text-decoration: none;
    }

    .login-form .form-control {
      background-color: #f3f3f3;
      border: none;
      margin-bottom: 15px;
    }

    .login-form .btn {
      background-color: #007bff;
      color: white;
      border: none;
    }

    .login-form .btn:hover {
      background-color: #0056b3;
    }

    .form-footer {
      text-align: center;
      margin-top: 15px;
    }

    .form-footer a {
      color: #333;
      font-size: 0.9rem;
    }

    .login-info {
      flex: 1;
      background: linear-gradient(to bottom right, #2980b9, #007bff);
      color: white;
      padding: 60px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: center;
    }

    .login-info h2 {
      font-weight: 700;
      margin-bottom: 10px;
    }

    .login-info p {
      font-size: 14px;
      margin-bottom: 20px;
    }

    .login-info .btn-outline-light {
      border: 1px solid white;
      border-radius: 20px;
      padding: 8px 25px;
      text-transform: uppercase;
      font-weight: 500;
    }

    @media (max-width: 768px) {
      .login-box {
        flex-direction: column;
        height: auto;
        width: 95%;
      }

      .login-info {
        padding: 40px 20px;
      }
    }
  </style>
</head>
<body>
<div class="container-login">
  <div class="login-box">
    <div class="login-form">
      <h3>Masuk ke Sistem Pengurus Pendidikan</h3>
      <div class="social">
        <a href="#"><i class="bi bi-facebook"></i></a>
        <a href="#"><i class="bi bi-twitter"></i></a>
        <a href="#"><i class="bi bi-google"></i></a>
      </div>
      <small class="mb-3">Atau gunakan akun Anda</small>

      <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

      <form method="post">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <div class="form-footer">
          <a href="#">Lupa password?</a>
        </div>
        <button type="submit" name="login" class="btn btn-primary btn-block mt-3">MASUK</button>
      </form>
    </div>

    <div class="login-info">
      <h2>Selamat Datang!</h2>
      <p>Masukkan data diri Anda dan mulai kelola data pengurus pendidikan dengan mudah.</p>
      <a href="register.php" class="btn btn-outline-light">Login Sekarang</a>
    </div>
  </div>
</div>
</body>
</html>
