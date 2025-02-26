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
  <title>CineTix | Dashboard Admin</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/seodashlogo.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
   <?php include'components/sidebar.php' ?>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php include'components/header.php' ?>
      <!--  Header End -->
      <?php
include '../koneksi.php'; // Menghubungkan ke database

// Ambil bulan dan tahun sekarang
$currentMonth = date('m'); // Bulan sekarang (01-12)
$currentYear = date('Y');  // Tahun sekarang (YYYY)

// Cek apakah bulan atau tahun diubah melalui URL
if (isset($_GET['month']) && isset($_GET['year'])) {
    $currentMonth = $_GET['month'];
    $currentYear = $_GET['year'];
}

// Query untuk mengambil jumlah transaksi per hari pada bulan dan tahun yang ditentukan
$sql = "
    SELECT 
        DATE(transaction_time) AS tanggal, 
        COUNT(id) AS jumlah_transaksi 
    FROM transactions 
    WHERE YEAR(transaction_time) = $currentYear AND MONTH(transaction_time) = $currentMonth
    GROUP BY DATE(transaction_time)
    ORDER BY tanggal ASC;
";

// Mengeksekusi query
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Menyiapkan data untuk chart
$tanggal = [];
$jumlah_transaksi = [];

// Menghitung jumlah hari di bulan yang dipilih
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear); // Menghitung jumlah hari
for ($i = 1; $i <= $jumlah_hari; $i++) {
    $formatted_date = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $i); // Format tanggal

    // Cari transaksi pada tanggal tersebut
    $found = false;
    while ($row = $result->fetch_assoc()) {
        if ($row['tanggal'] == $formatted_date) {
            $tanggal[] = $row['tanggal'];
            $jumlah_transaksi[] = $row['jumlah_transaksi'];
            $found = true;
            break;
        }
    }

    // Jika tidak ditemukan transaksi pada tanggal tersebut, tambahkan tanggal dengan jumlah transaksi 0
    if (!$found) {
        $tanggal[] = $formatted_date;
        $jumlah_transaksi[] = 0;
    }

    // Reset pointer query untuk iterasi berikutnya
    $result->data_seek(0);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                        Traffic Overview
                        <span>
                            <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Traffic Overview"></iconify-icon>
                        </span>
                    </h5>
                    
                    <!-- Tombol Navigasi Bulan -->
                    <div class="d-flex justify-content-between mb-4">
                        <a href="?month=<?php echo $currentMonth - 1; ?>&year=<?php echo $currentYear; ?>" class="btn btn-primary">Bulan Sebelumnya</a>
                        <span class="h5">Bulan: <?php echo $currentMonth; ?>, Tahun: <?php echo $currentYear; ?></span>
                        <a href="?month=<?php echo $currentMonth + 1; ?>&year=<?php echo $currentYear; ?>" class="btn btn-primary">Bulan Berikutnya</a>
                    </div>
                    
                   
                        <canvas id="trafficChart"></canvas> <!-- Chart.js Canvas -->
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil data dari PHP ke JavaScript
    const tanggal = <?php echo json_encode($tanggal); ?>;
    const jumlahTransaksi = <?php echo json_encode($jumlah_transaksi); ?>;

    // Konfigurasi Chart.js
    const ctx = document.getElementById('trafficChart').getContext('2d');
    const trafficChart = new Chart(ctx, {
        type: 'line', // Jenis chart (line chart)
        data: {
            labels: tanggal, // Data label tanggal
            datasets: [{
                label: 'Jumlah Transaksi',
                data: jumlahTransaksi, // Data jumlah transaksi
                fill: false,
                borderColor: '#007bff',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi'
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>

    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>