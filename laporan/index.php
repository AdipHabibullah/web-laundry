<?php
// laporan/index.php - Halaman Index Laporan
// Menu utama untuk akses download excel dan lihat grafik.
include '../layout/header.php';
?>
<h3>Laporan</h3>
<div class="mb-3">
  <a class="btn btn-success" href="export.php">Download Excel (xls)</a>
  <a class="btn btn-secondary" href="chart.php">Lihat Chart Omzet</a>
</div>
<?php include '../layout/footer.php'; ?>