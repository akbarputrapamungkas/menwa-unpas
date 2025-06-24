<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <!-- aos css -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <title>MENWA</title>
  <style>
    * {
      box-sizing: border-box;
      scroll-behavior: smooth;
    }

    section {
      height: 100vh;
    }

    :root {
      --warna-utama: #7e22ce;
    }

    nav ul li:hover {
      color: #000;
    }

    body {
      font-family: "Lato", sans-serif;
      margin: 0;
      padding: 0;
    }


    /* Navbar transparan */
    nav {
      background-color: transparent;
    }

    /* Warna navbar saat scroll */
    .navbar.scrolled {
      background-color: rgba(126, 34, 206, 0.7) !important;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(5px);
      transition: background-color 0.5s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    /* Ubah warna teks/link navbar saat scroll */
    .navbar.scrolled .nav-link,
    .navbar.scrolled .navbar-brand,
    .navbar.scrolled .navbar-toggler-icon {
      color: #402658 !important;
    }



    /* Jumbotron setinggi layar penuh */
    .jumbotron {
      position: relative;
      height: 100vh;
      overflow: hidden;
    }

    /* Video background */
    .bg-video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      object-fit: cover;
      z-index: -1;
    }


    /* Konten utama di atas video */
    .menwa {
      z-index: 2;
      color: white;
    }

    .video-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.3);
      /* Sesuaikan kegelapan di sini */
      z-index: 0;
      /* Harus di bawah konten utama (z-index: 1 di .menwa) */
    }

    .jumbotron hr {
      height: 3px;
      background-color: #fff;
      border: none;
      margin: 20px 0;
    }

    /* Bagian tentang kami */
    .about {
      width: 100%;
      height: 100vh;
      background-color: #C2B3D0;
      display: flex;
      align-items: center;
    }
  </style>
</head>

<body>
  <!-- navbar -->
  <nav class="navbar fixed-top navbar-expand-lg shadow-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="img/logo-menwa.png" width="30" alt="logo menwa" />
        MENWA
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto text-center">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Tentang kami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdownMenuLink"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              Dropdown
            </a>
            <ul
              class="dropdown-menu"
              aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- akhir navbar -->

  <!-- jumbotron -->
  <section class="jumbotron text-center" id="home">
    <!-- Video background -->
    <video class="bg-video" autoplay muted loop playsinline>
      <source src="img/join_p1.mp4" type="video/mp4" />
      Browser tidak mendukung video.
    </video>
    <!-- Overlay gelap -->
    <div class="video-overlay"></div>

    <!-- Konten utama -->
    <div
      class="container menwa position-absolute top-50 start-50 translate-middle">
      <div class="logo my-auto">
        <img
          src="img/logo-menwa1.png"
          alt="resimen mahasiswa mahawarman"
          width="200px" />
        <h1 class="text-1"
          data-aos="zoom-in-down"
          data-aos-duration="1000">MENWA mahawarman Kompie E
        </h1>
        <h5 class="text-1"
          data-aos="zoom-in-up"
          data-aos-duration="1000">Resimen mahasiswa mahawarman Kompie E Universitas Pasundan</h5>
        <hr>
      </div>
    </div>
  </section>
  <!-- akhir jumbotron -->

  <!-- tentang kami -->
  <section class="about" id="about">
    <div class="container py-5">
      <div class="row pt-5">
        <div class="col text-center">
          <h2>Tentang Kami</h2>
        </div>
      </div>
      <div class="row m-3 justify-content-center align-items-center">
        <div class="col-md-5 mx-3">
          <img
            src="img/pradik.jpg"
            alt="Tentang Kami"
            class="img-fluid shadow-lg" />
        </div>
        <div class="col-md-5 fs-5 mx-3">
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit,
            voluptatem, praesentium dolor ipsa reiciendis quam dolorem tenetur
            ad possimus vel obcaecati laboriosam veniam tempora? Ex veritatis
            asperiores iure, laboriosam vel doloribus animi itaque
            consequuntur ipsum illo recusandae assumenda cumque corrupti iusto
            quasi fuga atque aspernatur? Molestiae animi facere, laudantium
            aut obcaecati quam sapiente. Vel perspiciatis tempore corrupti qui
            amet, reiciendis consequatur enim perferendis architecto
            veritatis.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- akhir tentang kami -->

  <!-- visi dan misi -->
  <section id="visi-misi" class="bg-light py-5">
    <div class="container text-center">
      <div class="row pt-5">
        <div class="col">
          <h2 class="mb-4">Visi & Misi</h2>
        </div>
      </div>

      <div class="row justify-content-between">
        <div class="col-md-5">
          <h5>Visi</h5>
          <p>
            Menjadi kader bela negara yang berkarakter, disiplin, dan berjiwa
            kepemimpinan.
          </p>
        </div>
        <div class="col-md-5">
          <h5>Misi</h5>
          <ul class="text-start">
            <li>Membentuk pribadi tangguh dan berwawasan kebangsaan.</li>
            <li>Melatih kedisiplinan dan kepemimpinan mahasiswa.</li>
            <li>Menanamkan semangat bela negara.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- akhir visi dan misi -->

  <!-- kegiatan -->
  <section id="kegiatan" class="py-5">
    <div class="container text-center">
      <h2 class="mb-4">Kegiatan Kami</h2>
      <div class="row g-4 justify-content-center pt-5">
        <div class="col-md-4">
          <img src="img/kegiatan1.jpg" class="img-fluid rounded shadow" alt="Kegiatan 1" />
          <p class="mt-2">Pelatihan Dasar</p>
        </div>
        <div class="col-md-4">
          <img src="img/kegiatan2.jpg" class="img-fluid rounded shadow" alt="Kegiatan 2" />
          <p class="mt-2">Upacara Hari Nasional</p>
        </div>
        <div class="col-md-4">
          <img src="img/kegiatan3.jpg" class="img-fluid rounded shadow" alt="Kegiatan 3" />
          <p class="mt-2">Latihan Menembak</p>
        </div>
      </div>
    </div>
  </section>



  <!-- akhir kegiatan -->
  <!-- aos js -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

  <script src="assets/js/index.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>