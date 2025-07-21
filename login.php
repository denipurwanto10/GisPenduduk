<?php
// Mulai session untuk menyimpan status login
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gis_penduduk";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa apakah ada kesalahan dalam koneksi
if ($conn->connect_error) {
    $_SESSION['error_message'] = "Terjadi kesalahan dalam koneksi database.";
    header("Location: login.php");
    exit();
}

// Periksa apakah form login disubmit
if (isset($_POST['submit'])) {
    // Ambil username dan password dari form
    $user_username = $_POST['username'];
    $user_password = $_POST['password'];

    // Persiapkan query untuk mencegah SQL injection
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user_username);
    $stmt->execute();
    $stmt->store_result();

    // Periksa apakah username ditemukan
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $stored_password);
        $stmt->fetch();

        // Bandingkan password yang dimasukkan dengan password yang ada di database
        if ($user_password == $stored_password) {
            // Jika password cocok, login berhasil
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;

            $_SESSION['success_message'] = "Login berhasil, selamat datang, " . $username . "!";
            header("Location: lokasi.php"); // Arahkan ke halaman dashboard
            exit();
        } else {
            // Jika password salah, tampilkan pesan error
            $_SESSION['error_message'] = "Password yang Anda masukkan salah.";
            header("Location: form_login.php"); // Arahkan kembali ke halaman login
            exit();
        }
    } else {
        // Jika username tidak ditemukan, tampilkan pesan error
        $_SESSION['error_message'] = "Username yang Anda masukkan tidak ditemukan.";
        header("Location: form_login.php"); // Arahkan kembali ke halaman login
        exit();
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>
