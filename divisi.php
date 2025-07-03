<div class="custom-card p-4">
  <h4 class="mb-4"><i class="bi bi-diagram-3"></i> Data Divisi</h4>

  <?php
  if (isset($_GET['edit_divisi']) && is_numeric($_GET['edit_divisi'])) {
    $id = (int)$_GET['edit_divisi'];
    $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM divisi WHERE id = $id"));
  }
  ?>

  <!-- Form -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
      <form method="post">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label><strong>Nama Divisi</strong></label>
            <input type="text" name="nama_divisi" class="form-control" placeholder="divisi" required value="<?= $edit['nama_divisi'] ?? '' ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label><strong>Keterangan</strong></label>
            <input type="text" name="keterangan" class="form-control" placeholder="Opsional" value="<?= $edit['keterangan'] ?? '' ?>">
          </div>
        </div>
        <div class="text-end">
          <button type="submit" name="<?= isset($edit) ? 'update_divisi' : 'simpan_divisi' ?>" class="btn btn-<?= isset($edit) ? 'warning' : 'primary' ?>">
            <?= isset($edit) ? '<i class="bi bi-pencil-square"></i> Update' : '<i class="bi bi-plus-circle"></i> Simpan' ?>
          </button>
        </div>
      </form>
    </div>
  </div>

  <?php
  // Simpan
  if (isset($_POST['simpan_divisi'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_divisi']);
    $ket = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    mysqli_query($koneksi, "INSERT INTO divisi (nama_divisi, keterangan) VALUES ('$nama', '$ket')");
    echo "<script>location.href='?page=divisi';</script>";
  }

  // Update
  elseif (isset($_POST['update_divisi'])) {
    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_divisi']);
    $ket = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    mysqli_query($koneksi, "UPDATE divisi SET nama_divisi='$nama', keterangan='$ket' WHERE id=$id");
    echo "<script>location.href='?page=divisi';</script>";
  }

  // Hapus
  elseif (isset($_GET['hapus_divisi'])) {
    $id = (int)$_GET['hapus_divisi'];
    mysqli_query($koneksi, "DELETE FROM divisi WHERE id=$id");
    echo "<script>location.href='?page=divisi';</script>";
  }
  ?>

  <!-- Tabel -->
  <div class="table-responsive mt-4">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama Divisi</th>
          <th>Keterangan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $q = mysqli_query($koneksi, "SELECT * FROM divisi ORDER BY nama_divisi ASC");
        while ($d = mysqli_fetch_assoc($q)) {
          echo "<tr>
                  <td>{$no}</td>
                  <td>{$d['nama_divisi']}</td>
                  <td>{$d['keterangan']}</td>
                  <td>
                    <a href='?page=divisi&edit_divisi={$d['id']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a>
                    <a href='?page=divisi&hapus_divisi={$d['id']}' onclick=\"return confirm('Hapus data ini?')\" class='btn btn-danger btn-sm'><i class='bi bi-trash'></i></a>
                  </td>
                </tr>";
          $no++;
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
