<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "perpustakaan";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>