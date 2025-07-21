<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS Penduduk - Lokasi</title>
    <link rel="icon" href="img/graduation.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/map/map.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        /* Agar navbar tetap di atas */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }

        /* Tambahkan margin-top untuk konten agar tidak tertutup oleh navbar */
        .content {
            margin-top: 56px;
        }

        #map {
            height: 55vh;
            width: 100%;
        }

        /* Link navbar berwarna putih */
        .navbar .nav-link {
            color: #ffffff !important;
            transition: color 0.3s; /* Animasi perubahan warna */
        }

        /* Warna hover untuk link */
        .navbar .nav-link:hover {
            color: #c0c0c0 !important; /* Abu-abu saat hover */
        }

        /* Dropdown menu */
        .navbar .dropdown-menu {
            background-color: #161a2d; /* Warna latar dropdown */
        }

        .navbar .dropdown-item {
            color: #ffffff !important; /* Warna putih untuk item dropdown */
        }

        .navbar .dropdown-item:hover {
            color: #4f52ba !important; /* Warna hover untuk item dropdown */
            background-color: transparent; /* Latar tetap transparan */
        }

        /* Gaya tombol login */
        .btn-login {
            background-color: #ffffff;
            color: #000;
            border: 1px solid #ddd;
            width: 120px;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-login:hover {
            background-color: #4f52ba; /* Warna latar saat hover */
            color: #fff; /* Warna teks saat hover */
            border-color: #4f52ba; /* Warna border saat hover */
        }
        /* Mengubah warna teks navbar menjadi putih */
    .navbar .navbar-brand {
        color: #ffffff !important;
    }

    /* Menambahkan efek hover */
    .navbar .navbar-brand:hover {
        color: #c0c0c0 !important; /* Warna abu-abu saat hover */
    }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg" style="background-color:#161a2d;">
    <a class="navbar-brand" href="index.php">
        <img src="img/gps.png" alt="Logo" style="height:30px; width:30px; margin-right:10px;">
        GIS PENDUDUK
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        </ul>
        <form class="form-inline my-2 my-lg-0" action="form_login.php" method="GET">
    <button class="btn my-2 my-sm-0 btn-login" type="submit">Login</button>
</form>

    </div>
</nav>


<div class="content">
    <div id="map"></div>
    <div class="container-fluid  px-0">
        <div class="container">
    <select id="villageSelect" class="form-control my-3">
        <option value="all">Tampilkan Semua</option>
        <option value="Cimencrang">Desa Cimencrang</option>
        <option value="Cisaranten">Desa Cisaranten</option>
        <option value="Rancabolang">Desa Rancabolang</option>
        <option value="Rancamumpang">Desa Rancamumpang</option>
    </select>
</div>
            <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Desa</th>
                    <th>RW</th>
                    <th>SD</th>
                    <th>SMP</th>
                    <th>SMA</th>
                    <th>SMK</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>S3</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                
            </tbody>
        </table>
    </div>
</div>
<script>
    // When the document is fully loaded
    window.onload = function() {
        fetchPendudukData('all'); // Initially fetch all data
    };

    // Add event listener for when the user selects a village
    document.getElementById('villageSelect').addEventListener('change', function() {
        const selectedVillage = this.value;
        fetchPendudukData(selectedVillage);
    });

    // Fetch penduduk data from the backend (read action) with a specific village
// Fetch penduduk data from the backend (read action) with a specific village
function fetchPendudukData(village) {
    fetch('crud.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'read', desa: village }) // Send village name to the backend
    })
    .then(response => response.json())
    .then(data => {
        if (Array.isArray(data)) {
            populateTable(data); // Populate the table with the fetched data
        } else {
            console.log("Error: Invalid data received.");
            populateTable([]); // Call populateTable with an empty array if data is invalid
        }
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        populateTable([]); // Call populateTable with an empty array in case of error
    });
}

// Populate the table with data
function populateTable(data) {
    const tableBody = document.getElementById("tableBody");
    tableBody.innerHTML = ''; // Clear any existing rows

    if (data.length === 0) {
        // If no data is returned, display a message
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td colspan="9" class="text-center">Data tidak ditemukan</td>
        `;
        tableBody.appendChild(tr);
    } else {
        // Loop through the data and insert it into the table
        data.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.desa}</td>
                <td>${row.rw}</td>
                <td>${row.sd}</td>
                <td>${row.smp}</td>
                <td>${row.sma}</td>
                <td>${row.smk}</td>
                <td>${row.s1}</td>
                <td>${row.s2}</td>
                <td>${row.s3}</td>
            `;
            tableBody.appendChild(tr);
        });
    }
}

</script>



    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script Map -->
    <script src="style/map/map.js"></script>
</body>

</html>
