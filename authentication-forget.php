<?php
require 'vendor/autoload.php'; // Pastikan path benar

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

$alert_message = "";
$alert_type = "";

if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    
    $conn = new mysqli("localhost", "root", "", "db_bioskop");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_sent_time'] = time();
        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'egha56fb@gmail.com';
            $mail->Password = 'hnta dxkm urtd sugl';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            
            $mail->setFrom('egha56fb@gmail.com', 'CineTix');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'OTP Reset Password';
            $mail->Body = "Kode OTP Anda: <b>$otp</b>. Berlaku selama 15 menit.";
            $mail->send();
            
            $alert_message = "Kode OTP telah dikirim ke email Anda.";
            $alert_type = "success";
        } catch (Exception $e) {
            $alert_message = "Gagal mengirim email: {$mail->ErrorInfo}";
            $alert_type = "error";
        }
    } else {
        $alert_message = "Email tidak ditemukan.";
        $alert_type = "error";
    }
}

if (isset($_POST['verify_otp'])) {
    $otp_input = $_POST['otp'];
    if ($otp_input == $_SESSION['otp'] && (time() - $_SESSION['otp_sent_time'] < 900)) {
        $_SESSION['otp_verified'] = true;
    } else {
        $alert_message = "OTP salah atau kadaluarsa.";
        $alert_type = "error";
    }
}

if (isset($_POST['reset_password']) && isset($_SESSION['otp_verified'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $email = $_SESSION['email'];
    
    $conn = new mysqli("localhost", "root", "", "db_bioskop");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_password, $email);
    if ($stmt->execute()) {
        $alert_message = "Password berhasil direset.";
        $alert_type = "success";
        session_destroy();
    } else {
        $alert_message = "Gagal mereset password.";
        $alert_type = "error";
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
              <img src="img/logologin.png" alt="" width="400">
              </a>
              <h3 class="mb-4">Lupa Password?</h3>
              <?php if (!isset($_SESSION['otp']) && !isset($_SESSION['otp_verified'])): ?>
              <form method="POST" id="emailForm">
                <div class="mb-3">
                  <label class="form-label">Email:</label>
                  <input type="email" class="form-control" name="email" placeholder="Masukan Email Anda" required>
                </div>
                <button type="submit" name="send_otp" class="btn btn-primary w-100">Kirim OTP</button>
              </form>
              <?php endif; ?>
              
              <?php if (isset($_SESSION['otp']) && !isset($_SESSION['otp_verified'])): ?>
              <form method="POST" class="mt-3" id="otpForm">
                <div class="mb-3">
                  <label class="form-label">Masukkan OTP:</label>
                  <input type="text" class="form-control" name="otp" required>
                </div>
                <button type="submit" name="verify_otp" class="btn btn-success w-100">Verifikasi OTP</button>
              </form>
              <?php endif; ?>
              
              <?php if (isset($_SESSION['otp_verified'])): ?>
              <form method="POST" class="mt-3" id="passwordForm">
                <div class="mb-3">
                  <label class="form-label">Password Baru:</label>
                  <input type="password" class="form-control" name="new_password" required>
                </div>
                <button type="submit" name="reset_password" class="btn btn-danger w-100">Reset Password</button>
              </form>
              <?php endif; ?>
              <div class="mt-3">
                  <p class="mb-0">Masuk ke akun ? <a href="authentication-login.php" class="text-primary fw-bold">Login</a></p>
                </div>
            
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
    <?php if (!empty($alert_message)): ?>
      Swal.fire({
        title: "<?= $alert_type == 'success' ? 'Berhasil' : 'Gagal' ?>",
        text: "<?= $alert_message ?>",
        icon: "<?= $alert_type ?>",
        confirmButtonText: "OK"
      }).then(() => {
        window.location.href = 'authentication-forget.php';
      });
    <?php endif; ?>
  </script>
</body>
</html>
