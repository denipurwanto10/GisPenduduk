<?php
// Mulai session
session_start();

// Cek apakah user sudah login (misalnya, periksa apakah 'user_id' ada di session)
if (!isset($_SESSION['user_id'])) {
    // Jika session 'user_id' tidak ada, arahkan ke halaman login
    header("Location: form_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS Penduduk - Lokasi</title>
    <link rel="icon" href="img/graduation.png" type="image/png">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/map/map.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>
<aside class="sidebar">
  <div class="sidebar-header">
    <img src="img/gps.png" alt="logo" />
    <h2>GIS PENDUDUK</h2>
  </div>
  <ul class="sidebar-links">
    <hr>
    <li>
      <a href="lokasi.php">
        <span class="material-symbols-outlined">
          <i class="fas fa-map-marker-alt"></i>&nbsp; Lokasi
        </span>
      </a>
    </li>
    <li>
      <a href="penduduk.php">
        <span class="material-symbols-outlined">
          <i class="fas fa-user"></i>&nbsp; Penduduk
        </span>
      </a>
    </li>
    <hr class="menu-divider" />
    <li>
      <a href="info.php">
        <span class="material-symbols-outlined">
          <i class="fas fa-info-circle"></i>&nbsp; Info
        </span>
      </a>
    </li>
    <li>
      <a href="logout.php">
        <span class="material-symbols-outlined">
          <i class="fas fa-power-off"></i>&nbsp; Logout
        </span>
      </a>
    </li>
  </ul>
</aside>


    <div class="content">
        <div id="map"></div>
    </div>



    <!-- Script Map -->
    <script src="style/map/map.js"></script>
    <script src="style/js/bootstrap.bundle.min.js"></script>
</body>

</html>