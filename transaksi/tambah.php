<?php
// transaksi/tambah.php - Halaman Tambah Transaksi Baru
// Menangani input transaksi dengan multiple item (detail layanan).

include '../config/koneksi.php';
include '../config/validasi.php';

if(isset($_POST['simpan'])){
    // 1. Simpan Header Transaksi (Total simpan 0 dulu)
    $id_pelanggan = (int)$_POST['pelanggan'];
    $tanggal = bersih($_POST['tanggal']);
    mysqli_query($koneksi, "INSERT INTO transaksi (id_pelanggan,tanggal,total) VALUES ($id_pelanggan,'$tanggal',0)");
    
    // Ambil ID Transaksi yang barusan dibuat
    $id_trans = mysqli_insert_id($koneksi);
    
    // 2. Simpan Detail Layanan (Looping item)
    $total = 0;
    foreach($_POST['layanan'] as $idx => $id_layanan){
        $id_layanan = (int)$id_layanan;
        $berat = (float)$_POST['berat'][$idx];
        $harga = (int)$_POST['harga'][$idx];
        $subtotal = (int)round($berat * $harga);
        $total += $subtotal;
        
        // Insert ke transaksi_detail
        mysqli_query($koneksi, "INSERT INTO transaksi_detail (id_transaksi,id_layanan,berat,subtotal) VALUES ($id_trans,$id_layanan,$berat,$subtotal)");
    }
    
    // 3. Update Total Transaksi
    mysqli_query($koneksi, "UPDATE transaksi SET total=$total WHERE id_transaksi=$id_trans");
    
    header('Location: index.php');
    exit;
}

include '../layout/header.php';

$pel = mysqli_query($koneksi, 'SELECT * FROM pelanggan');
$lay = mysqli_query($koneksi, 'SELECT * FROM layanan');
?>
<h3>Tambah Transaksi</h3>
<form method="post" id="formTransaksi">
  <div class="mb-2">
    <label>Pelanggan</label>
    <select name="pelanggan" class="form-select">
      <?php while($p = mysqli_fetch_assoc($pel)): ?>
        <option value="<?= $p['id_pelanggan'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="mb-2">
    <label>Tanggal</label>
    <input class="form-control" type="date" name="tanggal" value="<?= date('Y-m-d') ?>">
  </div>

  <h5>Detail</h5>
  <div id="items">
    <div class="row g-2 mb-2 item">
      <div class="col-md-5">
        <select class="form-select layanan_select" name="layanan[]">
          <?php foreach(mysqli_query($koneksi,'SELECT * FROM layanan') as $l): ?>
            <option value="<?= $l['id_layanan'] ?>" data-harga="<?= $l['harga'] ?>"><?= htmlspecialchars($l['nama_layanan']) ?> - <?= number_format($l['harga'],0,',','.') ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2"><input class="form-control berat" name="berat[]" placeholder="Berat (kg)" required></div>
      <div class="col-md-3"><input class="form-control harga" name="harga[]" placeholder="Harga" required readonly></div>
      <div class="col-md-1"><input class="form-control subtotal" name="subtotal[]" placeholder="Subtotal" readonly></div>
      <div class="col-md-1"><button class="btn btn-danger btn-sm remove" type="button">x</button></div>
    </div>
  </div>

  <div class="mb-2">
    <button class="btn btn-secondary" id="add" type="button">Tambah Item</button>
  </div>

  <div class="mb-2">
    <label>Total</label>
    <input class="form-control" id="total" name="total_display" readonly>
  </div>

  <button class="btn btn-primary" name="simpan" type="submit">Simpan Transaksi</button>
</form>

<script>
// Logic JavaScript untuk menangani input dinamis (Tambah/Hapus Item)
// dan kalkulasi otomatis subtotal & total.

// helper function untuk update harga & subtotal baris
function updateRow(row){
  const select = row.querySelector('.layanan_select');
  const hargaInput = row.querySelector('.harga');
  const beratInput = row.querySelector('.berat');
  const subtotalInput = row.querySelector('.subtotal');
  
  // Ambil data harga dari atribut data-harga pada option yang dipilih
  const harga = parseInt(select.selectedOptions[0].dataset.harga || 0);
  hargaInput.value = harga;
  
  const berat = parseFloat(beratInput.value || 0);
  subtotalInput.value = Math.round(harga * berat);
  
  updateTotal();
}

// helper function hitung Grand Total
function updateTotal(){
  let total = 0;
  document.querySelectorAll('.subtotal').forEach(s=>{
    total += parseInt(s.value || 0);
  });
  document.getElementById('total').value = total;
}

// Event Listeners (menggunakan event delegation untuk performance & support elemen dinamis)
document.getElementById('items').addEventListener('input', function(e){
  if(e.target.classList.contains('berat') || e.target.classList.contains('harga')){
    const row = e.target.closest('.item');
    updateRow(row);
  }
});

document.getElementById('items').addEventListener('change', function(e){
  if(e.target.classList.contains('layanan_select')){
    const row = e.target.closest('.item');
    updateRow(row);
  }
});

// Tombol Tambah Item
document.getElementById('add').addEventListener('click', function(){
  const container = document.getElementById('items');
  // Clone baris pertama sebagai template
  const template = container.querySelector('.item').outerHTML;
  container.insertAdjacentHTML('beforeend', template);
});

// Tombol Hapus Item
document.addEventListener('click', function(e){
  if(e.target.classList.contains('remove')) e.target.closest('.item').remove(), updateTotal();
});

// Inisialisasi hitungan awal
document.querySelectorAll('.item').forEach(r=> updateRow(r));
</script>

<?php include '../layout/footer.php'; ?>
