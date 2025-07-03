<div class="custom-card p-4">
  <h4 class="mb-4"><i class="bi bi-person-badge-fill me-2"></i> Data Pengurus</h4>

  <?php
  if (isset($_GET['edit_pengurus'])) {
    $id = $_GET['edit_pengurus'];
    $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pengurus WHERE id = $id"));
  }
  ?>

  <!-- Tampilan form dalam panel -->
  <div class="card border rounded shadow-sm">
    <div class="card-body">
      <form method="post">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="fw-bold">Nama Pengurus</label>
            <input type="text" name="nama_pengurus" class="form-control" placeholder="Nama Lengkap" required
              value="<?= $edit['nama_pengurus'] ?? '' ?>">
          </div>

          <div class="col-md-4">
            <label class="fw-bold">Jabatan</label>
            <select name="jabatan_id" class="form-control" required>
              <option value="">-- Pilih Jabatan --</option>
              <?php
              $jabatan = mysqli_query($koneksi, "SELECT * FROM jabatan");
              while ($j = mysqli_fetch_assoc($jabatan)) {
                $selected = isset($edit['jabatan_id']) && $edit['jabatan_id'] == $j['id'] ? 'selected' : '';
                echo "<option value='{$j['id']}' $selected>{$j['nama_jabatan']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="col-md-4">
            <label class="fw-bold">Unit</label>
            <select name="unit_id" class="form-control" required>
              <option value="">-- Pilih Unit --</option>
              <?php
              $unit = mysqli_query($koneksi, "SELECT * FROM unit");
              while ($u = mysqli_fetch_assoc($unit)) {
                $selected = isset($edit['unit_id']) && $edit['unit_id'] == $u['id'] ? 'selected' : '';
                echo "<option value='{$u['id']}' $selected>{$u['nama_unit']}</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="text-end">
          <button type="submit" name="<?= isset($edit) ? 'update_pengurus' : 'simpan_pengurus' ?>" class="btn btn-<?= isset($edit) ? 'warning' : 'primary' ?>">
            <?= isset($edit) ? '<i class="bi bi-pencil-square"></i> Update' : '<i class="bi bi-plus-circle"></i> Simpan' ?>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Proses -->
  <?php
  if (isset($_POST['simpan_pengurus'])) {
    mysqli_query($koneksi, "INSERT INTO pengurus (nama_pengurus, jabatan_id, unit_id) 
      VALUES ('{$_POST['nama_pengurus']}', '{$_POST['jabatan_id']}', '{$_POST['unit_id']}')");
    echo "<script>location.href='?page=pengurus';</script>";
  }

  elseif (isset($_POST['update_pengurus'])) {
    mysqli_query($koneksi, "UPDATE pengurus SET 
      nama_pengurus='{$_POST['nama_pengurus']}', 
      jabatan_id='{$_POST['jabatan_id']}', 
      unit_id='{$_POST['unit_id']}' 
      WHERE id={$_POST['id']}");
    echo "<script>location.href='?page=pengurus';</script>";
  }

  elseif (isset($_GET['hapus_pengurus'])) {
    mysqli_query($koneksi, "DELETE FROM pengurus WHERE id={$_GET['hapus_pengurus']}");
    echo "<script>location.href='?page=pengurus';</script>";
  }
  ?>

  <!-- Tabel -->
  <div class="table-responsive mt-4">
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama Pengurus</th>
          <th>Jabatan</th>
          <th>Unit</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $data = mysqli_query($koneksi, "
          SELECT p.*, j.nama_jabatan, u.nama_unit 
          FROM pengurus p
          LEFT JOIN jabatan j ON p.jabatan_id = j.id
          LEFT JOIN unit u ON p.unit_id = u.id
        ");
        while ($d = mysqli_fetch_assoc($data)) {
          echo "<tr>
                  <td>{$no}</td>
                  <td>{$d['nama_pengurus']}</td>
                  <td>{$d['nama_jabatan']}</td>
                  <td>{$d['nama_unit']}</td>
                  <td>
                    <a href='?page=pengurus&edit_pengurus={$d['id']}' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                    <a href='?page=pengurus&hapus_pengurus={$d['id']}' onclick=\"return confirm('Hapus data ini?')\" class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></a>
                  </td>
                </tr>";
          $no++;
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
