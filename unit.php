<div class="custom-card p-4">
  <h4 class="mb-4"><i class="bi bi-building me-2"></i> Data Unit</h4>

  <?php
  if (isset($_GET['edit_unit']) && is_numeric($_GET['edit_unit'])) {
    $id_edit = (int)$_GET['edit_unit'];
    $data_edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM unit WHERE id = $id_edit"));
  }
  ?>

  <!-- Form Tambah / Edit Unit -->
  <div class="card shadow-sm border rounded">
    <div class="card-body">
      <form method="post">
        <input type="hidden" name="id" value="<?= $data_edit['id'] ?? '' ?>">
        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="fw-bold">Kode Unit</label>
            <input type="text" name="kode_unit" class="form-control" placeholder="U-01" required
              value="<?= $data_edit['kode_unit'] ?? '' ?>">
          </div>
          <div class="col-md-4 mb-3">
            <label class="fw-bold">Nama Unit</label>
            <input type="text" name="nama_unit" class="form-control" placeholder="Pendidikan" required
              value="<?= $data_edit['nama_unit'] ?? '' ?>">
          </div>
          <div class="col-md-4 mb-3">
            <label class="fw-bold">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Mengelola bidang pendidikan"
              value="<?= $data_edit['keterangan'] ?? '' ?>">
          </div>
        </div>
        <div class="text-end">
          <button type="submit" name="<?= isset($data_edit) ? 'update_unit' : 'simpan_unit' ?>" class="btn btn-<?= isset($data_edit) ? 'warning' : 'primary' ?>">
            <?= isset($data_edit) ? '<i class="bi bi-pencil-square"></i> Update' : '<i class="bi bi-plus-circle"></i> Simpan' ?>
          </button>
        </div>
      </form>
    </div>
  </div>

  <?php
  // Simpan
  if (isset($_POST['simpan_unit'])) {
    $kode = $_POST['kode_unit'];
    $nama = $_POST['nama_unit'];
    $ket = $_POST['keterangan'];
    mysqli_query($koneksi, "INSERT INTO unit (kode_unit, nama_unit, keterangan) VALUES ('$kode', '$nama', '$ket')");
    echo "<script>location.href='?page=unit';</script>";
  }

  // Update
  elseif (isset($_POST['update_unit'])) {
    $id = (int)$_POST['id'];
    $kode = $_POST['kode_unit'];
    $nama = $_POST['nama_unit'];
    $ket = $_POST['keterangan'];
    mysqli_query($koneksi, "UPDATE unit SET kode_unit='$kode', nama_unit='$nama', keterangan='$ket' WHERE id=$id");
    echo "<script>location.href='?page=unit';</script>";
  }

  // Hapus
  elseif (isset($_GET['hapus_unit']) && is_numeric($_GET['hapus_unit'])) {
    $id_hapus = (int)$_GET['hapus_unit'];
    mysqli_query($koneksi, "DELETE FROM unit WHERE id=$id_hapus");
    echo "<script>location.href='?page=unit';</script>";
  }
  ?>

  <!-- Tabel -->
  <div class="table-responsive mt-4">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Kode Unit</th>
          <th>Nama Unit</th>
          <th>Keterangan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $data = mysqli_query($koneksi, "SELECT * FROM unit");
        while ($d = mysqli_fetch_assoc($data)) {
          echo "<tr>
                  <td>{$no}</td>
                  <td>{$d['kode_unit']}</td>
                  <td>{$d['nama_unit']}</td>
                  <td>{$d['keterangan']}</td>
                  <td>
                    <a href='?page=unit&edit_unit={$d['id']}' class='btn btn-warning btn-sm'>
                      <i class='bi bi-pencil'></i>
                    </a>
                    <a href='?page=unit&hapus_unit={$d['id']}' onclick=\"return confirm('Hapus data ini?')\" class='btn btn-danger btn-sm'>
                      <i class='bi bi-trash'></i>
                    </a>
                  </td>
                </tr>";
          $no++;
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
