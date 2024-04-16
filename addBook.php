<?php
include 'sql.php';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST["judul"];
    $nama_penerbit = $_POST["nama_penerbit"];
    $tahun_terbit = $_POST["tahun_terbit"];

    // Cek apakah penerbit sudah ada
    $cekPenerbit = $conn->prepare("SELECT id_penerbit FROM penerbit WHERE nama_penerbit = ?");
    $cekPenerbit->bind_param("s", $nama_penerbit);
    $cekPenerbit->execute();
    $hasilPenerbit = $cekPenerbit->get_result();

    if ($hasilPenerbit->num_rows == 0) {
        // Tambahkan penerbit baru jika belum ada
        $tambahPenerbit = $conn->prepare("INSERT INTO penerbit (nama_penerbit) VALUES (?)");
        $tambahPenerbit->bind_param("s", $nama_penerbit);
        $tambahPenerbit->execute();
        $id_penerbit = $tambahPenerbit->insert_id;
        $tambahPenerbit->close();
    } else {
        // Gunakan ID penerbit yang sudah ada
        $row = $hasilPenerbit->fetch_assoc();
        $id_penerbit = $row['id_penerbit'];
    }
    $cekPenerbit->close();

    // Tambahkan buku baru
    $tambahBuku = $conn->prepare("INSERT INTO buku (judul, id_penerbit, tahun_terbit) VALUES (?, ?, ?)");
    $tambahBuku->bind_param("sii", $judul, $id_penerbit, $tahun_terbit);
    $tambahBuku->execute();

    if ($tambahBuku->affected_rows > 0) {
        echo "Buku baru berhasil ditambahkan.";
    } else {
        echo "Error: " . $conn->error;
    }

    $tambahBuku->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventori Buku Perpustakaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Inventori Buku Perpustakaan</h1>
        
        <!-- Form Tambah Buku -->
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Tambah Buku Baru</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="judul">Judul Buku:</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_penerbit">Nama Penerbit:</label>
                        <input type="text" class="form-control" id="nama_penerbit" name="nama_penerbit" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun_terbit">Tahun Terbit:</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambahkan Buku</button>
                </form>
            </div>
        </div>

        <!-- Tombol Kembali ke Halaman Utama -->
        <div class="row justify-content-center mt-3">
            <div class="col-md-6 text-center">
                <form action="index.php">
                    <button type="submit" class="btn btn-secondary">Kembali ke Halaman Utama</button>
                </form>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
