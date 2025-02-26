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

    // Query untuk mendapatkan data pengguna berdasarkan email dari tabel admin
    $stmt = $conn->prepare("SELECT name, password FROM admin WHERE email = ?");
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
            header("Location: admin.php"); // Ganti dengan halaman yang sesuai setelah login
            exit();
        } else {
            $error_message = "Password salah.";
        }
    } else {
        // Jika tidak ditemukan di tabel admin, coba di tabel akun_mall
        $stmt = $conn->prepare("SELECT nama_mall, password FROM akun_mall WHERE email = ?");
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
                $_SESSION['nama_mall'] = $name; // Simpan nama pengguna di session
                header("Location: admin.php"); // Ganti dengan halaman yang sesuai setelah login
                exit();
            } else {
                $error_message = "Password salah.";
            }
        } else {
            $error_message = "Email tidak terdaftar di kedua tabel.";
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CineTix | Login Akun</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/seodashlogo.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
              <a href="index.php" class="text-nowrap logo-img text-center d-block  w-100">
                  <img src="../img/logologin.png" alt="" width="400">
                </a>
                <h3 class="text-center">Login Admin/Mall</h3>
                <form method="POST" action="index.php">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" required>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                  </div>
                 
                  <button type="submit" name="login" class="btn btn-primary w-100 py-8 fs-4 mb-4">Sign In</button>
                  <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $error_message; ?>
                    </div>
                  <?php endif; ?>
                  
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>