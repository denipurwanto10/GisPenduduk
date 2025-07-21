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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
.content {
    padding-top: 30px; /* Adjust the padding as needed */
    padding-left: 30px; /* Add space on the left */
    padding-right: 40px; /* Add space on the right */
}


        .resized-image {
            width: 300px; /* Set the image width */
            height: auto;
            margin-top: 20px; /* Adjust margin to move the image down */
        }

        .description-text {
            margin-top: 20px; /* Add space between image and text */
            font-size: 16px; /* Set font size */
            line-height: 1.6; /* Line height for readability */
            color: #333; /* Set text color */
        }
    </style>
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

<div class="container mt-4">
    <!-- Card untuk Gambar dan Deskripsi -->
    <div class="card shadow-lg">
        <div class="card-body">
            <!-- Gambar -->
            <div class="text-center mb-2">
            <img src="img/t.png" alt="gambar t" class="img-fluid rounded" style="max-width: 42%; height: auto;" />  
            </div>

            <!-- Deskripsi -->
            <div class="text-center mb-3">
                <p class="description-text text-muted">
                    Sistem Informasi Penduduk Bidang Pendidikan adalah sistem yang mengelola data terkait penduduk dalam konteks pendidikan untuk mendukung perencanaan dan kebijakan pendidikan. Sistem ini mencakup informasi tentang pendidikan di kecamatan gedebage yang dialokasikan. Data yang terkelola dengan baik mempermudah pengambilan keputusan terkait pengelolaan pendidikan, seperti data pendidikan di masing masing desa.
                </p>
                <p class="description-text text-muted">
                    Manfaat utama dari sistem ini adalah meningkatkan efisiensi administrasi pendidikan, memungkinkan analisis kebutuhan pendidikan yang lebih tepat, serta memudahkan perencanaan dan evaluasi kebijakan. Dengan teknologi seperti database, sistem ini menyimpan dan mengakses data secara aman dan efisien, mendukung perbaikan kualitas pendidikan secara keseluruhan.
                </p>
            </div>
        </div>
    </div>
</div>


</body>

</html>
