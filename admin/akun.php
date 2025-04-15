
<?php
// Menyertakan autoloader Composer
require '../vendor/autoload.php';  // Pastikan pathnya sesuai dengan struktur project Anda

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

        $mail->setFrom('egha56fb@gmail.com', 'CineTix');
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
        $stmt = $conn->prepare("INSERT INTO admin (name, email, password) VALUES (?, ?, ?)");
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
  <title>CineTix | Akun Admin</title>
  <link rel="shortcut icon" type="image/png" href="../img/logo.png" />
  <link rel="stylesheet" href="../../node_modules/simplebar/dist/simplebar.min.css">
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <!-- Link ke CSS SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">

<!-- Link ke JavaScript SweetAlert2 -->


</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./admin.php" class="text-nowrap logo-img">
            <img src="../assets/images/logos/logo-light.svg" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <?php include 'components/sidebar.php' ?>

        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php include 'components/header.php' ?>
      <!--  Header End -->
      <?php
include '../koneksi.php'; // Menghubungkan ke database

// Query untuk mengambil data admin
$sql = "SELECT * FROM admin ORDER BY id ASC";
$result = $conn->query($sql);

?>

<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Akun Admin</h5>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
        Tambah Akun
      </button>

      <div class="table-responsive">
        <table id="filmTable" class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Email</th>
              <th>Nama</th>
              <th>Password</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['name']}</td>
                            <td>*****</td> <!-- Password disembunyikan -->
                          </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>Tidak ada data</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>






      <!-- Inisialisasi DataTables -->


    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.all.min.js"></script>



  <script>
    $(document).ready(function() {
      $('#filmTable').DataTable();
    });
  </script>



  


</body>
<!-- Modal Tambah Jadwal Film -->
<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-labelledby="modalTambahJadwalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahJadwalLabel">Tambah Akun Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="akun.php" method="POST">
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                  </div>
                  <button type="submit" name="send_otp" class="btn btn-primary">Kirim OTP</button>
                </form>
                <?php if (isset($_SESSION['otp'])): ?>
                  <form action="akun.php" method="POST">
                    <div class="mb-3">
                      <label for="otp" class="form-label">Masukan OTP</label>
                      <input type="text" class="form-control" name="otp" required>
                    </div>
                    <button type="submit" name="verify_otp" class="btn btn-success">Verifikasi OTP</button>
                  </form>
                <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<script>
    // Menampilkan SweetAlert setelah mengirim OTP
    <?php if (isset($otp_sent) && $otp_sent): ?>
      Swal.fire({
        title: 'OTP Terkirim!',
        text: 'Kode OTP telah dikirim ke email Anda.',
        icon: 'success',
        confirmButtonText: 'OK'
        
      }).then((result) => {
            if (result.isConfirmed) {
                var myModal = new bootstrap.Modal(document.getElementById('modalTambahJadwal'));
                myModal.show();
            }
        });
    <?php endif; ?>

    // // Menampilkan SweetAlert setelah pendaftaran berhasil
    <?php if (isset($registration_success) && $registration_success): ?>
    Swal.fire({
      title: 'Pendaftaran Berhasil!',
      text: 'Anda telah berhasil mendaftar.',
      icon: 'success',
      confirmButtonText: 'OK'
    }).then(() => {
      // Mengarahkan pengguna ke register.php setelah menekan OK
      window.location.href = 'akun.php'; // Ganti dengan path yang sesuai
    });
  <?php endif; ?>
  </script>
</html>