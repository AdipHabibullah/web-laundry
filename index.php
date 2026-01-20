<?php
/**
 * Halaman Dashboard Admin
 * Menampilkan statistik ringkasan (total pelanggan, transaksi, omzet)
 * dan daftar transaksi terakhir.
 */
include 'layout/header.php';
include 'config/koneksi.php';

/* ================= STAT TOTAL ================= */
// Menghitung total jumlah pelanggan yang terdaftar di database
$pelanggan = (int) mysqli_fetch_assoc(
  mysqli_query($koneksi, "SELECT COUNT(*) AS c FROM pelanggan")
)['c'];

// Menghitung total seluruh transaksi yang pernah dilakukan
$transaksi = (int) mysqli_fetch_assoc(
  mysqli_query($koneksi, "SELECT COUNT(*) AS c FROM transaksi")
)['c'];

// Menghitung omzet / pendapatan hari ini
// Hanya menghitung transaksi dengan status 'Selesai' dan tanggal hari ini (CURDATE)
$omzet_hari_ini = (int) mysqli_fetch_assoc(
  mysqli_query(
    $koneksi,
    "SELECT IFNULL(SUM(total),0) AS total 
     FROM transaksi 
     WHERE status='Selesai' 
     AND DATE(tanggal)=CURDATE()"
  )
)['total'];

/* ================= TRANSAKSI TERAKHIR ================= */
// Mengambil 20 data transaksi terakhir untuk ditampilkan di dashboard
// Menggunakan JOIN untuk mendapatkan nama pelanggan dari tabel pelanggan
$recent = mysqli_query($koneksi, "
  SELECT t.*, p.nama AS pelanggan
  FROM transaksi t
  LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
  ORDER BY t.id_transaksi DESC
  LIMIT 20
");
?>

<h3 class="mb-4 fw-bold animate_animated animatefadeInDown animate_slow">
  Dashboard
</h3>

<div class="row g-4 mb-4">

  <!-- Total Pelanggan -->
  <div class="col-md-4">
    <a href="pelanggan/index.php" class="text-decoration-none">
      <div class="card shadow-sm border-0 p-4 animate_animated animatezoomIn animate_slow">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-1">Total Pelanggan</h6>
            <h2 class="fw-bold text-primary mb-0"><?= $pelanggan ?></h2>
          </div>
          <div class="rounded-circle bg-primary bg-opacity-25 p-3">
            <i class="bi bi-people text-primary fs-3"></i>
          </div>
        </div>
      </div>
    </a>
  </div>

  <!-- Total Transaksi -->
  <div class="col-md-4">
    <a href="transaksi/index.php" class="text-decoration-none">
      <div class="card shadow-sm border-0 p-4 animate_animated animatezoomIn animatedelay-1s animate_slow">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-1">Total Transaksi</h6>
            <h2 class="fw-bold text-success mb-0"><?= $transaksi ?></h2>
          </div>
          <div class="rounded-circle bg-success bg-opacity-25 p-3">
            <i class="bi bi-receipt text-success fs-3"></i>
          </div>
        </div>
      </div>
    </a>
  </div>

  <!-- Omzet Hari Ini -->
  <div class="col-md-4">
    <div class="card shadow-sm border-0 p-4 animate_animated animatezoomIn animatedelay-2s animate_slow">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="text-muted mb-1">Omzet Hari Ini</h6>
          <h2 class="fw-bold text-warning mb-0">
            Rp <?= number_format($omzet_hari_ini, 0, ',', '.') ?>
          </h2>
        </div>
        <div class="rounded-circle bg-warning bg-opacity-25 p-3">
          <i class="bi bi-cash-stack text-warning fs-3"></i>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="card shadow-sm border-0 animate_animated animatefadeInUp animate_slow">
  <div class="card-body">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="fw-bold mb-0">
        <i class="bi bi-clock-history"></i> Transaksi Terakhir
      </h5>
      <a href="transaksi/index.php" class="btn btn-sm btn-outline-primary">
        Lihat Semua
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>

        <?php if(mysqli_num_rows($recent) > 0): ?>
          <?php while($r = mysqli_fetch_assoc($recent)): ?>
            <tr>
              <td>#<?= $r['id_transaksi'] ?></td>
              <td><?= htmlspecialchars($r['pelanggan'] ?? '-') ?></td>
              <td><?= date('d M Y', strtotime($r['tanggal'])) ?></td>
              <td>Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
              <td>
                <?php if(strtolower($r['status']) == 'selesai'): ?>
                  <span class="badge bg-success">Selesai</span>
                <?php elseif(strtolower($r['status']) == 'proses'): ?>
                  <span class="badge bg-warning text-dark">Proses</span>
                <?php else: ?>
                  <span class="badge bg-secondary"><?= htmlspecialchars($r['status']) ?></span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center text-muted">
              Belum ada transaksi
            </td>
          </tr>
        <?php endif; ?>

        </tbody>
      </table>
    </div>

  </div>
</div>

<?php include 'layout/footer.php'; ?>