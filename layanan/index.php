<?php
// layanan/index.php - Manajemen Layanan
// Menampilkan daftar harga dan jenis layanan laundry.
include '../layout/header.php';
include '../config/koneksi.php';
$q = mysqli_query($koneksi, "SELECT * FROM layanan ORDER BY id_layanan ASC");
?>
<h3>Layanan <a href="tambah.php" class="btn btn-sm btn-primary">Tambah</a></h3>
<table class="table table-striped">
<thead><tr><th>No</th><th>Nama</th><th>Harga</th><th>Aksi</th></tr></thead>
<tbody>
<?php while($r = mysqli_fetch_assoc($q)): ?>
  <tr>
    <td><?= $r['id_layanan'] ?></td>
    <td><?= htmlspecialchars($r['nama_layanan']) ?></td>
    <td><?= number_format($r['harga'],0,',','.') ?></td>
    <td>
      <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $r['id_layanan'] ?>">Edit</a>
      <a class="btn btn-sm btn-danger" href="hapus.php?id=<?= $r['id_layanan'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
    </td>
  </tr>
<?php endwhile; ?>
</tbody>
</table>
<?php include '../layout/footer.php'; ?>
