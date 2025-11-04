<?php
// Pengaturan Koneksi Database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'rental_kendaraan'; // Nama database dari SQL Anda

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>