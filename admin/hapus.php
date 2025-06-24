<?php
require '../inc/config.php';

$id = $_GET['id'];

// Cek dulu gambar yang akan dihapus
$result = mysqli_query($conn, "SELECT gambar FROM kegiatan WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if ($row) {
    $gambar = $row['gambar'];

    // Hapus gambar dari folder
    if (file_exists("../uploads/$gambar")) {
        unlink("../uploads/$gambar");
    }

    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM kegiatan WHERE id = $id");
}

header("Location: dashboard.php");
exit;
