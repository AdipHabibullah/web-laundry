<?php
// layanan/tambah.php - Tambah Layanan Baru
// Form input untuk menambahkan jenis layanan baru.
include '../layout/header.php';
include '../config/koneksi.php';
include '../config/validasi.php';

if(isset($_POST['simpan'])){
    $nama = bersih($_POST['nama']);
    $harga = (int)$_POST['harga'];
    mysqli_query($koneksi, "INSERT INTO layanan (nama_layanan,harga) VALUES ('$nama',$harga)");
    header('Location: index.php');
    exit;
}
?>
<h3>Tambah Layanan</h3>
<form method="post">
  <input class="form-control mb-2" name="nama" placeholder="Nama Layanan" required>
  <input class="form-control mb-2" name="harga" placeholder="Harga" required type="number">
  <button class="btn btn-primary" name="simpan">Simpan</button>
</form>
<?php include '../layout/footer.php'; ?>
