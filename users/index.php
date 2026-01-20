<?php
// users/index.php - Manajemen User (Admin & Kasir)
// Hanya bisa diakses oleh role 'admin'.
include '../layout/header.php';
include '../config/koneksi.php';


if($_SESSION['user']['role'] !== 'admin'){
    die('Akses ditolak');
}


$q = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_user DESC");
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Manajemen Users</h3>
        <a href="tambah.php" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus"></i> Tambah User
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($r = mysqli_fetch_assoc($q)): ?>
                    <tr>
                        <td><?= $r['id_user'] ?></td>
                        <td><?= htmlspecialchars($r['nama']) ?></td>
                        <td><?= htmlspecialchars($r['username']) ?></td>
                        <td>
                            <!-- Badge warna berbeda untuk admin/kasir -->
                            <span class="badge bg-<?= $r['role']=='admin'?'danger':'secondary' ?>">
                                <?= ucfirst($r['role']) ?>
                            </span>
                        </td>
                        <td>
                            
                            <a href="edit.php?id=<?= $r['id_user'] ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>

                           
                            <?php if($r['id_user'] != $_SESSION['user']['id_user']): ?>
                                <a href="hapus.php?id=<?= $r['id_user'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>

                <?php if(mysqli_num_rows($q) == 0): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            Belum ada data user
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
