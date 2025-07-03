<?php
include 'koneksi.php';

// Ambil data untuk edit jika ada parameter ?edit
if (isset($_GET['edit'])) {
  $id_edit = $_GET['edit'];
  $data_edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM jabatan WHERE id = $id_edit"));
}

// Simpan data baru
if (isset($_POST['simpan'])) {
  $nama = $_POST['nama_jabatan'];
  $ket  = $_POST['keterangan'];
  mysqli_query($koneksi, "INSERT INTO jabatan (nama_jabatan, keterangan) VALUES ('$nama', '$ket')");
  echo "<script>location.href='?page=jabatan';</script>";
}

// Update data
if (isset($_POST['update'])) {
  $id   = $_POST['id'];
  $nama = $_POST['nama_jabatan'];
  $ket  = $_POST['keterangan'];
  mysqli_query($koneksi, "UPDATE jabatan SET nama_jabatan='$nama', keterangan='$ket' WHERE id=$id");
  echo "<script>location.href='?page=jabatan';</script>";
}

// Hapus data
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM jabatan WHERE id=$id");
  echo "<script>location.href='?page=jabatan';</script>";
}
?>

<div class="custom-card p-4 mb-4">
  <h4 class="mb-4 text-dark"><i class="bi bi-person-badge me-2"></i> Form Data Jabatan</h4>

  <!-- Form Tambah / Edit -->
  <form method="post">
    <input type="hidden" name="id" value="<?= $data_edit['id'] ?? '' ?>">

    <div class="row">
      <!-- Icon -->
      <div class="col-md-3 text-center d-flex align-items-center justify-content-center">
        <i class="bi bi-briefcase-fill" style="font-size: 4rem; color: rgb(52, 73, 94);"></i>
      </div>

      <!-- Form Fields -->
      <div class="col-md-9">
        <div class="form-group mb-3">
          <label><strong>Nama Jabatan</strong></label>
          <input type="text" name="nama_jabatan" class="form-control" placeholder="jabatan"
                 value="<?= $data_edit['nama_jabatan'] ?? '' ?>" required>
        </div>

        <div class="form-group mb-3">
          <label><strong>Keterangan</strong> <small class="text-muted">(opsional)</small></label>
          <textarea name="keterangan" class="form-control" rows="2" placeholder="keterangan"><?= $data_edit['keterangan'] ?? '' ?></textarea>
        </div>

        <div class="d-flex justify-content-end">
          <?php if (isset($data_edit)) { ?>
            <button type="submit" name="update" class="btn btn-warning">
              <i class="bi bi-pencil-square"></i> Update
            </button>
          <?php } else { ?>
            <button type="submit" name="simpan" class="btn btn-success">
              <i class="bi bi-plus-circle"></i> Simpan
            </button>
          <?php } ?>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- Tabel Data -->
<div class="custom-card">
  <h5 class="mb-3"><i class="bi bi-table"></i> Daftar Jabatan</h5>
  <table class="table table-striped table-bordered">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Nama Jabatan</th>
        <th>Keterangan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $jabatan = mysqli_query($koneksi, "SELECT * FROM jabatan");
      while ($row = mysqli_fetch_assoc($jabatan)) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_jabatan']}</td>
                <td>{$row['keterangan']}</td>
                <td>
                  <a href='?page=jabatan&edit={$row['id']}' class='btn btn-sm btn-warning'>
                    <i class='bi bi-pencil'></i> Edit
                  </a>
                  <a href='?page=jabatan&hapus={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Hapus jabatan ini?')\">
                    <i class='bi bi-trash'></i> Hapus
                  </a>
                </td>
              </tr>";
        $no++;
      }
      ?>
    </tbody>
  </table>
</div>
