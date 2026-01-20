<?php
// pelanggan/tambah.php - Halaman Tambah Pelanggan
// Menangani form tambah data pelanggan baru.
include '../config/koneksi.php';

// Proses simpan data saat tombol 'simpan' ditekan
if (isset($_POST['simpan'])) {

    // Sanitasi input untuk mencegah SQL Injection
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $no_hp  = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    // Query INSERT ke tabel pelanggan
    mysqli_query($koneksi, "INSERT INTO pelanggan (nama, no_hp, alamat)
                VALUES ('$nama','$no_hp','$alamat')");

    // Redirect kembali ke halaman index setelah simpan
    header('Location: index.php');
    exit;
}

include '../layout/header.php';
/* ambil data layanan */
// layanan selection removed
?>

<h3>Tambah Pelanggan</h3>

<div class="card shadow-sm col-md-6">
  <div class="card-body">
    <form method="post">

      <div class="mb-3">
        <label class="form-label">Nama Pelanggan</label>
        <input type="text" name="nama" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">No HP</label>
        <input type="text" name="no_hp" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" rows="3" required></textarea>
      </div>

      <!-- layanan selection removed -->

      <!-- AKSI -->
      <div class="d-flex gap-2">
        <button type="submit" name="simpan" class="btn btn-primary">
          <i class="bi bi-save"></i> Simpan
        </button>

        <a href="index.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <button type="reset" class="btn btn-outline-danger">
          <i class="bi bi-x-circle"></i> Reset
        </button>
      </div>

    </form>
  </div>
</div>

<?php include '../layout/footer.php'; ?>
