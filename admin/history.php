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


            <div class="table-responsive">
              <table id="filmTable" class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Email</th>
                    <th>Nama Film</th>
                    <th>Nomer Kursi</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Jenis Pembayaran</th>
                    <th>Harga</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>
                  <td>{$no}</td>
                  <td>{$row['order_id']}</td>
                  <td>{$row['username']}</td>
                  <td>{$row['nama_film']}</td>
                  <td>{$row['seat_number']}</td>
                  <td>{$row['transaction_time']}</td>
                  <td>{$row['payment_type']}</td>
                  <td>Rp.{$row['amount']}</td>
                  <td>";

                      // Menggunakan if untuk mengecek status
                      if ($row['status'] == 'settlement') {
                        echo 'Selesai';
                      } elseif ($row['status'] == 'pending') {
                        echo 'Menunggu Pembayaran';
                      } else {
                        echo $row['status']; // Jika status selain 'settlement' atau 'Pending'
                      }

                      echo "</td>
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
  <script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.print.min.js"></script>


  <script>
    $(document).ready(function() {
      $('#filmTable').DataTable({
        dom: 'Bfrtip', // Menampilkan tombol di atas tabel
        buttons: [
          'copy', // Salin ke clipboard
          'excel', // Ekspor ke Excel
          'csv', // Ekspor ke CSV
          'pdf', // Ekspor ke PDF
          'print' // Cetak
        ]
      });
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
        <form id="formTambahJadwal">

          <div class="mb-3">
            <label for="namaMall" class="form-label">Nama Admin</label>
            <input type="text" class="form-control" id="nama" name="nama">
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>



          <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>

        </form>
      </div>
    </div>
  </div>
</div>






</html>