<?php
// users/edit.php - Edit Data User
// Bisa ubah nama, username, role, dan password (jika diisi).
include '../layout/header.php';
include '../config/koneksi.php';

if($_SESSION['user']['role'] !== 'admin') { 
    die('Akses ditolak'); 
}


$id = intval($_GET['id']);


$q = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id'");
$data = mysqli_fetch_assoc($q);

if(!$data){
    echo "<script>alert('User tidak ditemukan');location='index.php';</script>";
    exit;
}

if(isset($_POST['simpan'])){
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $role     = mysqli_real_escape_string($koneksi, $_POST['role']);

   
    if(!empty($_POST['password'])){
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update = mysqli_query($koneksi, "
            UPDATE user SET 
                nama='$nama',
                username='$username',
                password='$password',
                role='$role'
            WHERE id_user='$id'
        ");
    } else {
        $update = mysqli_query($koneksi, "
            UPDATE user SET 
                nama='$nama',
                username='$username',
                role='$role'
            WHERE id_user='$id'
        ");
    }

    echo "<script>alert('User berhasil diupdate');location='index.php';</script>";
}
?>

<div class="container py-4">
    <div class="card shadow col-md-6 mx-auto">
        <div class="card-body">
            <h4 class="mb-3">Edit User</h4>

            <form method="post">

                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control mb-2" 
                       value="<?= htmlspecialchars($data['nama']) ?>" required>

                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control mb-2" 
                       value="<?= htmlspecialchars($data['username']) ?>" required>

                <label class="form-label">Password Baru (opsional)</label>
                <input type="password" name="password" class="form-control mb-2" 
                       placeholder="Kosongkan jika tidak diganti">

                <label class="form-label">Role</label>
                <select name="role" class="form-control mb-3" required>
                    <option value="admin" <?= $data['role']=='admin'?'selected':'' ?>>Admin</option>
                    <option value="kasir" <?= $data['role']=='kasir'?'selected':'' ?>>Kasir</option>
                </select>

                <button class="btn btn-primary w-100" name="simpan">Simpan Perubahan</button>
                <a href="index.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
