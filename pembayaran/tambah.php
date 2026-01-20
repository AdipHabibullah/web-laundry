<?php
// pembayaran/tambah.php - Halaman Edit/Update Pembayaran
// Form untuk mengubah status bayar, metode, dan tanggal bayar.

require_once '../layout/header.php';
require_once '../config/koneksi.php';

$id_transaksi = isset($_GET['id_transaksi']) ? $_GET['id_transaksi'] : '';
$data_bayar = [];

if($id_transaksi) {
    // Cek apakah sudah ada data pembayaran sebelumnya di tabel pembayaran
    $q = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id_transaksi = '$id_transaksi'");
    $data_bayar = mysqli_fetch_assoc($q);
    
    // Ambil status bayar saat ini dari tabel transaksi untuk sinkronisasi tampilan
    $qt = mysqli_query($koneksi, "SELECT status_bayar FROM transaksi WHERE id_transaksi = '$id_transaksi'");
    $dt = mysqli_fetch_assoc($qt);
    $status_bayar_sekarang = $dt['status_bayar'] ?? 'Belum Lunas';
}

// Set nilai default form (ambil dari DB jika ada, atau default hari ini/kosong)
$tanggal_bayar = $data_bayar['tanggal_bayar'] ?? date('Y-m-d');
$metode = $data_bayar['metode'] ?? '';
$status_bayar = $status_bayar_sekarang ?? 'Belum Lunas';

?>

<div class="container mt-4">
    <div class="card shadow-sm border-0" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Status Pembayaran</h5>
        </div>
        <div class="card-body">
            <form action="simpan.php" method="POST">
                
                <div class="mb-3">
                    <label class="form-label">ID Transaksi</label>
                    <input type="text" name="id_transaksi" class="form-control" value="<?= htmlspecialchars($id_transaksi) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" class="form-control" value="<?= $tanggal_bayar ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="metode" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="Transfer" <?= $metode == 'Transfer' ? 'selected' : '' ?>>Transfer</option>
                        <option value="Cash" <?= $metode == 'Cash' ? 'selected' : '' ?>>Cash</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="status_bayar" class="form-select">
                        <option value="Lunas" <?= $status_bayar == 'Lunas' ? 'selected' : '' ?>>Sudah Bayar / Lunas</option>
                        <option value="Belum Lunas" <?= $status_bayar == 'Belum Lunas' ? 'selected' : '' ?>>Belum Bayar</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100">
                        Simpan Perubahan
                    </button>
                    <a href="index.php" class="btn btn-secondary w-100">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php require_once '../layout/footer.php'; ?>
