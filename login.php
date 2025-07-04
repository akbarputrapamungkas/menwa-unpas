<?php
session_start();
require 'inc/config.php';

/* ────────────────────
   Cek sudah login?
────────────────────── */
if (isset($_SESSION['login'])) {
    if ($_SESSION['username'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

/* ────────────────────
   Proses login
────────────────────── */
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Hash MD5
    $password_md5 = md5($password);

    // Ambil data user dengan username & password MD5 yang cocok
    $result = mysqli_query(
        $conn,
        "SELECT * FROM user WHERE username = '$username' AND password = '$password_md5'"
    );

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Set sesi & redirect
        $_SESSION['login']    = true;
        $_SESSION['username'] = $row['username'];

        if ($row['username'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    }

    // Jika tidak cocok
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login dan Cari Kendaraan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Rubik', sans-serif;
            background: #f8f9fa
        }

        .card-login {
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, .1)
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card card-login">
                    <div class="card-header bg-primary text-white text-center fs-5">Login</div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger text-center">Username atau Password salah!</div>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NBP</label>
                                <input type="number" name="NBP" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3 text-end">
                                <a href="registrasi.php" class="text-decoration-none">Belum punya akun?</a>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>