  <?php
  // Menyertakan autoloader Composer
  require 'vendor/autoload.php';  // Pastikan pathnya sesuai dengan struktur project Anda

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  session_start();

  // Inisialisasi variabel untuk menyimpan input
  $name = '';
  $email = '';
  $password = '';

  if (isset($_POST['send_otp'])) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];

      // Simpan password di session
      $_SESSION['password'] = $password;

      // Generate OTP
      $otp = rand(100000, 999999);
      $_SESSION['otp'] = $otp;
      $_SESSION['email'] = $email;
      $_SESSION['name'] = $name;
      $_SESSION['otp_sent_time'] = time(); // Store the time OTP was sent

      // Kirim email OTP
      $mail = new PHPMailer(true);
      try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'egha56fb@gmail.com';
        $mail->Password = 'hnta dxkm urtd sugl';  // Gunakan App Password jika 2FA aktif
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Untuk port 465
        $mail->Port = 465;  // Port untuk SSL

          $mail->setFrom('egha56fb@gmail.com', 'Ticket Bioskop');
          $mail->addAddress($email);

          $mail->isHTML(true);
          $mail->Subject = 'OTP Verifikasi Akun';
          $mail->Body = "Hai $name, <br> Berikut adalah kode OTP Anda: <b>$otp</b>.<br>Kode ini berlaku selama 15 menit.";

          $mail->send();
          $otp_sent = true; // Set flag untuk menampilkan SweetAlert
      } catch (Exception $e) {
          echo "Gagal mengirim email: {$mail->ErrorInfo}";
      }
  }

  if (isset($_POST['verify_otp'])) {
      $otp_input = $_POST['otp'];

      // Check if OTP is valid and not expired (15 minutes)
      if ($otp_input == $_SESSION['otp'] && (time() - $_SESSION['otp_sent_time'] < 900)) {
          // OTP valid, simpan data pengguna ke database
          $name = $_SESSION['name'];
          $email = $_SESSION['email'];
          $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);  // Hash password

          // Koneksi ke database dan insert data pengguna
          $conn = new mysqli("localhost", "root", "", "db_bioskop");
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          // Use prepared statement
          $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
          $stmt->bind_param("sss", $name, $email, $password);

          if ($stmt->execute()) {
              $registration_success = true; // Set flag untuk menampilkan SweetAlert
              // Hapus session setelah verifikasi
              unset($_SESSION['otp']);
              unset($_SESSION['otp_sent_time']);
              unset($_SESSION['password']); // Hapus password dari session
          } else {
              echo "Error: " . $stmt->error;
          }
      } else {
          echo "OTP salah atau kadaluarsa.";
      }
  }
  ?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CineTix | Register</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/seodashlogo.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
              <model-viewer
  src="assets/3D/ImageToStl.com_logologin.glb"
  camera-controls
  auto-rotate
  rotation-per-second="30deg"
  autoplay
  shadow-intensity="1"
  ar
  scale="2 2 2"
  orientation="0 1.5 0 0"
  camera-target="0m 0.5m 0m"
  camera-orbit="0deg 90deg 1.5m"
  field-of-view="50deg">
</model-viewer>
              </a>
              <h3 class="mb-4">Silahkan Buat Akun</h3>
              <form action="authentication-register.php" method="POST">
                <div class="mb-3 text-start">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name"  value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="mb-3 text-start">
                  <label for="email" class="form-label">Email Address</label>
                  <input type="email" class="form-control" name="email"  value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="mb-4 text-start">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" name="send_otp" class="btn btn-primary w-100 py-2">Kirim OTP</button>
              </form>
              <?php if (isset($_SESSION['otp'])): ?>
                  <form action="authentication-register.php" method="POST">
                    <div class="mb-3">
                      <label for="otp" class="form-label">Masukan OTP</label>
                      <input type="text" class="form-control" name="otp" required>
                    </div>
                    <button type="submit" name="verify_otp" class="btn btn-success">Verifikasi OTP</button>
                  </form>
                <?php endif; ?>
           
              <div class="mt-3">
                <p class="mb-0">Sudah Punya Akun? <a href="authentication-login.php" class="text-primary fw-bold">Log In</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    <?php if (isset($otp_sent) && $otp_sent): ?>
      Swal.fire({
        title: 'OTP Terkirim!',
        text: 'Kode OTP telah dikirim ke email Anda.',
        icon: 'success',
        confirmButtonText: 'OK'
      });
    <?php endif; ?>
    <?php if (isset($registration_success) && $registration_success): ?>
      Swal.fire({
        title: 'Pendaftaran Berhasil!',
        text: 'Anda telah berhasil mendaftar. Silakan masuk.',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'authentication-login.php';
      });
    <?php endif; ?>
  </script>
</body>
</html>
