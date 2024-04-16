<?php
include 'sql.php';

// Mengambil data buku dari database
$sql = "SELECT buku.id_buku, buku.judul, penerbit.nama_penerbit, buku.tahun_terbit FROM buku INNER JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventori Buku Perpustakaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            margin-bottom: 30px;
            text-align: center;
        }
        h2{
            margin-bottom: 30px;
            text-align: center;}
        th{
            text-align: center;
        }
        td{
            text-align: center;
        }
        .navbar-custom {
            background-color: #007bff;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            color: rgba(255,255,255,.8);
        }
        .navbar-custom .navbar-nav .nav-link {
            color: rgba(255,255,255,.5);
        }
        .navbar-custom .navbar-nav .nav-link:hover {
            color: rgba(255,255,255,.75);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Inventori Buku Perpustakaan</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="addBook.php">Tambah Buku</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Tabel Buku -->
    <div class="container mt-4">
        <h2>Daftar Detail Buku</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_buku']; ?></td>
                    <td><?php echo $row['judul']; ?></td>
                    <td><?php echo $row['nama_penerbit']; ?></td>
                    <td><?php echo $row['tahun_terbit']; ?></td>
                    <td class="action-links">
                        <a href="editBook.php?id=<?php echo $row['id_buku']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="deleteBook.php?id=<?php echo $row['id_buku']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="row justify-content-center mt-3">
            <div class="col-md-6 text-center">
                <form action="index.php">
                    <button type="submit" class="btn btn-secondary">Kembali ke Halaman Utama</button>
                </form>
            </div>
        </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
