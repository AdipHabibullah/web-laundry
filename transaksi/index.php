<?php
// transaksi/index.php - Halaman Utama Transaksi
// Menampilkan daftar semua transaksi, status, dan opsi kirim WA.
include '../config/koneksi.php';
include '../layout/header.php';

$q = mysqli_query($koneksi, "
    SELECT 
        t.*, 
        p.nama AS pelanggan,
        p.no_hp
    FROM transaksi t
    LEFT JOIN pelanggan p 
        ON t.id_pelanggan = p.id_pelanggan
    ORDER BY t.id_transaksi ASC
");
?>

<div class="container mt-4">

  <h3 class="mb-3 fw-bold">
    Data Transaksi
    <a href="tambah.php" class="btn btn-sm btn-primary float-end">
      + Tambah
    </a>
  </h3>

  <div class="card shadow-sm border-0">
    <div class="card-body">

      <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th width="240">Aksi</th>
          </tr>
        </thead>

        <tbody>

        <?php if(mysqli_num_rows($q) > 0): ?>
          <?php while($r = mysqli_fetch_assoc($q)): ?>

            <tr>
              <td><?= $r['id_transaksi']; ?></td>
              <td><?= htmlspecialchars($r['pelanggan'] ?? '-'); ?></td>
              <td><?= $r['tanggal']; ?></td>
              <td>Rp <?= number_format($r['total'], 0, ',', '.'); ?></td>

              <td>
                <?php if(strtolower($r['status']) == 'selesai'): ?>
                  <span class="badge bg-success">Selesai</span>
                <?php elseif(strtolower($r['status']) == 'proses'): ?>
                  <span class="badge bg-warning text-dark">Proses</span>
                <?php else: ?>
                  <span class="badge bg-secondary"><?= $r['status']; ?></span>
                <?php endif; ?>
              </td>

              <td class="d-flex gap-1">

                <a class="btn btn-sm btn-outline-primary"
                   href="lihat.php?id=<?= $r['id_transaksi']; ?>">
                   Lihat
                </a>

                <?php if(
                    strtolower(trim($r['status'])) == 'selesai' 
                    && !empty($r['no_hp'])
                ): ?>

                  <?php
                    // Logic kirim pesan WhatsApp
                    // Format nomor HP 08xx -> 628xx
                    $noWa   = '62' . ltrim($r['no_hp'], '0');
                    $harga = number_format($r['total'], 0, ',', '.');

                    // Template pesan WA
                    $pesan = "
Halo {$r['pelanggan']} 

 Transaksi laundry Anda SUDAH SELESAI
 ID Transaksi : {$r['id_transaksi']}
 Total Bayar  : Rp {$harga}

Silakan lakukan pembayaran ya 
Terima kasih 
                    ";
                  ?>

                  <a class="btn btn-sm btn-success"
                     target="_blank"
                     href="https://wa.me/<?= $noWa ?>?text=<?= urlencode($pesan) ?>">
                     <i class="bi bi-whatsapp"></i> Chat
                  </a>

                <?php endif; ?>

                <a class="btn btn-sm btn-outline-danger"
                   href="hapus.php?id=<?= $r['id_transaksi']; ?>"
                   onclick="return confirm('Hapus transaksi ini?')">
                   Hapus
                </a>

              </td>
            </tr>

          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center text-muted">
              Belum ada data transaksi
            </td>
          </tr>
        <?php endif; ?>

        </tbody>
      </table>

    </div>
  </div>

</div>

<?php include '../layout/footer.php'; ?>
