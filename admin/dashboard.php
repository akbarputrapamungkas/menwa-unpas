<?php

require '../inc/config.php';

// Ambil data dari tabel kegiatan
$result = mysqli_query($conn, "SELECT * FROM kegiatan");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Kegiatan Menwa UNPAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f8;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            font-weight: bold;
            color: #333;
        }

        .btn-action {
            margin-right: 5px;
        }

        table img {
            border-radius: 8px;
        }

        .table th {
            background-color: #0d6efd;
            color: #fff;
            text-align: center;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Dashboard Kegiatan</h1>
            <a href="../admin_logout.php" class="btn btn-danger">Logout</a>
        </div>

        <a href="tambah_kegiatan.php" class="btn btn-success mb-4">+ Tambah Kegiatan</a>

        <div class="table-responsive">
            <table class="table table-bordered align-middle table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Upload</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_kegiatan']); ?></td>
                            <td style="max-width: 300px;"><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($row['tanggal_upload'])); ?></td>
                            <td>
                                <img src="../uploads/<?= htmlspecialchars($row['gambar']); ?>" width="100" alt="gambar kegiatan">
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm btn-action">Edit</a>
                                <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kegiatan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>