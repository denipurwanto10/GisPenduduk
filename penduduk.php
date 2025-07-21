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
    <title>GIS Penduduk - Data Penduduk</title>
    <link rel="icon" href="img/graduation.png" type="image/png">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/map/map.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
       .sidebar {
    width: 250px;
    top: 0;
    left: 0;
    height: 100vh;
    width: 80px;
    display: flex;
    overflow-x: hidden;
    flex-direction: column;
    background: #161a2d;
    padding: 25px 20px;
    transition: all 0.4s ease;
}



.sidebar:hover {
    width: 260px;
}

.sidebar .sidebar-header {
    display: flex;
    align-items: center;
}

.sidebar .sidebar-header img {
    width: 42px;
    border-radius: 50%;
}

.sidebar .sidebar-header h2 {
    color: #fff;
    font-size: 1.25rem;
    font-weight: 600;
    white-space: nowrap;
    margin-left: 23px;
}

.sidebar-links h4 {
    color: #fff;
    font-weight: 500;
    white-space: nowrap;
    margin: 10px 0;
    position: relative;
}

.sidebar-links h4 span {
    opacity: 0;
}

.sidebar:hover .sidebar-links h4 span {
    opacity: 1;
}

.sidebar-links .menu-separator {
    position: absolute;
    left: 0;
    top: 50%;
    width: 100%;
    height: 1px;
    transform: scaleX(1);
    transform: translateY(-50%);
    background: #4f52ba;
    transform-origin: right;
    transition-delay: 0.2s;
}

.sidebar:hover .sidebar-links .menu-separator {
    transition-delay: 0s;
    transform: scaleX(0);
}

.sidebar-links {
    list-style: none;
    margin-top: 20px;
    height: 80%;
    overflow-y: auto;
    scrollbar-width: none;
}

.sidebar-links::-webkit-scrollbar {
    display: none;
}

.sidebar-links li a {
    display: flex;
    align-items: center;
    gap: 0 20px;
    color: #fff;
    font-weight: 500;
    white-space: nowrap;
    padding: 15px 10px;
    text-decoration: none;
    transition: 0.2s ease;
}

.sidebar-links li a:hover {
    color: #161a2d;
    background: #fff;
    border-radius: 4px;
}

.user-account {
    margin-top: auto;
    padding: 12px 10px;
    margin-left: -10px;
}

.user-profile {
    display: flex;
    align-items: center;
    color: #161a2d;
}

.user-profile img {
    width: 42px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.user-profile h3 {
    font-size: 1rem;
    font-weight: 600;
}

.user-profile span {
    font-size: 0.775rem;
    font-weight: 600;
}

.user-detail {
    margin-left: 23px;
    white-space: nowrap;
}

.sidebar:hover .user-account {
    background: #fff;
    border-radius: 4px;
}
.menu-divider {
    border: none;
    height: 1px;
    background: #4f52ba; /* Match your theme color */
    margin: 10px 0; /* Adjust spacing */
  }
        /* Main content styling */
        .content {
            margin-left: 0px;
            padding: 50px;
        }

        /* Table styling */
        .table-container {
            margin-top: 20px;
        }

        /* Button styling */
        .btn {
            margin-right: 10px;
        }
    </style>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
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

        <!-- Dropdown for selecting village -->
        <!-- <label for="villageSelect">Pilih Desa:</label>
        <select id="villageSelect" class="form-select" style="width: 200px; display: inline-block;">
            <option value="all">Semua Desa</option>
        </select> -->

        <!-- Buttons for Add, Edit, Delete -->
        

    <!-- Table for displaying data penduduk -->
    <style>
    .table {
        border-collapse: collapse; /* Ensures borders are collapsed into a single border */
    }
    
    .table th, .table td {
        border: none; /* Removes any visible border on th and td */
    }
    
    .table-container {
        border: none; /* Ensures no external border */
    }
    
    .table-striped tbody tr:nth-child(odd) {
        background-color: transparent; /* Keeps the striping but ensures no borders */
    }
    
    /* Optional: Add a light border only to the rows if desired */
    .table td {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1); /* Light border to create a subtle line effect */
    }
    
    .table th {
        border-bottom: 2px solid #dee2e6; /* Keeps the bottom border for the header */
    }

    .table-bordered {
        border: none; /* Ensures there is no border on the table */
    }
