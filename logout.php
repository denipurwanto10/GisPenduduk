<?php
// Mulai session
session_start();

// Hapus semua session untuk logout
session_unset();
session_destroy();

// Set pesan notifikasi logout berhasil
$_SESSION['message'] = 'Logout berhasil!';

// Arahkan pengguna ke halaman login atau halaman lain
header("Location: form_login.php");
exit();
?>
