<?php
// pelanggan/edit.php - Halaman Edit Pelanggan
// Mengambil data lama dan mengupdate data pelanggan.
include '../layout/header.php';
include '../config/koneksi.php';
include '../config/validasi.php';

// Mengambil ID dari parameter URL
$id = (int)$_GET['id'];

/* Ambil data pelanggan berdasarkan ID untuk ditampilkan di form */
$data = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan=$id")
);

// Validasi jika data tidak ditemukan
if(!$data){
    echo "Data tidak ditemukan";
    exit;
}

/* data layanan (Legacy code, mungkin tidak digunakan di tabel pelanggan saat ini) */
$layanan = mysqli_query($koneksi, "SELECT * FROM layanan");

// Proses update saat form disubmit
if(isset($_POST['update'])){
    $nama       = bersih($_POST['nama']);
    $hp         = bersih($_POST['hp']);
    $alamat     = bersih($_POST['alamat']);
    
    // Catatan: id_layanan mungkin tidak ada di tabel pelanggan, code ini mungkin perlu penyesuaian
    // jika kolom tersebut tidak ada.
    $id_layanan = (int)$_POST['id_layanan'];

    // Query UPDATE data
    mysqli_query($koneksi, "
        UPDATE pelanggan SET
            nama='$nama',
            no_hp='$hp',
            alamat='$alamat',
            id_layanan='$id_layanan'
        WHERE id_pelanggan=$id
    ");

    header('Location: index.php');
    exit;
}
?>

<h3>Edit Pelanggan</h3>

<div class="card shadow-sm col-md-6">
  <div class="card-body">
    <form method="post">

      <div class="mb-3">
        <label class="form-label">Nama Pelanggan</label>
        <input class="form-control" name="nama"
               value="<?= htmlspecialchars($data['nama']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">No HP</label>
        <input class="form-control" name="hp"
               value="<?= htmlspecialchars($data['no_hp']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea class="form-control" name="alamat" rows="3" required><?= 
            htmlspecialchars($data['alamat']) ?></textarea>
      </div>

      <button class="btn btn-primary" name="update">
        <i class="bi bi-save"></i> Update
      </button>

      <a href="index.php" class="btn btn-secondary ms-2">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>

    </form>
  </div>
</div>

<?php include '../layout/footer.php'; ?>