</style>

<div class="container mt-4">
    <!-- Card untuk Search, Table, dan Tombol -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="card-title mb-0">Data Penduduk</h5>
        </div>
        <div class="card-body">
            <!-- Pencarian -->
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan Desa atau RW">
            </div>

            <!-- Tabel Data -->
            <div class="table-responsive mb-3">
                <table class="table table-bordered table-striped">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Kode</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Desa</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">RW</th>
                            <th colspan="7">Pendidikan</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Aksi</th>
                        </tr>
                        <tr>
                            <th>SD</th>
                            <th>SMP</th>
                            <th>SMA</th>
                            <th>SMK</th>
                            <th>S1</th>
                            <th>S2</th>
                            <th>S3</th>
                        </tr>
                    </thead>
                    <tbody id="pendudukTableBody">
                        <!-- Data will be inserted here by JavaScript -->
                    </tbody>
                    <tfoot style="background-color:white;">
                        <tr id="noDataRow" style="display: none; border: none;">
                            <td colspan="11" style="text-align: center; color: gray;">Data tidak ditemukan</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Pagination -->
            <div id="paginationContainer" class="d-flex justify-content-center mt-3">
                <!-- Pagination buttons will be inserted here by JavaScript -->
            </div>

            <!-- Tombol Tambah dan Laporan -->
            <div class="d-flex justify-content-between mt-3">
                <button id="addButton" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Tambah</button>
                <button id="generateReportButton" class="btn btn-info">Laporan</button>
            </div>
        </div>
    </div>
</div>
</div>




    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addResidentForm">
                    <div class="mb-3">
                            <label for="addKode" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="addKode" required>
                        </div>
                    <div class="mb-3">
                            <label for="addVillage" class="form-label">Desa</label>
                            <select class="form-select" id="addVillage" required>
                            <option value="Cimencrang">Cimencrang</option>
        <option value="Cisaranten">Cisaranten</option>
        <option value="Rancabolang">Rancabolang</option>
        <option value="Rancamumpang">Rancamumpang</option>
                            </select>
                        </div>
                    <div class="mb-3">
                            <label for="addRW" class="form-label">RW</label>
                            <input type="text" class="form-control" id="addRW" required>
                        </div>
                        <div class="mb-3">
                            <label for="addSD" class="form-label">SD</label>
                            <input type="text" class="form-control" id="addSD" required>
                        </div>
                        <div class="mb-3">
                            <label for="addSMP" class="form-label">SMP</label>
                            <input type="text" class="form-control" id="addSMP" required>
                        </div>
                        <div class="mb-3">
                            <label for="addSMA" class="form-label">SMA</label>
                            <input type="text" class="form-control" id="addSMA">
                        </div>
                        <div class="mb-3">
                            <label for="addSMK" class="form-label">SMK</label>
                            <input type="text" class="form-control" id="addSMK">
                        </div>
                        <div class="mb-3">
                            <label for="addS1" class="form-label">S1</label>
                            <input type="text" class="form-control" id="addS1">
                        </div>
                        <div class="mb-3">
                            <label for="addS2" class="form-label">S2</label>
                            <input type="text" class="form-control" id="addS2">
                        </div>
                        <div class="mb-3">
                            <label for="addS3" class="form-label">S3</label>
                            <input type="text" class="form-control" id="addS3">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" id="saveAddButton">Simpan</button>
                </div>
            </div>
        </div>
    </div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editResidentForm">
                    <div class="mb-3">
                        <label for="editKode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="editKode" required disabled>
                    </div>
                    <div class="mb-3">
                        <label for="editVillage" class="form-label">Desa</label>
                        <select class="form-select" id="editVillage" required >
                            <option value="Cimencrang">Cimencrang</option>
                            <option value="Cisaranten">Cisaranten</option>
                            <option value="Rancabolang">Rancabolang</option>
                            <option value="Rancamumpang">Rancamumpang</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editRW" class="form-label">RW</label>
                        <input type="text" class="form-control" id="editRW" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSD" class="form-label">SD</label>
                        <input type="text" class="form-control" id="editSD" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSMP" class="form-label">SMP</label>
                        <input type="text" class="form-control" id="editSMP" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSMA" class="form-label">SMA</label>
                        <input type="text" class="form-control" id="editSMA">
                    </div>
                    <div class="mb-3">
                        <label for="editSMK" class="form-label">SMK</label>
                        <input type="text" class="form-control" id="editSMK">
                    </div>
                    <div class="mb-3">
                        <label for="editS1" class="form-label">S1</label>
                        <input type="text" class="form-control" id="editS1">
                    </div>
                    <div class="mb-3">
                        <label for="editS2" class="form-label">S2</label>
                        <input type="text" class="form-control" id="editS2">
                    </div>
                    <div class="mb-3">
                        <label for="editS3" class="form-label">S3</label>
                        <input type="text" class="form-control" id="editS3">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning" id="saveEditButton">Ubah</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include SheetJS library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

