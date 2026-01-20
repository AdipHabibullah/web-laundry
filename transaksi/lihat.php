<?php
// transaksi/lihat.php - Halaman Detail Transaksi
// Menampilkan rincian transaksi, tombol cetak, dan update status.
include '../layout/header.php';
include '../config/koneksi.php';
$id = (int)$_GET['id'];
$t = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT t.*, p.nama as pelanggan FROM transaksi t LEFT JOIN pelanggan p ON t.id_pelanggan=p.id_pelanggan WHERE t.id_transaksi=$id"));
if(!$t) { echo "Transaksi tidak ditemukan"; include '../layout/footer.php'; exit; }
$details = mysqli_query($koneksi, "SELECT d.*, l.nama_layanan FROM transaksi_detail d LEFT JOIN layanan l ON d.id_layanan=l.id_layanan WHERE d.id_transaksi=$id");
?>
<div id="nota">
<h3>Nota - #<?= $t['id_transaksi'] ?></h3>
<p>Pelanggan: <?= htmlspecialchars($t['pelanggan']) ?> | Tanggal: <?= $t['tanggal'] ?> | Status Pembayaran: <span class="badge bg-<?= $t['status_bayar']=='Lunas' ? 'success' : 'danger' ?>"><?= $t['status_bayar'] ?? 'Belum Lunas' ?></span></p>
<table class="table">
<thead><tr><th>Layanan</th><th>Berat</th><th>Subtotal</th></tr></thead>
<tbody>
<?php while($d = mysqli_fetch_assoc($details)): ?>
  <tr><td><?= htmlspecialchars($d['nama_layanan']) ?></td><td><?= $d['berat'] ?></td><td><?= number_format($d['subtotal'],0,',','.') ?></td></tr>
<?php endwhile; ?>
</tbody>
</table>
<h5>Total: <?= number_format($t['total'],0,',','.') ?></h5>
</div>

<!-- update status -->
<form method="post" action="update_status.php" class="mb-2">
  <input type="hidden" name="id" value="<?= $t['id_transaksi'] ?>">
  <select name="status" class="form-select w-25 d-inline-block me-2">
    <option <?= $t['status']=='diproses'?'selected':'' ?>>diproses</option>
    <option <?= $t['status']=='dicuci'?'selected':'' ?>>dicuci</option>
    <option <?= $t['status']=='disetrika'?'selected':'' ?>>disetrika</option>
    <option <?= $t['status']=='selesai'?'selected':'' ?>>selesai</option>
    <option <?= $t['status']=='diambil'?'selected':'' ?>>diambil</option>
  </select>
  <button class="btn btn-warning">Update Status</button>
</form>

<a class="btn btn-secondary" href="index.php">Kembali</a>
<button class="btn btn-primary" id="btnPrint">Cetak (Print)</button>
<button class="btn btn-success" id="btnPdf">Download PDF</button>

<script>
// Print (Membuka jendela baru untuk cetak.php)
document.getElementById('btnPrint').addEventListener('click', function(){
  const id = "<?= $t['id_transaksi'] ?>";
  // Buka jendela full screen
  const w = window.open('../cetak.php?id='+id, '_blank', `width=${screen.width},height=${screen.height},top=0,left=0,resizable=yes,scrollbars=yes`);
});

// Validasi Status Laundry 'Selesai'
// Mencegah update status 'Selesai' jika pembayaran belum 'Lunas'
document.querySelector('form').addEventListener('submit', function(e){
  const statusSelect = document.querySelector('select[name="status"]');
  const selectedStatus = statusSelect.value;
  // Get status_bayar from PHP
  const statusBayar = "<?= $t['status_bayar'] ?>"; 

  if(selectedStatus === 'selesai' && statusBayar !== 'Lunas'){
      e.preventDefault();
      alert('Status Laundry tidak dapat diubah menjadi Selesai karena Status Pembayaran belum Lunas!');
  }
});

// Fitur Download PDF menggunakan html2canvas dan jsPDF (Client Side)
document.getElementById('btnPdf').addEventListener('click', async function(){
  const nota = document.getElementById('nota');
  
  // Render elemen #nota menjadi canvas gambar
  const canvas = await html2canvas(nota, { scale: 2 });
  const imgData = canvas.toDataURL('image/png');
  
  // Masukkan gambar ke PDF A4
  const { jsPDF } = window.jspdf;
  const pdf = new jsPDF('p','pt','a4');
  const imgProps = pdf.getImageProperties(imgData);
  const pdfWidth = pdf.internal.pageSize.getWidth();
  const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
  
  pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
  pdf.save('nota_<?= $t['id_transaksi'] ?>.pdf');
});
</script>

<?php include '../layout/footer.php'; ?>
