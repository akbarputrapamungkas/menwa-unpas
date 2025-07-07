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
            /* Warna ungu utama: #7e22ce */
            --accent-color: #9b4bd6;
            /* Ungu sedikit lebih terang untuk aksen dan hover */
            --light-bg: #f5edfc;
            /* Latar belakang ungu sangat pucat, hampir putih */
            --dark-bg: #262328;
            /* HITAM PEKAT */
            --text-color: #333;
            --white: #ffffff;
            --gray-subtle: #dee2e6;
        }

        /* Ini adalah CSS yang HARUS tetap di <style> atau file eksternal (dari index.php) */
        /* Karena inline style tidak mendukung hover/media query. Ini adalah CSS yang sama persis dengan yang ada di index.php */

        /* Admin Login Button Styles (Hover part MUST remain here) */
        .admin-login-link {
            font-size: 0.7rem;
            opacity: 0.3;
            color: var(--white) !important;
            text-decoration: none;
            transition: opacity 0.3s ease, font-size 0.3s ease;
            cursor: pointer;
            display: inline-block;
            margin-left: 10px;
        }

        .admin-login-link:hover,
        .admin-login-link:focus {
            opacity: 1;
            font-size: 0.8rem;
        }

        /* Footer common link/icon hovers (MUST remain here) */
        footer a:hover {
            color: var(--accent-color) !important;
            text-decoration: underline;
        }

        footer .social-icons a:hover {
            color: var(--accent-color) !important;
        }

        /* Google Maps iframe responsif (MUST remain here) */
        .map-responsive {
            overflow: hidden;
            padding-bottom: 56.25%;
            /* 16:9 aspect ratio */
            position: relative;
            height: 0;
            border-radius: 8px;
        }

        .map-responsive iframe {
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            position: absolute;
            border: 0;
        }

        /* Responsive adjustments for footer (MUST remain here) */
        @media (max-width: 768px) {
            .admin-login-link {
                margin-top: 5px;
                display: block;
                margin-left: 0;
            }

            footer .text-md-start,
            footer .text-md-end {
                text-align: center !important;
            }

            footer .col-lg-4,
            footer .col-lg-2,
            footer .col-lg-3 {
                margin-bottom: 1rem !important;
            }

            footer .col-lg-4:last-of-type,
            footer .col-lg-2:last-of-type,
            footer .col-lg-3:last-of-type,
            footer .col-md-6:last-of-type {
                margin-bottom: 0 !important;
            }

            footer p {
                font-size: 0.8rem;
                line-height: 1.5;
            }

            footer h5,
            footer h6 {
                font-size: 1.1rem !important;
                margin-bottom: 1rem !important;
            }

            footer .social-icons a {
                font-size: 1.2rem;
            }
        }

        /* End of CSS that must stay in <style> or external file for full functionality */


        /* CSS khusus untuk halaman pendaftaran (atau yang tidak ada di index.php) */
        body {
            font-family: 'Lato', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
        }

        .navbar.bg-dark-custom {
            /* Ini adalah kelas yang digunakan di HTML navbar */
            background-color: var(--dark-bg) !important;
            /* Navbar akan selalu gelap */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1030;
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

        /* Margin top untuk footer agar ada jarak dengan konten form */
        footer {
            margin-top: 5rem;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-custom mb-5 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo-menwa.png" width="30" alt="logo menwa" class="me-2" /> MENWA UNPAS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kegiatan.php">Kegiatan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="mediaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Media</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="mediaDropdown">
                            <li><a class="dropdown-item" href="galeri.php">Galeri Foto</a></li>
                            <li><a class="dropdown-item" href="video.php">Video Dokumentasi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak.php">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="pendaftaran.php">Pendaftaran</a>
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
                            <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer style="background-color: var(--dark-bg); color: var(--white); padding-top: 3.5rem; padding-bottom: 2.5rem;">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="footer-logo-container mb-3 text-center text-md-start" style="max-width: 100px; height: auto; margin-bottom: 1rem;">
                        <img src="img/logo-menwa1.png" alt="Logo Menwa Unpas" class="img-fluid" />
                    </div>
                    <h5 class="text-uppercase mb-3" style="color: var(--accent-color); font-weight: bold;">
                        MENWA Mahawarman
                    </h5>
                    <p style="font-size: 0.9rem; line-height: 1.6; margin-bottom: 0.75rem;">
                        Resimen Mahasiswa Mahawarman Batalyon III/Yudha Jaya Universitas Pasundan adalah wadah pengembangan diri mahasiswa dalam disiplin dan patriotisme.
                    </p>
                </div>

                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6 class="text-uppercase mb-3" style="color: var(--accent-color); font-weight: bold;">
                        Tautan Cepat
                    </h6>
                    <ul class="list-unstyled" style="padding-left: 0;">
                        <li><a href="index.php" style="color: var(--white); text-decoration: none;">Beranda</a></li>
                        <li><a href="tentang-kami.php" style="color: var(--white); text-decoration: none;">Tentang Kami</a></li>
                        <li><a href="berita.php" style="color: var(--white); text-decoration: none;">Berita & Kegiatan</a></li>
                        <li><a href="pendaftaran.php" style="color: var(--white); text-decoration: none;">Pendaftaran</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h6 class="text-uppercase mb-3" style="color: var(--accent-color); font-weight: bold;">
                        Kontak Kami
                    </h6>
                    <ul class="list-unstyled" style="padding-left: 0;">
                        <li>
                            <p style="font-size: 0.9rem; line-height: 1.6; margin-bottom: 0.75rem;"><i class="fas fa-map-marker-alt me-3" style="color: var(--accent-color);"></i> Sekretariat Menwa Unpas, Kampus IV Universitas Pasundan, Jl. Dr. Setiabudhi No.193, Bandung, Jawa Barat 40153</p>
                        </li>
                        <li>
                            <p style="font-size: 0.9rem; line-height: 1.6; margin-bottom: 0.75rem;"><i class="fas fa-envelope me-3" style="color: var(--accent-color);"></i> menwauniversitaspasundan@gmail.com</p>
                        </li>
                        <li>
                            <p style="font-size: 0.9rem; line-height: 1.6; margin-bottom: 0.75rem;"><i class="fas fa-phone-alt me-3" style="color: var(--accent-color);"></i> +62 838-8423-246</p>
                        </li>
                    </ul>
                    <div class="social-icons mt-3">
                        <a href="https://www.instagram.com/menwaunpas?igsh=NW81MHk2eHpmd3Zu" target="_blank" aria-label="Instagram" style="font-size: 1.5rem; margin-right: 1rem; color: var(--white); text-decoration: none;"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" target="_blank" aria-label="Facebook" style="font-size: 1.5rem; margin-right: 1rem; color: var(--white); text-decoration: none;"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="https://wa.me/628388423246" target="_blank" aria-label="whatsapp" style="font-size: 1.5rem; margin-right: 1rem; color: var(--white); text-decoration: none;"><i class="fab fa-whatsapp fa-lg"></i></a>
                        <a href="http://googleusercontent.com/youtube.com/19" target="_blank" aria-label="YouTube" style="font-size: 1.5rem; margin-right: 1rem; color: var(--white); text-decoration: none;"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h6 class="text-uppercase mb-3" style="color: var(--accent-color); font-weight: bold;">Temukan Kami</h6>
                    <div class="mb-3 map-responsive">
                        <iframe src="https://maps.app.goo.gl/YourActualGoogleMapsLink9" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-bar row d-flex justify-content-center align-items-center" style="padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.2); margin-top: 2rem; font-size: 0.8rem;">
                <div class="col-md-7 col-lg-8 text-center text-md-start">
                    <p class="mb-0">
                        © <?= date('Y') ?> MENWA Mahawarman Batalyon IV/E Universitas Pasundan. Hak Cipta Dilindungi Undang-Undang.
                    </p>
                </div>
                <div class="col-md-5 col-lg-4 text-center text-md-end">
                    <a href="kebijakan-privasi.php" class="text-white me-3" style="color: var(--white); text-decoration: none;">Kebijakan Privasi</a>
                    <a href="syarat-ketentuan.php" style="color: var(--white); text-decoration: none;">Syarat & Ketentuan</a>
                    <a href="login.php" class="admin-login-link" style="font-size: 0.7rem; opacity: 0.3; color: var(--white); text-decoration: none;">Login Admin</a>
                </div>
            </div>
        </div>
    </footer>

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