<?php
// hapus_pendaftar.php

session_start(); // Mulai sesi PHP

// Periksa apakah admin sudah login. Jika tidak, arahkan kembali ke halaman login.
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['username'] !== 'admin') {
    header("Location: ../login.php"); // Arahkan ke halaman login di root folder (asumsi login.php ada di satu level di atas folder admin)
    exit;
}

require '../inc/config.php'; // Sertakan file konfigurasi database Anda

// Pastikan parameter 'id' ada di URL
if (!isset($_GET['id'])) {
    // Jika ID tidak ditemukan, arahkan kembali ke dashboard dengan pesan error
    $_SESSION['pesan_hapus'] = '<div class="alert alert-danger" role="alert">ID pendaftar tidak ditemukan.</div>';
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

// Menggunakan Prepared Statement untuk menghapus data pendaftar (LEBIH AMAN dari SQL Injection)
// Tidak ada gambar yang perlu dihapus dari folder karena tabel 'pendaftar' tidak memiliki kolom gambar.
$stmt = $conn->prepare("DELETE FROM pendaftar WHERE id = ?");

// Periksa jika statement berhasil disiapkan
if ($stmt === false) {
    $_SESSION['pesan_hapus'] = '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menyiapkan penghapusan: ' . htmlspecialchars($conn->error) . '</div>';
} else {
    // Bind parameter ke statement ('i' untuk integer)
    $stmt->bind_param("i", $id);

    // Jalankan statement
    if ($stmt->execute()) {
        $_SESSION['pesan_hapus'] = '<div class="alert alert-success" role="alert">Data pendaftar berhasil dihapus.</div>';
    } else {
        $_SESSION['pesan_hapus'] = '<div class="alert alert-danger" role="alert">Gagal menghapus data pendaftar: ' . htmlspecialchars($stmt->error) . '</div>';
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi database
$conn->close();

// Arahkan kembali ke halaman dashboard
header("Location: dashboard.php");
exit;
