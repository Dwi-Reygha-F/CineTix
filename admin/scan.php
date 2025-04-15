<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['name']) && !isset($_SESSION['nama_mall'])) {
  // Jika belum login, arahkan ke login.php
  header("Location: index.php");
  exit();
}

// Ambil level pengguna dari session
if (isset($_SESSION['name'])) {
  $level = 'admin'; // Misalnya untuk admin
} elseif (isset($_SESSION['nama_mall'])) {
  $level = 'mall'; // Misalnya untuk pengguna mall
}

// Tambahkan kode lainnya untuk index.php di bawah sini
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CineTix | Riwayat Pembelian</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/seodashlogo.png" />
  <link rel="stylesheet" href="../../node_modules/simplebar/dist/simplebar.min.css">
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <!-- Link ke CSS SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">
  <link href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.dataTables.min.css" rel="stylesheet">
  <script src="https://unpkg.com/html5-qrcode"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    #manual-input {
      margin-top: 20px;
      text-align: center;
    }
    input[type="text"] {
      padding: 10px;
      width: 250px;
      font-size: 16px;
    }
    button {
      padding: 10px 15px;
      font-size: 16px;
      margin-left: 5px;
    }
  </style>

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
      $sql = "SELECT * FROM transactions ORDER BY id ASC";
      $result = $conn->query($sql);

      ?>

      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">History Pembayaran</h5>


            <div id="reader" style="width: 100%; max-width: 500px; margin: 0 auto;"></div>

<!-- Manual Input -->
<div id="manual-input">
  <p>Atau masukkan Order ID secara manual:</p>
  <input type="text" id="manualOrderId" placeholder="Masukkan Order ID">
  <button onclick="goToPrint()">Cari Tiket</button>
</div>

<script>
  // Start QR scan on page load
  window.onload = function () {
    const html5QrCode = new Html5Qrcode("reader");

    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
      html5QrCode.stop().then(() => {
        window.location.href = `print.php?order_id=${encodeURIComponent(decodedText)}`;
      }).catch(err => console.log("Stop failed", err));
    };

    const config = { fps: 10, qrbox: 250 };

    html5QrCode.start(
      { facingMode: "environment" },
      config,
      qrCodeSuccessCallback
    ).catch(err => {
      console.error("Camera start error", err);
    });
  };

  // Manual input function
  function goToPrint() {
    const orderId = document.getElementById("manualOrderId").value.trim();
    if (orderId !== "") {
      window.location.href = `print.php?order_id=${encodeURIComponent(orderId)}`;
    } else {
      alert("Masukkan Order ID terlebih dahulu.");
    }
  }

  // Trigger enter key in input
  document.getElementById("manualOrderId").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
      goToPrint();
    }
  });
</script>
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
                  





</body>
<!-- Modal Tambah Jadwal Film -->







</html>