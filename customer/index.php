<?php include '../config/koneksi.php'; ?>
<!doctype html>
<html>
<head>
    <title>Cek Status Laundry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .card {
            border-radius: 18px;
        }
        .title {
            font-weight: 700;
            letter-spacing: .5px;
        }
        .input-custom {
            border-radius: 10px;
            height: 48px;
        }
        .btn-custom {
            border-radius: 10px;
            height: 48px;
            font-size: 16px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            
            <div class="card shadow-lg animate__animated animate__fadeInUp">
                <div class="card-body p-4">

                    <h3 class="text-center mb-3 title">🔍 Cek Status Laundry</h3>
                    <p class="text-center text-muted mb-4">Masukkan ID transaksi untuk melihat status cucian Anda</p>

                    <form method="post" action="cek.php">

                        <input type="text"
                               name="kode"
                               class="form-control input-custom mb-3"
                               placeholder="Contoh: 1023"
                               required>

                        <button class="btn btn-primary w-100 btn-custom">
                            Cek Status
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
