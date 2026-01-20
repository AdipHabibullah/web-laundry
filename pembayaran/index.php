<?php
// pembayaran/index.php - Halaman Daftar Pembayaran
// Menampilkan status pembayaran setiap transaksi.
include '../layout/header.php';
include '../config/koneksi.php';
?>

<h3>
    Data Pembayaran Transaksi

</h3>

<table class="table table-striped table-hover align-middle">
<thead>
<tr>
    <th>No</th>
    <th>ID Transaksi</th>
    <th>Pelanggan</th>
    <th>Total Tagihan</th>
    <th>Status Bayar</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php 
// Mengambil data transaksi digabungkan dengan nama pelanggan
// Menggunakan LEFT JOIN agar transaksi tetap muncul meski data pelanggan bermasalah (jarang terjadi)
$q = mysqli_query($koneksi, "
    SELECT t.*, p.nama as nama_pelanggan
    FROM transaksi t
    LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    ORDER BY t.id_transaksi ASC
");

$no = 1;
while($r = mysqli_fetch_assoc($q)): 
?>
<tr>
    <td><?= $no++ ?></td>
    <td>#<?= $r['id_transaksi'] ?></td>
    <td><?= htmlspecialchars($r['nama_pelanggan']) ?></td>
    <td>Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
    <td>
        <?php if($r['status_bayar'] == 'Lunas'): ?>
            <span class="badge bg-success">Lunas</span>
        <?php else: ?>
            <span class="badge bg-danger">Belum Lunas</span>
        <?php endif; ?>
    </td>
    <td>
        <!-- Tombol Edit Pembayaran -->
        <a href="tambah.php?id_transaksi=<?= $r['id_transaksi'] ?>" class="btn btn-sm btn-info text-white">
            <i class="bi bi-pencil-square"></i> Edit Pembayaran
        </a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<?php include '../layout/footer.php'; ?>
