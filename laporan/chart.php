<?php
// laporan/chart.php - Halaman Grafik
// Menampilkan visualisasi data transaksi menggunakan Chart.js.
include '../layout/header.php';
include '../config/koneksi.php';
?>

<h3>Chart Omzet Harian (7 hari terakhir)</h3>
<canvas id="chartOmzet" width="400" height="150"></canvas>

<!-- WAJIB: Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
fetch('chart_data.php')
  .then(res => res.json())
  .then(data => {
    const ctx = document.getElementById('chartOmzet').getContext('2d');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.labels,
        datasets: [{
          label: 'Omzet',
          data: data.data,
          borderColor: 'blue',
          backgroundColor: 'rgba(0, 0, 255, 0.2)',
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  })
  .catch(err => console.error('Error fetch:', err));
</script>

<?php include '../layout/footer.php'; ?>
