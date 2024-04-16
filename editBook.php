<?php
include 'sql.php';

// Cek apakah ID buku diterima
if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Ambil data buku dari database
    $sql = "SELECT buku.id_buku, buku.judul, penerbit.nama_penerbit, buku.tahun_terbit FROM buku INNER JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit WHERE buku.id_buku = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_buku);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();

    // Jika form disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $judul_baru = $_POST["judul"];
        $nama_penerbit_baru = $_POST["nama_penerbit"];
        $tahun_terbit_baru = $_POST["tahun_terbit"];

        // Cek apakah penerbit baru sudah ada
        $cekPenerbit = $conn->prepare("SELECT id_penerbit FROM penerbit WHERE nama_penerbit = ?");
        $cekPenerbit->bind_param("s", $nama_penerbit_baru);
        $cekPenerbit->execute();
        $hasilPenerbit = $cekPenerbit->get_result();

        if ($hasilPenerbit->num_rows == 0) {
            // Tambahkan penerbit baru jika belum ada
            $tambahPenerbit = $conn->prepare("INSERT INTO penerbit (nama_penerbit) VALUES (?)");
            $tambahPenerbit->bind_param("s", $nama_penerbit_baru);
            $tambahPenerbit->execute();
            $id_penerbit_baru = $tambahPenerbit->insert_id;
            $tambahPenerbit->close();
        } else {
            // Gunakan ID penerbit yang sudah ada
            $row = $hasilPenerbit->fetch_assoc();
            $id_penerbit_baru = $row['id_penerbit'];
        }
        $cekPenerbit->close();

        // Update data buku
        $updateBuku = $conn->prepare("UPDATE buku SET judul = ?, id_penerbit = ?, tahun_terbit = ? WHERE id_buku = ?");
        $updateBuku->bind_param("siii", $judul_baru, $id_penerbit_baru, $tahun_terbit_baru, $id_buku);
        $updateBuku->execute();

        if ($updateBuku->affected_rows > 0) {
            echo "Data buku berhasil diubah.";
        } else {
            echo "Tidak ada perubahan data atau terjadi kesalahan.";
        }

        $updateBuku->close();
    }
}

// Form untuk mengedit buku
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Buku</h1>
        
        <!-- Form Edit Buku -->
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <form method="post">
                    <div class="form-group">
                        <label for="judul">Judul:</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $buku['judul']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_penerbit">Penerbit:</label>
                        <input type="text" class="form-control" id="nama_penerbit" name="nama_penerbit" value="<?php echo $buku['nama_penerbit']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun_terbit">Tahun Terbit:</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?php echo $buku['tahun_terbit']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
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