<!-- JavaScript for CRUD Operations -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Function to fetch data and display it in the table
    function fetchData() {
        let data = { action: 'read' };

        fetch('crud.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                let tableBody = document.querySelector("#pendudukTableBody");
                tableBody.innerHTML = ''; // Clear existing rows

                data.forEach(item => {
                    let row = document.createElement("tr");

                    row.innerHTML = `
                        <td>${item.kode}</td>
                        <td>${item.desa}</td>
                        <td>${item.rw}</td>
                        <td>${item.sd}</td>
                        <td>${item.smp}</td>
                        <td>${item.sma}</td>
                        <td>${item.smk}</td>
                        <td>${item.s1}</td>
                        <td>${item.s2}</td>
                        <td>${item.s3}</td>
                        <td style="text-align: center;">
                            <button class="btn btn-warning btn-sm editButton" data-kode="${item.kode}">Edit</button>
                            <button class="btn btn-danger btn-sm deleteButton" data-kode="${item.kode}">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Error fetching data:', error));
    }

    // Call fetchData to load the data when the page is loaded
    fetchData();
// Function to add new data
document.getElementById("saveAddButton").addEventListener("click", function() {
    const kode = document.getElementById("addKode").value;
    const desa = document.getElementById("addVillage").value;
    const rw = document.getElementById("addRW").value;
    const sd = document.getElementById("addSD").value;
    const smp = document.getElementById("addSMP").value;
    const sma = document.getElementById("addSMA").value;
    const smk = document.getElementById("addSMK").value;
    const s1 = document.getElementById("addS1").value;
    const s2 = document.getElementById("addS2").value;
    const s3 = document.getElementById("addS3").value;

    if (kode && desa && rw && sd && smp) {
        fetch('crud.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'create',
                kode,
                desa,
                rw,
                sd,
                smp,
                sma,
                smk,
                s1,
                s2,
                s3
            })
        })
        .then(response => response.json())
        .then(data => {
            // Check if the response indicates success
            if (data.status === 'success') {
                alert('Data berhasil ditambahkan');
                // Refresh the page and close the modal
                location.reload();
                $('#addModal').modal('hide');
            } else {
                // Show an alert if the server returns an error message
                alert(data.message || 'An error occurred while adding data');
            }
        })
        .catch(error => {
            console.error('Error adding data:', error);
            alert('An unexpected error occurred. Please try again later.');
        });
    } else {
        alert("Harap isi semua input.");
    }
});

    // Edit button handler
    document.querySelector("#pendudukTableBody").addEventListener("click", function(e) {
        if (e.target && e.target.classList.contains("editButton")) {
            let kode = e.target.getAttribute("data-kode");
            let row = e.target.closest("tr");
            let desa = row.children[1].innerText;
            let rw = row.children[2].innerText;
            let sd = row.children[3].innerText;
            let smp = row.children[4].innerText;
            let sma = row.children[5].innerText;
            let smk = row.children[6].innerText;
            let s1 = row.children[7].innerText;
            let s2 = row.children[8].innerText;
            let s3 = row.children[9].innerText;

            // Populate the edit modal with the current data
            document.getElementById("editKode").value = kode;
            document.getElementById("editVillage").value = desa;
            document.getElementById("editRW").value = rw;
            document.getElementById("editSD").value = sd;
            document.getElementById("editSMP").value = smp;
            document.getElementById("editSMA").value = sma;
            document.getElementById("editSMK").value = smk;
            document.getElementById("editS1").value = s1;
            document.getElementById("editS2").value = s2;
            document.getElementById("editS3").value = s3;

            // Show the modal
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }
    });

    // Save changes after editing a record
    document.getElementById("saveEditButton").addEventListener("click", function() {
        let kode = document.getElementById("editKode").value;
        let desa = document.getElementById("editVillage").value;
        let rw = document.getElementById("editRW").value;
        let sd = document.getElementById("editSD").value;
        let smp = document.getElementById("editSMP").value;
        let sma = document.getElementById("editSMA").value;
        let smk = document.getElementById("editSMK").value;
        let s1 = document.getElementById("editS1").value;
        let s2 = document.getElementById("editS2").value;
        let s3 = document.getElementById("editS3").value;

        let updatedData = {
            action: 'edit',
            kode: kode,
            desa: desa,
            rw: parseInt(rw, 10),
            sd: parseInt(sd, 10),
            smp: parseInt(smp, 10),
            sma: parseInt(sma, 10),
            smk: parseInt(smk, 10),
            s1: parseInt(s1, 10),
            s2: parseInt(s2, 10),
            s3: parseInt(s3, 10)
        };

        fetch('crud.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(updatedData)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                location.reload(); // Refresh to see the updated data
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Delete button handler
    document.querySelector("#pendudukTableBody").addEventListener("click", function(e) {
        if (e.target && e.target.classList.contains("deleteButton")) {
            let kode = e.target.getAttribute("data-kode");
            let confirmDelete = confirm("Apa anda yakin ingin menghapus data ini?");

            if (confirmDelete) {
                let data = { action: 'delete', kode: kode };

                fetch('crud.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === "success") {
                        location.reload(); // Refresh the table
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    });

    // Generate Report Button
    document.getElementById("generateReportButton").addEventListener("click", function() {
        let rows = document.querySelectorAll("#pendudukTableBody tr");
        let reportData = [];

        // Add the table headers as the first row in the CSV
        let headers = [
            'Kode', 'Desa', 'RW', 'SD', 'SMP', 'SMA', 'SMK', 'S1', 'S2', 'S3'
        ];
        reportData.push(headers.join(','));

        // Loop through table rows to add data to the report
        rows.forEach(row => {
            let cells = row.querySelectorAll("td");
            let rowData = [];
            
            cells.forEach(cell => {
                rowData.push(cell.innerText || cell.textContent);
            });
            
            reportData.push(rowData.join(','));
        });

        // Create the CSV content
        let csvContent = reportData.join('\n');

        // Create a Blob and generate a download link
        let blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        let link = document.createElement('a');
        if (link.download !== undefined) {
            let fileName = 'penduduk_report.csv';
            link.setAttribute('href', URL.createObjectURL(blob));
            link.setAttribute('download', fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    });
});
document.getElementById('searchInput').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#pendudukTableBody tr');
    let matchFound = false; // Flag untuk mengecek kecocokan

    tableRows.forEach(row => {
        const desaCell = row.cells[1]?.textContent.toLowerCase() || '';
        const rwCell = row.cells[2]?.textContent.toLowerCase() || '';
        
        if (desaCell.includes(searchValue) || rwCell.includes(searchValue)) {
            row.style.display = ''; // Tampilkan baris
            matchFound = true; // Ada kecocokan
        } else {
            row.style.display = 'none'; // Sembunyikan baris
        }
    });

    // Tampilkan atau sembunyikan baris "Data tidak ditemukan"
    const noDataRow = document.getElementById('noDataRow');
    noDataRow.style.display = matchFound ? 'none' : '';
});

</script>

    
</body>

</html>
