<?php
// pendaftaran.php

require 'inc/config.php'; // Pastikan file koneksi database Anda

$message = ''; // Variabel untuk menyimpan pesan sukses/gagal

// Proses pengiriman formulir jika metode POST digunakan
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil dan sanitasi data dari formulir
    $nama     = $conn->real_escape_string($_POST["nama"]);
    $jurusan  = $conn->real_escape_string($_POST["jurusan"]);
    $nomor_wa = $conn->real_escape_string($_POST["nomer_wa"]);

    // Menggunakan Prepared Statement untuk INSERT data (LEBIH AMAN dari SQL Injection)
    $sql = "INSERT INTO pendaftar (nama, jurusan, nomor_wa) VALUES (?, ?, ?)";

    // Siapkan statement
    $stmt = $conn->prepare($sql);

    // Periksa jika statement berhasil disiapkan
    if ($stmt === false) {
        $message = '<div class="alert alert-danger">Terjadi kesalahan saat menyiapkan statement: ' . htmlspecialchars($conn->error) . '</div>';
    } else {
        // Bind parameter ke statement
        // 'sss' berarti semua parameter adalah string (s=string)
        $stmt->bind_param("sss", $nama, $jurusan, $nomor_wa);

        // Jalankan statement
        if ($stmt->execute()) {
            $message = '<div class="alert alert-success">Pendaftaran berhasil! Terima kasih telah mendaftar.</div>';
        } else {
            $message = '<div class="alert alert-danger">Pendaftaran gagal: ' . htmlspecialchars($stmt->error) . '</div>';
        }

        // Tutup statement
        $stmt->close();
    }

    // Tutup koneksi database setelah selesai
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Anggota MENWA Unpas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Variabel Warna CSS (dari tema ungu yang konsisten) */
        :root {
            --primary-menwa: #7e22ce;
            --accent-color: #9b4bd6;
            --light-bg: #f5edfc;
            --dark-bg-custom: #5f1a9b;
            --text-color: #333;
            --white: #ffffff;
        }

        body {
            font-family: 'Lato', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
        }

        .navbar.bg-dark-custom {
            background-color: var(--dark-bg-custom) !important;
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--white) !important;
        }

        .navbar-nav .nav-link {
            color: var(--white) !important;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--accent-color) !important;
        }


        .card-body {
            padding: 2.5rem;
        }

        .text-primary {
            color: var(--primary-menwa) !important;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(126, 34, 206, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-menwa) !important;
            border-color: var(--primary-menwa) !important;
            padding: 10px 20px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
        }

        .form-label i {
            color: var(--primary-menwa);
        }

        .form-text {
            color: #6c757d;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-custom mb-5 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src="img/logo-menwa.png" width="30" alt="logo menwa" class="me-2" /> MENWA UNPAS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html"><i class="fas fa-home me-1"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="pendaftaran.php"><i class="fas fa-user-plus me-1"></i> Pendaftaran</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h3 class="text-center mb-4 fw-bold text-primary">Formulir Pendaftaran Anggota Baru</h3>

                        <?php
                        // Tampilkan pesan sukses atau gagal jika ada
                        if (!empty($message)) {
                            echo $message;
                        }
                        ?>

                        <form method="POST" action="" onsubmit="return confirmSubmission()">
                            <div class="mb-3">
                                <label for="nama" class="form-label"><i class="fas fa-user me-2"></i>Nama Lengkap</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
                            </div>

                            <div class="mb-3">
                                <label for="jurusan" class="form-label"><i class="fas fa-graduation-cap me-2"></i>Jurusan / Program Studi</label>
                                <input type="text" name="jurusan" id="jurusan" class="form-control" placeholder="Contoh: Teknik Informatika" required>
                            </div>

                            <div class="mb-3">
                                <label for="nomer_wa" class="form-label"><i class="fab fa-whatsapp me-2"></i>Nomor WhatsApp</label>
                                <input type="tel" name="nomer_wa" id="nomer_wa" class="form-control"
                                    placeholder="Contoh: 081234567890" pattern="08[0-9]{8,12}"
                                    title="Gunakan format angka diawali 08, minimal 8 digit, maksimal 12 digit setelah 08." required>
                                <div class="form-text">Gunakan format angka diawali 08 (misal: 081234567890).</div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3">Daftar Sekarang</button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="index.html" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        /**
         * Fungsi JavaScript untuk menampilkan konfirmasi sebelum mengirim formulir.
         * Jika pengguna mengklik 'OK', formulir akan dikirim.
         * Jika pengguna mengklik 'Cancel', pengiriman formulir akan dibatalkan.
         */
        function confirmSubmission() {
            return confirm("Apakah data yang Anda masukkan sudah benar?");
        }
    </script>
</body>

</html>