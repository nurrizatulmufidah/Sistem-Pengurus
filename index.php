<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Sistem Pendataan Pengurus Pendidikan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .wrapper {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }
    .content {
      flex: 1;
      display: flex;
    }
    .sidebar {
      width: 230px;
      background-color: rgb(52, 73, 94);
      color: white;
      padding-top: 30px;
      position: fixed;
      height: 100vh;
      overflow-y: auto;
    }
    .sidebar h4 {
      font-size: 22px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 30px;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
      transition: all 0.3s;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: rgba(255,255,255,0.1);
    }
    .sidebar a i {
      margin-right: 8px;
    }
    .main-content {
      margin-left: 230px;
      padding: 30px;
      flex: 1;
    }
    .custom-card {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .custom-card:hover {
      transform: translateY(-2px);
    }
    footer {
      background-color: #2e3b55;
      color: white;
      padding: 15px 30px;
      text-align: center;
    }
    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
      }
      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>
<div class="wrapper">
  <div class="content">
    <!-- Sidebar -->
    <div class="sidebar">
      <h4><i class="bi bi-people-fill"></i> Pengurus</h4>
      <a href="?page=home" class="<?= $page == 'home' ? 'active' : '' ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
      <a href="?page=unit" class="<?= $page == 'unit' ? 'active' : '' ?>"><i class="bi bi-building"></i> Data Unit</a>
      <a href="?page=jabatan" class="<?= $page == 'jabatan' ? 'active' : '' ?>"><i class="bi bi-person-badge-fill"></i> Data Jabatan</a>
      <a href="?page=pengurus" class="<?= $page == 'pengurus' ? 'active' : '' ?>"><i class="bi bi-person-lines-fill"></i> Data Pengurus</a>
      <a href="?page=divisi" class="<?= $page == 'divisi' ? 'active' : '' ?>"><i class="bi bi-diagram-3"></i> Data Divisi</a>
      <a href="logout.php" onclick="return confirm('Yakin ingin logout?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main -->
    <div class="main-content">
      <nav class="navbar navbar-expand-lg mb-4 shadow-sm"
     style="background-color: rgb(52, 73, 94); padding: 1rem 2rem;">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    
    <!-- Logo & Title -->
    <div class="d-flex align-items-center">
      <i class="bi bi-mortarboard-fill text-white" style="font-size: 1.8rem; margin-right: 10px;"></i>
      <span class="text-white h5 mb-0">Sistem Pengurus Pendidikan</span>
    </div>

    <!-- User Panel -->
    <div class="d-flex align-items-center">
      <i class="bi bi-person-circle text-white mr-2" style="font-size: 1.4rem;"></i>
      <span class="text-white small">👤 <?= $_SESSION['user']; ?></span>
    </div>

  </div>
</nav>


      <?php
        if ($page == 'home') {
        $total_unit     = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM unit"));
        $total_jabatan  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jabatan"));
        $total_pengurus = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengurus"));
        $total_divisi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM divisi"));
        

        echo '
        <div class="mb-4 p-4 bg-white rounded shadow-sm">
          <h3 class="mb-2 text-dark"><i class="bi bi-house-door-fill"></i> Dashboard</h3>
          <p class="text-muted">Selamat datang, <strong>' . $_SESSION['user'] . '</strong>. Akses cepat ke data sistem pengurus tersedia di bawah ini.</p>
        </div>

        <div class="row">

          

          <!-- Total Unit -->
          <div class="col-md-3 mb-4">
            <div class="card text-white bg-dark h-100 shadow-sm border-0">
              <div class="card-body d-flex align-items-center">
                <i class="bi bi-diagram-3-fill mr-3" style="font-size: 2rem;"></i>
                <div>
                  <h6 class="mb-0">Total Unit</h6>
                  <h3 class="mb-0"><?= $total_unit ?></h3>
                </div>
              </div>
            </div>
          </div>

          <!-- Total Jabatan -->
          <div class="col-md-3 mb-4">
            <div class="card text-white" style="background-color: #6c5ce7;">
              <div class="card-body d-flex align-items-center">
                <i class="bi bi-award-fill mr-3" style="font-size: 2rem;"></i>
                <div>
                  <h6 class="mb-0">Total Jabatan</h6>
                  <h3 class="mb-0"><?= $total_jabatan ?></h3>
                </div>
              </div>
            </div>
          </div>

          <!-- Total Pengurus -->
          <div class="col-md-3 mb-4">
            <div class="card text-white" style="background-color: #00b894;">
              <div class="card-body d-flex align-items-center">
                <i class="bi bi-people-fill mr-3" style="font-size: 2rem;"></i>
                <div>
                  <h6 class="mb-0">Total Pengurus</h6>
                  <h3 class="mb-0"><?= $total_pengurus ?></h3>
                </div>
              </div>
            </div>
          </div>

          <!-- Total Divisi -->
          <div class="col-md-3 mb-4">
            <div class="card text-white" style="background-color: #fd7e14;">
              <div class="card-body d-flex align-items-center">
                <i class="bi bi-diagram-2-fill mr-3" style="font-size: 2rem;"></i>
                <div>
                  <h6 class="mb-0">Total Divisi</h6>
                  <h3 class="mb-0"><?= $total_divisi ?></h3>
                </div>
              </div>
            </div>
          </div>
        </div>';

        
        } elseif ($page == 'unit') {
          include 'unit.php';
        } elseif ($page == 'jabatan') {
          include 'jabatan.php';
        } elseif ($page == 'pengurus') {
          include 'pengurus.php';
        } elseif ($page == 'divisi') {
          include 'divisi.php';
        } else {
          echo "<div class='alert alert-warning'>Halaman tidak ditemukan!</div>";
        }
      ?>
    </div>
  </div>
</div>
</body>
</html>
