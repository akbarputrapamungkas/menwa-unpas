<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['username'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require '../inc/config.php';

$kegiatan = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY tanggal_upload DESC");

$pendaftar = mysqli_query($conn, "SELECT * FROM pendaftar ORDER BY waktu_mendaftar DESC");

function formatWhatsAppLink($nomorWa)
{
    $cleanedNomorWa = preg_replace('/[^0-9]/', '', $nomorWa);
    if (substr($cleanedNomorWa, 0, 1) === '0') {
        $cleanedNomorWa = '62' . substr($cleanedNomorWa, 1);
    }
    if (substr($cleanedNomorWa, 0, 2) !== '62') {
        $cleanedNomorWa = '62' . $cleanedNomorWa;
    }
    $cleanedNomorWa = ltrim($cleanedNomorWa, '+');

    return "https://wa.me/" . htmlspecialchars($cleanedNomorWa);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Menwa Unpas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --primary-menwa: #7e22ce;
            --accent-color: #9b4bd6;
            --light-bg: #f5edfc;
            --dark-bg-custom: #5f1a9b;
            --text-color: #333;
            --white: #ffffff;
            --gray-light: #f4f6f8;
        }

        body {
            font-family: 'Rubik', sans-serif;
            background-color: var(--gray-light);
            color: var(--text-color);
        }

        .container {
            background: var(--white);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            margin-bottom: 30px;
        }

        h1,
        h2 {
            font-weight: bold;
            color: var(--primary-menwa);
        }

        .btn-action {
            margin-right: 5px;
        }

        .btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }

        .btn-danger:hover {
            background-color: #c82333 !important;
            border-color: #bd2130 !important;
        }

        .btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        .btn-success:hover {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
        }

        .btn-warning {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
            color: #212529 !important;
        }

        .btn-warning:hover {
            background-color: #e0a800 !important;
            border-color: #d39e00 !important;
        }

        .btn-whatsapp {
            background-color: #25D366;
            border-color: #25D366;
            color: var(--white);
        }

        .btn-whatsapp:hover {
            background-color: #128C7E;
            border-color: #128C7E;
        }


        table img {
            border-radius: 8px;
            object-fit: cover;
            width: 80px;
            height: 60px;
        }

        .table th {
            background-color: var(--primary-menwa);
            color: var(--white);
            text-align: center;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }

        hr {
            margin: 40px 0;
            border-top: 1px solid #dee2e6;
        }

        .table .btn {
            font-size: 0.85rem;
            padding: 0.3rem 0.6rem;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Dashboard Admin <small class="text-muted">(<?= htmlspecialchars($_SESSION['username']); ?>)</small></h1>
            <a href="../logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        </div>

        <h2 class="mt-5 mb-4">Daftar Kegiatan</h2>
        <a href="tambah_kegiatan.php" class="btn btn-success mb-4"><i class="fas fa-plus-circle me-2"></i> Tambah Kegiatan</a>

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
                    <?php if (mysqli_num_rows($kegiatan) > 0): ?>
                        <?php $no_kegiatan = 1; ?>
                        <?php while ($row_kegiatan = mysqli_fetch_assoc($kegiatan)) : ?>
                            <tr>
                                <td><?= $no_kegiatan++; ?></td>
                                <td><?= htmlspecialchars($row_kegiatan['nama_kegiatan']); ?></td>
                                <td class="text-start" style="max-width: 350px;"><?= nl2br(htmlspecialchars(substr($row_kegiatan['deskripsi'], 0, 150))) . (strlen($row_kegiatan['deskripsi']) > 150 ? '...' : ''); ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($row_kegiatan['tanggal_upload'])); ?></td>
                                <td>
                                    <?php if (!empty($row_kegiatan['gambar']) && file_exists('../uploads/' . $row_kegiatan['gambar'])): ?>
                                        <img src="../uploads/<?= htmlspecialchars($row_kegiatan['gambar']); ?>" alt="gambar kegiatan" class="img-fluid">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada gambar</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $row_kegiatan['id']; ?>" class="btn btn-warning btn-sm btn-action"><i class="fas fa-edit me-1"></i> Edit</a>
                                    <a href="hapus.php?id=<?= $row_kegiatan['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kegiatan ini?')"><i class="fas fa-trash-alt me-1"></i> Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data kegiatan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <hr>

        <h2 class="mb-4">Data Pendaftar</h2>
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>No WhatsApp</th>
                        <th>Waktu Pendaftaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($pendaftar) > 0): ?>
                        <?php $no_pendaftar = 1; ?>
                        <?php while ($row_pendaftar = mysqli_fetch_assoc($pendaftar)) : ?>
                            <tr>
                                <td><?= $no_pendaftar++; ?></td>
                                <td><?= htmlspecialchars($row_pendaftar['nama']); ?></td>
                                <td><?= htmlspecialchars($row_pendaftar['jurusan']); ?></td>
                                <td>
                                    <?php
                                    $rawNomorWa = $row_pendaftar['nomor_wa'];
                                    $waLink = formatWhatsAppLink($rawNomorWa);
                                    ?>
                                    <a href="<?= $waLink; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp btn-sm">
                                        <i class="fab fa-whatsapp me-1"></i> <?= htmlspecialchars($rawNomorWa); ?>
                                    </a>
                                </td>
                                <td><?= date('d-m-Y H:i', strtotime($row_pendaftar['waktu_mendaftar'])); ?></td>
                                <td>
                                    <a href="hapus_pendaftar.php?id=<?= $row_pendaftar['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pendaftar ini?')"><i class="fas fa-trash-alt me-1"></i> Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data pendaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>