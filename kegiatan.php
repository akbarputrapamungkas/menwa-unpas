<?php
// kegiatan.php

require 'inc/config.php'; // Sertakan file koneksi database Anda

// Ambil data dari tabel kegiatan
// Urutkan berdasarkan tanggal_upload terbaru
$result_kegiatan = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY tanggal_upload DESC");

// Periksa jika ada error pada query
if (!$result_kegiatan) {
    die("Query kegiatan gagal: " . mysqli_error($conn));
}

// Mendapatkan nama file halaman saat ini untuk menentukan link aktif di navbar
$current_page = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan Kami - Menwa Unpas</title>
    <meta name="description" content="Daftar kegiatan dan agenda Resimen Mahasiswa Mahawarman Batalyon III/Yudha Jaya Universitas Pasundan Bandung.">
    <link rel="shortcut icon" href="img/logo-menwa1.png" type="image/x-icon" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* Variabel Warna CSS (dari tema ungu Anda) */
        :root {
            --primary-menwa: #7e22ce;
            /* Warna ungu utama: #7e22ce */
            --accent-color: #9b4bd6;
            /* Ungu sedikit lebih terang untuk aksen dan hover */
            --light-bg: #f5edfc;
            /* Latar belakang ungu sangat pucat, hampir putih */
            --dark-bg: #262328;
            /* Hitam pekat untuk navbar dan footer */
            --text-color: #333;
            --white: #ffffff;
        }

        body {
            font-family: "Lato", sans-serif;
            background-color: var(--light-bg);
            /* Latar belakang halaman kegiatan */
            color: var(--text-color);
        }

        /* Navbar Styles */
        .navbar {
            background-color: var(--dark-bg) !important;
            /* Navbar selalu gelap di halaman internal */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1030;
        }

        .navbar-brand,
        .nav-link {
            color: var(--white) !important;
        }

        .navbar-toggler-icon {
            filter: brightness(0) invert(1);
        }

        .navbar .nav-link:hover,
        .navbar .nav-item .nav-link.active {
            color: var(--accent-color) !important;
        }

        /* Page Header Styles */
        .page-header {
            background-color: var(--primary-menwa);
            color: var(--white);
            padding: 5rem 0;
            text-align: center;
            margin-bottom: 3rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .page-header h1 {
            font-weight: bold;
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Kegiatan Card Styles (Mirip dengan di index.php) */
        #kegiatan-list .card {
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            /* Agar tinggi card seragam */
            display: flex;
            flex-direction: column;
        }

        #kegiatan-list .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        #kegiatan-list .card img {
            height: 220px;
            /* Sedikit lebih tinggi dari card di index */
            object-fit: cover;
            width: 100%;
        }

        #kegiatan-list .card-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #kegiatan-list .card-title {
            font-size: 1.35rem;
            /* Ukuran judul card */
            font-weight: bold;
            color: var(--primary-menwa);
            margin-bottom: 0.75rem;
        }

        #kegiatan-list .card-text {
            font-size: 0.95rem;
            color: var(--text-color);
            margin-bottom: 1rem;
        }

        #kegiatan-list .card-date {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: auto;
            /* Dorong ke bawah */
        }

        /* Button Overrides (Konsisten dengan tema) */
        .btn-primary {
            background-color: var(--primary-menwa) !important;
            border-color: var(--primary-menwa) !important;
        }

        .btn-primary:hover {
            background-color: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
        }

        .btn-outline-primary {
            color: var(--primary-menwa) !important;
            border-color: var(--primary-menwa) !important;
        }

        .btn-outline-primary:hover {
            color: var(--white) !important;
            background-color: var(--primary-menwa) !important;
        }

        /* Footer Styles (Konsisten dengan tema index.php) */
        footer {
            background-color: var(--dark-bg) !important;
            color: var(--white);
            padding-top: 3.5rem;
            padding-bottom: 2.5rem;
            margin-top: 5rem;
            /* Jarak dari konten di atasnya */
        }

        footer .footer-logo-container img {
            max-width: 100px;
            height: auto;
            margin-bottom: 1rem;
        }

        footer h5,
        footer h6 {
            color: var(--accent-color) !important;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        footer p {
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 0.75rem;
        }

        footer p i {
            color: var(--accent-color);
        }

        footer a {
            color: var(--white) !important;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--accent-color) !important;
            text-decoration: underline;
        }

        footer .social-icons a {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: var(--white) !important;
            transition: color 0.3s ease;
        }

        footer .social-icons a:hover {
            color: var(--accent-color) !important;
        }

        footer .footer-bottom-bar {
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 2rem;
            font-size: 0.8rem;
        }

        footer .footer-bottom-bar .admin-login-link {
            font-size: 0.7rem;
            opacity: 0.3;
            transition: opacity 0.3s ease;
        }

        footer .footer-bottom-bar .admin-login-link:hover {
            opacity: 1;
        }


        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .page-header {
                padding: 3rem 0;
                margin-bottom: 2rem;
            }

            .page-header h1 {
                font-size: 2.2rem;
            }

            .page-header p {
                font-size: 1rem;
            }

            #kegiatan-list .card img {
                height: 180px;
            }

            #kegiatan-list .card-title {
                font-size: 1.2rem;
            }

            #kegiatan-list .card-text {
                font-size: 0.9rem;
            }

            /* Footer responsive adjustments */
            footer .text-md-start,
            footer .text-md-end {
                text-align: center !important;
            }

            footer .col-lg-4,
            footer .col-lg-2,
            footer .col-lg-3 {
                margin-bottom: 1.5rem !important;
            }

            footer .col-lg-4:last-of-type,
            footer .col-lg-2:last-of-type,
            footer .col-lg-3:last-of-type,
            footer .col-md-6:last-of-type {
                margin-bottom: 0 !important;
            }

            footer p {
                font-size: 0.85rem;
            }

            footer h5,
            footer h6 {
                font-size: 1.2rem !important;
            }

            footer .social-icons a {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg shadow-sm navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo-menwa.png" width="30" alt="logo menwa" class="me-2" /> MENWA UNPAS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#visi-misi">Visi & Misi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="kegiatan.php">Kegiatan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="mediaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Media</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="mediaDropdown">
                            <li>
                                <a class="dropdown-item" href="galeri.php">Galeri Foto</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="video.php">Video Dokumentasi</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak.php">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-header">
        <div class="container">
            <h1>Daftar Kegiatan Menwa Unpas</h1>
            <p>Berbagai aktivitas dan momen penting Resimen Mahasiswa Universitas Pasundan.</p>
        </div>
    </div>

    <div class="container py-5" id="kegiatan-list">
        <div class="row g-4 justify-content-center">
            <?php if (mysqli_num_rows($result_kegiatan) > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($result_kegiatan)) : ?>
                    <div class="col-lg-4 col-md-6 d-flex">
                        <div class="card shadow-sm w-100">
                            <?php
                            // Pastikan path gambar relatif ke file ini (kegiatan.php)
                            // Jika kegiatan.php dan folder 'uploads' sejajar
                            $image_path = 'uploads/' . htmlspecialchars($row['gambar']);
                            ?>
                            <?php if (!empty($row['gambar']) && file_exists($image_path)) : ?>
                                <img src="<?= $image_path; ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_kegiatan']); ?>">
                            <?php else : ?>
                                <img src="https://via.placeholder.com/400x220?text=No+Image" class="card-img-top" alt="Tidak Ada Gambar">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($row['nama_kegiatan']); ?></h5>
                                <p class="card-text">
                                    <?= htmlspecialchars(substr($row['deskripsi'], 0, 120)) . (strlen($row['deskripsi']) > 120 ? '...' : ''); ?>
                                </p>
                                <p class="card-date mt-auto"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y, H:i', strtotime($row['tanggal_upload'])); ?></p>
                                <a href="detail_kegiatan.php?id=<?= htmlspecialchars($row['id']); ?>" class="btn btn-primary mt-3">Lihat Detail <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info" role="alert">
                        Belum ada kegiatan yang tersedia saat ini.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="footer-logo-container mb-3 text-center text-md-start">
                        <img src="img/logo-menwa1.png" alt="Logo Menwa Unpas" class="img-fluid" />
                    </div>
                    <h5 class="text-uppercase text-primary mb-3">
                        MENWA Mahawarman
                    </h5>
                    <p>
                        Resimen Mahasiswa Mahawarman Batalyon III/Yudha Jaya Universitas Pasundan adalah wadah pengembangan diri mahasiswa dalam disiplin dan patriotisme.
                    </p>
                </div>

                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6 class="text-uppercase text-primary mb-3">
                        Tautan Cepat
                    </h6>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white">Beranda</a></li>
                        <li><a href="tentang-kami.php" class="text-white">Tentang Kami</a></li>
                        <li><a href="berita.php" class="text-white">Berita & Kegiatan</a></li>
                        <li><a href="pendaftaran.php" class="text-white">Pendaftaran</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h6 class="text-uppercase text-primary mb-3">
                        Kontak Kami
                    </h6>
                    <ul class="list-unstyled">
                        <li>
                            <p><i class="fas fa-map-marker-alt me-3"></i> Sekretariat Menwa Unpas, Kampus IV Universitas Pasundan, Jl. Dr. Setiabudhi No.193, Bandung, Jawa Barat 40153</p>
                        </li>
                        <li>
                            <p><i class="fas fa-envelope me-3"></i> menwauniversitaspasundan@gmail.com</p>
                        </li>
                        <li>
                            <p><i class="fas fa-phone-alt me-3"></i> +62 838-8423-246</p>
                        </li>
                    </ul>
                    <div class="social-icons mt-3">
                        <a href="https://www.instagram.com/menwaunpas?igsh=NW81MHk2eHpmd3Zu" target="_blank" aria-label="Instagram"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="https://wa.me/628388423246" target="_blank" aria-label="whatsapp"><i class="fab fa-whatsapp fa-lg"></i></a>
                        <a href="http://googleusercontent.com/youtube.com/16" target="_blank" aria-label="YouTube"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h6 class="text-uppercase text-primary mb-3">Temukan Kami</h6>
                    <div class="mb-3 map-responsive">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1177.5767162338786!2d107.60757377296558!3d
                -6.9049317958478555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64636df8dbb%3A0xcbcc81f4
                f1f9b6c5!2sJl.%20Tamansari%20No.6%2C%20Lb.%20Siliwangi%2C%20Kecamatan%20Coblong%2C%20Kota%20Bandung%2
                C%20Jawa%20Barat%2040132!5e0!3m2!1sid!2sid!4v1751882156776!5m2!1sid!2sid"
                            style="border: 0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-bar row d-flex justify-content-center align-items-center">
                <div class="col-md-7 col-lg-8 text-center text-md-start">
                    <p class="mb-0">
                        © <?= date('Y') ?> MENWA Mahawarman Batalyon IV/E Universitas Pasundan. Hak Cipta Dilindungi Undang-Undang.
                    </p>
                </div>
                <div class="col-md-5 col-lg-4 text-center text-md-end">
                    <a href="kebijakan-privasi.php" class="text-white me-3">Kebijakan Privasi</a>
                    <a href="syarat-ketentuan.php" class="text-white">Syarat & Ketentuan</a>
                    <a href="login.php" class="admin-login-link">Login Admin</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800,
            easing: "ease-out-quad",
        });

        // Script untuk Navbar Scrolled (jika ingin diaktifkan di halaman ini juga)
        // Saat ini navbar di halaman kegiatan.php sudah diset gelap secara default,
        // jadi efek scroll transparan tidak relevan.
        // Jika Anda ingin navbar bisa transparan di awal lalu jadi gelap,
        // Anda bisa mengaktifkan script ini dan mengatur .navbar background-color
        // menjadi transparent di CSS.
        // window.addEventListener("scroll", function() {
        //     const navbar = document.querySelector(".navbar");
        //     if (window.scrollY > 50) {
        //         navbar.classList.add("scrolled");
        //     } else {
        //         navbar.classList.remove("scrolled");
        //     }
        // });

        // Script untuk Smooth Scroll (jika ada anchor link internal di halaman ini)
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener("click", function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute("href")).scrollIntoView({
                    behavior: "smooth",
                });
            });
        });
    </script>
</body>

</html>
<?php
// Tutup koneksi database setelah semua data diambil dan ditampilkan
mysqli_close($conn);
?>