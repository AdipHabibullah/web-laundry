<?php
// layanan/edit.php - Edit Layanan
// Mengubah nama atau harga layanan.
include '../layout/header.php';
include '../config/koneksi.php';
include '../config/validasi.php';
$id = (int)$_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM layanan WHERE id_layanan=$id"));
if(!$data) { echo "Data tidak ditemukan"; exit; }

if(isset($_POST['update'])){
    $nama = bersih($_POST['nama']);
    $harga = (int)$_POST['harga'];
    mysqli_query($koneksi, "UPDATE layanan SET nama_layanan='$nama', harga=$harga WHERE id_layanan=$id");
    header('Location: index.php');
    exit;
}
?>
<h3>Edit Layanan</h3>
<form method="post">
  <input class="form-control mb-2" name="nama" value="<?= htmlspecialchars($data['nama_layanan']) ?>" required>
  <input class="form-control mb-2" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" required type="number">
  <button class="btn btn-primary" name="update">Update</button>
</form>
<?php include '../layout/footer.php'; ?>
