<?php
include 'sql.php';

// Cek apakah ID buku diterima
if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Hapus data buku dari database
    $sql = "DELETE FROM buku WHERE id_buku = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_buku);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Buku berhasil dihapus.";
    } else {
        echo "Tidak ada buku yang dihapus atau terjadi kesalahan.";
    }
}

// Redirect ke halaman utama
header('Location: index.php');
exit;