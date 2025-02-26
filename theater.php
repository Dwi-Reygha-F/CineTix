<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>CineTix | Theater</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
            <meta content="" name="keywords">
        <meta content="" name="description">

<link rel="shortcut icon" href="img/logo.png" type="image/x-icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        <style>
            @media (max-width: 768px) {
    .carousel-header img {
        height: 200px;
        object-fit: cover;
    }

    .service-item {
        text-align: center;
    }

    .service-title-name .bg-primary {
        margin: auto;
    }

    .office-item {
        text-align: center;
    }

    .office-content h4, .office-content a, .office-content p {
        text-align: center;
    }
}

        </style>
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-secondary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Topbar Start -->
       
        <!-- Topbar End -->

        <!-- Navbar & Hero Start -->
        <?php include 'components/sidebar.php' ?>
        <!-- Navbar & Hero End -->


        <!-- Carousel Start -->
        <div class="container-fluid">
  
</div>



        <!-- Carousel End -->


        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h4 class="modal-title text-secondary mb-0" id="exampleModalLabel">Search by keyword</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->

        <!-- Services Start -->
        <?php
include 'koneksi.php'; // Menghubungkan ke database

// Query untuk mengambil data dari tabel akun_mall
$sql = "SELECT * FROM akun_mall ORDER BY id ASC";
$result = $conn->query($sql);

// Memulai output HTML
?>

<div class="container-fluid service overflow-hidden pt-5">
    <div class="container py-5">
        <div class="section-title text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h5 class="sub-title text-primary px-3">Theater</h5>
            </div>
            <h1 class="display-5 mb-4">Temukan bioskop terbaik untuk menikmati film favoritmu!</h1>
        </div>
        
        <div class="row g-4 wow fadeInUp">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered" style="background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                        <thead class="text-white" style="background-color: #dc3545;"> <!-- Warna merah -->
                            <tr>
                                <th>No</th>
                                <th>Nama Mall</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama_mall']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                  </div>
            </div>
        </div>
    </div>
</div>


<?php
$conn->close();
?>
        <!-- Services End -->
       
        <!-- Features Start -->
        <!-- Contact Start -->
        
        <!-- Contact End -->


        <!-- Footer Start -->
        <?php include'components/footer.php' ?>
        <!-- Footer End -->

        
        <!-- Copyright Start -->
      
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

</html>