<?php
require '../inc/config.php';

$pesan = '';

if (isset($_POST["submit"])) {
    // Ambil data dari form
    $nama_kegiatan = htmlspecialchars($_POST["nama_kegiatan"]);
    $tanggal = $_POST["tanggal"];
    $deskripsi = htmlspecialchars($_POST["deskripsi"]);

    // Proses upload gambar
    $gambar = $_FILES["gambar"]["name"];
    $tmpName = $_FILES["gambar"]["tmp_name"];
    $ekstensiGambar = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
    $gambarBaru = uniqid() . '.' . $ekstensiGambar;

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($ekstensiGambar, $allowed)) {
        move_uploaded_file($tmpName, '../uploads/' . $gambarBaru);

        // Simpan ke database
        $query = "INSERT INTO kegiatan (nama_kegiatan, tanggal_kegiatan, deskripsi, gambar)
                  VALUES ('$nama_kegiatan', '$tanggal', '$deskripsi', '$gambarBaru')";

        if (mysqli_query($conn, $query)) {
            $pesan = '<div class="alert alert-success">Kegiatan berhasil ditambahkan!</div>';
        } else {
            $pesan = '<div class="alert alert-danger">Gagal menyimpan data ke database.</div>';
        }
    } else {
        $pesan = '<div class="alert alert-warning">Format gambar tidak valid (hanya jpg, jpeg, png, webp).</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Kegiatan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="mb-4">Tambah Kegiatan Menwa UNPAS</h2>

            <?= $pesan; ?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Kegiatan</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Upload Gambar</label>
                    <input class="form-control" type="file" id="gambar" name="gambar" accept=".jpg,.jpeg,.png,.webp" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Tambah Kegiatan</button>
                <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>