<?php
// pelanggan/index.php - Halaman Utama Manajemen Pelanggan
// Menampilkan daftar pelanggan yang terdaftar di database.
include '../layout/header.php';
include '../config/koneksi.php';

// Mengambil semua data pelanggan diurutkan berdasarkan ID
$q = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id_pelanggan ASC");
?>

<h3>
  Pelanggan 
  <a href="tambah.php" class="btn btn-sm btn-primary">Tambah</a>
</h3>

<table class="table table-striped">
<thead>
  <tr>
    <th>No</th>
    <th>Nama</th>
    <th>No HP</th>
    <th>Alamat</th>
    <th>Aksi</th>
  </tr>
</thead>
<tbody>
<?php while($r = mysqli_fetch_assoc($q)): ?>
  <tr>
    <td><?= $r['id_pelanggan'] ?></td>
    <td><?= htmlspecialchars($r['nama']) ?></td>
    <td><?= htmlspecialchars($r['no_hp']) ?></td>
    <td><?= htmlspecialchars($r['alamat']) ?></td>
    <td>
      <a class="btn btn-sm btn-warning" 
         href="edit.php?id=<?= $r['id_pelanggan'] ?>">Edit</a>

      <a class="btn btn-sm btn-danger" 
         href="hapus.php?id=<?= $r['id_pelanggan'] ?>"
         onclick="return confirm('Hapus?')">Hapus</a>
    </td>
  </tr>
<?php endwhile; ?>
</tbody>
</table>

<?php include '../layout/footer.php'; ?>
