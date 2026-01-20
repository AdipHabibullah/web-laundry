<?php
// layout/header.php - Header Template untuk sisi Admin
// Mengatur sesi, navigasi sidebar, dan topbar.
if(session_status() === PHP_SESSION_NONE) session_start();
// Cek sesi login, jika belum login kembalikan ke halaman login
if(!isset($_SESSION['login'])) header('Location: /laundry_project/auth/login.php');
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>LaundryApp</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
:root{
  --sidebar:#1e293b;
  --primary:#6366f1;
  --bg:#f4f6fb;
}

body{
  background:var(--bg);
  overflow-x:hidden;
  font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
}

/* =====================
   GLOBAL TRANSITION
===================== */
*{
  transition: all 0.45s cubic-bezier(0.4,0,0.2,1);
}

/* =====================
   ANIMATE SPEED (LAMBAT)
===================== */
.animate__animated{
  --animate-duration: 1.0s;
  --animate-delay: 0.1s;
}

/* =====================
   LAYOUT
===================== */
.app{
  display:flex;
  min-height:100vh;
}

/* =====================
   SIDEBAR
===================== */
.sidebar{
  width:250px;
  background:var(--sidebar);
  color:#fff;
  position:fixed;
  inset:0 auto 0 0;
  display: flex;
  flex-direction: column;
  height: 100vh;
  z-index: 100;
  overflow-y: auto;
  overflow-x: hidden;
  transition: width 0.3s ease;
}

.sidebar.minimized {
  width: 80px;
}

.sidebar.minimized h4 span,
.sidebar.minimized a span {
  display: none;
}

.sidebar.minimized h4 {
  font-size: 0;
  text-align: center;
  margin-bottom: 20px;
}

.sidebar.minimized h4 i {
  font-size: 1.5rem;
}

.sidebar.minimized a {
  justify-content: center;
  padding: 12px;
}

.sidebar.minimized a i {
  font-size: 1.25rem;
  margin: 0;
}

.sidebar.minimized .sidebar-header {
  flex-direction: column;
  gap: 10px;
  padding-left: 0 !important;
  padding-right: 0 !important;
  align-items: center;
}

.sidebar.minimized h4 {
  margin-bottom: 0;
}

/* Toggle Button */
.sidebar-toggle {
  width: 30px;
  height: 30px;
  background: rgba(255, 255, 255, 0.1);
  color: #fff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: transform 0.3s, background 0.3s;
}

.sidebar-toggle:hover {
  background: rgba(255, 255, 255, 0.2);
}

.sidebar.minimized .sidebar-toggle {
  transform: rotate(180deg);
  margin: 0 auto; /* Center when minimized */
}


.sidebar h4{
  font-weight:700;
  margin-bottom:28px;
}

.sidebar a{
  display:flex;
  align-items:center;
  gap:10px;
  padding:12px 16px;
  color:#cbd5f5;
  text-decoration:none;
  border-radius:14px;
  margin-bottom:8px;
}

.sidebar a:hover,
.sidebar a.active{
  background:rgba(99,102,241,.25);
  color:#fff;
  transform: translateX(8px);
}

/* =====================
   MAIN
===================== */
.main{
  margin-left:250px;
  width:calc(100% - 250px);
  transition: margin-left 0.3s ease, width 0.3s ease;
}

.main.minimized {
  margin-left: 80px;
  width: calc(100% - 80px);
}


/* =====================
   TOPBAR
===================== */
.topbar{
  background:#fff;
  padding:16px 28px;
  box-shadow:0 12px 30px rgba(0,0,0,.08);
  display:flex;
  justify-content:space-between;
  align-items:center;
}

/* =====================
   CONTENT
===================== */
.content{
  padding:30px;
}
</style>
</head>

<body>

<div class="app">

<!-- SIDEBAR -->
<!-- SIDEBAR -->
<div class="sidebar animate__animated animate__fadeInLeft" id="sidebar">
  <div class="sidebar-header d-flex align-items-center justify-content-between mb-4 mt-3 px-3">
    <h4 class="mb-0 text-nowrap overflow-hidden">
      <i class="bi bi-droplet-half text-primary"></i> <span>Kinclong</span>
    </h4>
    <div class="sidebar-toggle" id="sidebarToggle">
      <i class="bi bi-chevron-left"></i>
    </div>
  </div>

  <div class="px-2 d-flex flex-column flex-grow-1">
      <a href="/laundry_project/index.php" title="Dashboard">
        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
      </a>
      <a href="/laundry_project/pelanggan/index.php" title="Pelanggan">
        <i class="bi bi-people"></i> <span>Pelanggan</span>
      </a>
      <a href="/laundry_project/layanan/index.php" title="Layanan">
        <i class="bi bi-basket"></i> <span>Layanan</span>
      </a>
      <a href="/laundry_project/transaksi/index.php" title="Transaksi">
        <i class="bi bi-receipt"></i> <span>Transaksi</span>
      </a>
      <a href="/laundry_project/pembayaran/index.php" title="Pembayaran">
        <i class="bi bi-cash-stack"></i> <span>Pembayaran</span>
      </a>
      <a href="/laundry_project/laporan/index.php" title="Laporan">
        <i class="bi bi-graph-up"></i> <span>Laporan</span>
      </a>

      <?php if($_SESSION['user']['role']==='admin'): ?>
        <a href="/laundry_project/users/index.php" title="Users">
          <i class="bi bi-person-gear"></i> <span>Users</span>
        </a>
      <?php endif; ?>
      
      <div class="mt-auto"> <!-- Spacer to push logout to bottom -->
        <a href="/laundry_project/auth/logout.php" onclick="return confirm('Apakah anda yakin ingin logout?');" class="text-danger" title="Logout">
          <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
        </a>
      </div>
  </div>
</div>

<!-- MAIN -->
<div class="main" id="mainContent">

<script>
  // Script untuk mengatur toggle (buka/tutup) sidebar
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const toggleBtn = document.getElementById('sidebarToggle');
  
  // Cek status sidebar dari local storage browser agar preferensi tersimpan
  const isMinimized = localStorage.getItem('sidebarMinimized') === 'true';
  if (isMinimized) {
    sidebar.classList.add('minimized');
    mainContent.classList.add('minimized');
  }

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('minimized');
    mainContent.classList.toggle('minimized');
    
    // Simpan status ke local storage
    localStorage.setItem('sidebarMinimized', sidebar.classList.contains('minimized'));
  });
</script>

<!-- TOPBAR -->
<div class="topbar animate__animated animate__fadeInDown">
  <div class="fw-semibold">
    Halo, <?= htmlspecialchars($_SESSION['user']['nama']) ?>
  </div>

</div>

<!-- CONTENT -->
<div class="content animate__animated animate__fadeInUp">
