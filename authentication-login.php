<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_bioskop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data pengguna berdasarkan email
    $stmt = $conn->prepare("SELECT name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $hashed_password);
        $stmt->fetch();

        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            // Login berhasil, simpan informasi pengguna di session
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name; // Simpan nama pengguna di session
            header("Location: index.php"); // Ganti dengan halaman yang sesuai setelah login
            exit();
        } else {
            $error_message = "Password salah.";
        }
    } else {
        $error_message = "Email tidak terdaftar.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CineTix | Login</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/seodashlogo.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <style>
    .logo-img img {
      max-width: 100%;
      height: auto;
    }
    .card-body {
      padding: 2rem;
    }
  </style>
   <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/4.0.0/model-viewer.min.js"></script>
</head>

<body>
  <div class="page-wrapper d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card">
            <div class="card-body text-center">
              <a href="index.php" class="logo-img d-block mb-3">
              <img src="img/logologin.png" alt="" width="400">
              </a>
              <h3 class="mb-4">Silahkan Login</h3>
              <form method="POST" action="authentication-login.php">
                <div class="mb-3 text-start">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-4 text-start">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <a class="text-primary fw-bold" href="authentication-forget.php">Lupa Password?</a>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100 py-2">Sign In</button>
                <div class="mt-3">
                  <p class="mb-0">Tidak Punya Akun? <a href="authentication-register.php" class="text-primary fw-bold">Buat Akun</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
