<?php
// users/tambah.php - Tambah User Baru
// Menambahkan akun pengguna baru dengan password yang di-hash.
include '../layout/header.php';
include '../config/koneksi.php';
// Proteksi: Hanya admin
if($_SESSION['user']['role'] !== 'admin') { die('Akses ditolak'); }

if(isset($_POST['simpan'])){
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);
    mysqli_query($koneksi, "INSERT INTO user (nama, username, password, role) VALUES ('$nama','$username','$pass','$role')");
    header('Location: index.php');
    exit;
}
?>
<h3>Tambah User</h3>
<form method="post">
  <input class="form-control mb-2" name="nama" placeholder="Nama" required>
  <input class="form-control mb-2" name="username" placeholder="Username" required>
  <input type="password" class="form-control mb-2" name="password" placeholder="Password" required>
  <select name="role" class="form-select mb-2">
    <option value="kasir">Kasir</option>
    <option value="admin">Admin</option>
  </select>
  <button class="btn btn-primary" name="simpan">Simpan</button>
</form>
<?php include '../layout/footer.php'; ?>
