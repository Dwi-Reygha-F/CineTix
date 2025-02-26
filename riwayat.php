<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CineTix | Riwayat Pembelian</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-secondary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Navbar & Hero Start -->
    <?php include 'components/sidebar.php';
    $username = $_SESSION['email'];
   
    ?>
    <!-- Navbar & Hero End -->

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <?php
                // Mengambil username dari URL
                $username = isset($_GET['username']) ? $_GET['username'] : '';

                // Query untuk mengambil data transaksi berdasarkan username
                $sql = "SELECT * FROM transactions WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);  // Pastikan tipe parameter sesuai dengan jenis data (string untuk username)
                $stmt->execute();
                $result = $stmt->get_result();
                ?>

                <div class="table table-responsive">
                    <table id="transactionTable" class="table table-bordered">
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
                            $no = 1; // Nomor urut untuk tabel
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
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (if not already included) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
   

    <?php include 'components/footer.php' ?>

    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#transactionTable').DataTable();
        });
    </script>
</body>
</html>
