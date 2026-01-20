<?php
// pembayaran/simpan.php - Script Simpan Pembayaran
// Menyimpan data pembayaran ke tabel 'pembayaran' dan mengupdate status di tabel 'transaksi'.

include '../config/koneksi.php';

// Ambil data dari form POST
$id_transaksi = $_POST['id_transaksi'];
$tanggal_bayar = $_POST['tanggal_bayar'];
$metode = $_POST['metode'];
$status_bayar = $_POST['status_bayar']; // Lunas / Belum Lunas

// 1. Update atau Insert ke tabel pembayaran
// Cek dulu apakah sudah ada record pembayaran untuk ID transaksi ini
// Jika ada -> UPDATE, Jika belum -> INSERT
$cek = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id_transaksi = '$id_transaksi'");

if(mysqli_num_rows($cek) > 0) {
    // Update
    $query_pembayaran = "UPDATE pembayaran SET 
                            tanggal_bayar = '$tanggal_bayar',
                            metode = '$metode'
                         WHERE id_transaksi = '$id_transaksi'";
} else {
    // Insert (Baru) w/o bukti
    $query_pembayaran = "INSERT INTO pembayaran (id_transaksi, tanggal_bayar, metode, bukti) 
                         VALUES ('$id_transaksi', '$tanggal_bayar', '$metode', '')";
}

$exec_pembayaran = mysqli_query($koneksi, $query_pembayaran);

// 2. Update status bayar di tabel transaksi
$query_transaksi = "UPDATE transaksi SET status_bayar = '$status_bayar' WHERE id_transaksi = '$id_transaksi'";
$exec_transaksi = mysqli_query($koneksi, $query_transaksi);

if($exec_pembayaran && $exec_transaksi) {
    // Sukses
    echo "<script>
            alert('Data pembayaran berhasil disimpan!');
            window.location.href = 'index.php';
          </script>";
} else {
    // Gagal
    echo "<script>
            alert('Gagal menyimpan data!');
            history.go(-1);
          </script>";
}
?>
