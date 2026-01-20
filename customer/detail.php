<?php
include '../config/koneksi.php';
$id = intval($_GET['id']);

$q = mysqli_query($koneksi, "
SELECT d.*, l.nama_layanan 
FROM transaksi_detail d
JOIN layanan l ON d.id_layanan=l.id_layanan
WHERE d.id_transaksi='$id'
");
?>
<!doctype html>
<html>
<head>
<title>Detail Laundry</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: #eef3f9;
        font-family: 'Segoe UI', sans-serif;
    }
    .card {
        border-radius: 18px;
        animation: fadeIn .6s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    h4 {
        font-weight: 600;
        text-align: center;
    }
    table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
    }
    .btn {
        border-radius: 10px;
    }
</style>
</head>

<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-lg">
                <div class="card-body">

                    <h4 class="mb-3">Detail Laundry</h4>

                    <table class="table table-bordered">
                        <tr class="table-light">
                            <th>Layanan</th>
                            <th>Berat</th>
                            <th>Subtotal</th>
                        </tr>

                        <?php while($r = mysqli_fetch_assoc($q)): ?>
                        <tr>
                            <td><?= $r['nama_layanan'] ?></td>
                            <td><?= $r['berat'] ?> Kg</td>
                            <td>Rp <?= number_format($r['subtotal']) ?></td>
                        </tr>
                        <?php endwhile; ?>

                    </table>

                    <a href="portal.php" class="btn btn-secondary w-100 mt-2">Kembali</a>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
