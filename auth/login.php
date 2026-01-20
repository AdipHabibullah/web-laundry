<?php
session_start();
// Cek jika user sudah login, langsung alihkan ke halaman utama
if (isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}

include '../config/koneksi.php';

$err = null;

// Proses Login
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Cek username di database
    $q = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' LIMIT 1");

    if ($r = mysqli_fetch_assoc($q)) {
        // Verifikasi password (hashed)
        if (password_verify($password, $r['password'])) {
            // Set session jika login sukses
            $_SESSION['login'] = true;
            $_SESSION['user']  = $r;
            header('Location: ../index.php');
            exit;
        }
    }

    // Jika gagal
    $err = "Username atau password salah.";
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login | Kinclong Laundry</title>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: url('../cust/assets/img/laundry.jpg') no-repeat center center fixed;
  background-size: cover;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0;
}

/* Dark overlay for better contrast if needed, optional */
body::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.3); /* Slight darkening */
  z-index: -1;
}

.login-card {
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(15px);
  -webkit-backdrop-filter: blur(15px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 20px;
  padding: 40px;
  width: 100%;
  max-width: 400px;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
  animation: fadeUp 0.8s ease-out;
  color: #fff;
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

.login-header {
  text-align: center;
  margin-bottom: 30px;
}

.login-header h3 {
  font-weight: 700;
  letter-spacing: 1px;
  margin-bottom: 10px;
  color: #fff;
}

.login-header p {
  font-size: 14px;
  color: rgba(255, 255, 255, 0.8);
}

/* Material Input Style */
.form-group {
  position: relative;
  margin-bottom: 25px;
}

.form-control {
  background: transparent;
  border: none;
  border-bottom: 2px solid rgba(255, 255, 255, 0.4);
  border-radius: 0;
  padding: 10px 0;
  color: #fff;
  font-size: 16px;
  padding-left: 30px; /* Space for icon */
  transition: all 0.3s;
}

.form-control:focus {
  background: transparent;
  box-shadow: none;
  border-bottom-color: #fff;
  color: #fff;
}

.form-control::placeholder {
  color: rgba(255, 255, 255, 0.6);
}

.input-icon {
  position: absolute;
  top: 10px;
  left: 0;
  color: rgba(255, 255, 255, 0.8);
  font-size: 18px;
}

.btn-login {
  background: linear-gradient(45deg, #4e73df, #36b9cc);
  border: none;
  border-radius: 50px;
  padding: 12px;
  font-weight: 600;
  letter-spacing: 1px;
  width: 100%;
  color: #fff;
  margin-top: 10px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  transition: transform 0.2s;
}

.btn-login:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0,0,0,0.25);
  background: linear-gradient(45deg, #2e59d9, #2c9faf);
  color: #fff;
}

.alert-custom {
  background: rgba(220, 53, 69, 0.8);
  border: none;
  color: #fff;
  border-radius: 10px;
  font-size: 14px;
}

.toggle-pass {
  position: absolute;
  top: 10px;
  right: 0;
  cursor: pointer;
  color: rgba(255, 255, 255, 0.8);
}

</style>
</head>
<body>

  <div class="login-card">
    <div class="login-header">
      <h3>LOGIN</h3>
      <p>Kinclong Laundry Admin</p>
    </div>

    <?php if($err): ?>
    <div class="alert alert-custom text-center mb-4">
      <?= htmlspecialchars($err) ?>
    </div>
    <?php endif; ?>

    <form method="post">
      <div class="form-group">
        <img src="user.png" alt="user" class="input-icon" style="width: 20px; height: 20px; top: 12px;">
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus autocomplete="off">
      </div>

      <div class="form-group">
        <img src="padlock.png" alt="password" class="input-icon" style="width: 20px; height: 20px; top: 12px;">
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        <span class="toggle-pass" onclick="togglePass()">
          <i class="bi bi-eye-slash" id="toggleIcon"></i>
        </span>
      </div>

      <!-- User requested no "Remember Me" or "Forgot Password" -->

      <button class="btn btn-login" name="login">
        Login
      </button>

      <div class="text-center mt-4">
        <a href="../cust/index.php" class="text-white text-decoration-none" style="font-size: 14px; opacity: 0.8;">
          <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
      </div>
    </form>
    
  </div>

<script>
function togglePass(){
  const p = document.getElementById('password');
  const icon = document.getElementById('toggleIcon');
  if(p.type === 'password'){
    p.type = 'text';
    icon.classList.remove('bi-eye-slash');
    icon.classList.add('bi-eye');
  }else{
    p.type = 'password';
    icon.classList.remove('bi-eye');
    icon.classList.add('bi-eye-slash');
  }
}
</script>

</body>
</html>
