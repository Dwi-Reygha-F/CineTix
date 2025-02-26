<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CineTix | Halaman Utama</title>
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

            .office-content h4,
            .office-content a,
            .office-content p {
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <!-- Spinner Start -->
  
    <!-- Spinner End -->


    <!-- Topbar Start -->

    <!-- Topbar End -->

    <!-- Navbar & Hero Start -->
    <?php include 'components/sidebar.php' ?>
    <!-- Navbar & Hero End -->

    <?php
    include 'koneksi.php'; // Menghubungkan ke database

    // Ambil tanggal hari ini dalam format YYYY-MM-DD
    $tanggal_hari_ini = date('Y-m-d');

    // Query untuk mengambil film yang akan tayang (tanggal tayang belum lewat dan tidak termasuk hari ini)
    $sql = "SELECT f.id, f.nama_film, f.banner, f.usia, MIN(j.tanggal_tayang) AS tanggal_tayang
        FROM film f
        INNER JOIN jadwal_film j ON f.id = j.film_id
        WHERE j.tanggal_tayang > ?  -- Hanya ambil film dengan tanggal lebih besar dari hari ini
        GROUP BY f.id, f.nama_film, f.banner, f.usia
        ORDER BY tanggal_tayang ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tanggal_hari_ini);
    $stmt->execute();
    $result = $stmt->get_result();

    $films = [];
    while ($row = $result->fetch_assoc()) {
        $films[] = $row;
    }
    ?>


    <!-- Carousel Start -->
    <div class="container-fluid">
    <?php if (!empty($films)): ?>
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <?php foreach ($films as $index => $film): ?>
                    <li data-bs-target="#carouselId" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
                <?php endforeach; ?>
            </ol>
            <div class="carousel-inner">
                <?php foreach ($films as $index => $film): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= $film['banner'] ?>" class="d-block w-100 carousel-img" alt="Coming Soon">
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-secondary" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-secondary" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    <?php endif; ?>
</div>


    <style>
        /* Untuk layar kecil, kurangi tinggi agar tidak terlalu besar */
        @media (max-width: 768px) {
            .carousel-img {
                height: 50vh;
            }
        }
    </style>

    <!-- Carousel End -->


    <!-- Modal Search Start -->

    <!-- Modal Search End -->

    <!-- Services Start -->
    <?php
include 'koneksi.php'; // Menghubungkan ke database

// Mengecek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil 10 film teratas berdasarkan jumlah transaksi berdasarkan nama_film
$sql = "
    SELECT f.id, f.nama_film, f.poster, f.usia, COUNT(t.id) AS jumlah_transaksi
    FROM film f
    LEFT JOIN transactions t ON f.nama_film = t.nama_film
    GROUP BY f.id, f.nama_film, f.poster, f.usia
    ORDER BY jumlah_transaksi DESC
    LIMIT 10
";

// Mengecek apakah query berhasil
$result = $conn->query($sql);

if (!$result) {
    // Jika query gagal, tampilkan error
    die("Query failed: " . $conn->error);
}

// Mengecek apakah ada hasil dari query
if ($result->num_rows == 0) {
    echo "Tidak ada data yang ditemukan.";
} else {
    // Memulai output HTML
    ?>

    <div class="container-fluid service overflow-hidden pt-5">
        <div class="container py-5">
            <div class="section-title text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h5 class="sub-title text-primary px-3">Now Playing</h5>
                </div>
                <h1 class="display-5 mb-4">TOP 10 Film Teratas</h1>
            </div>
            <div class="row g-4">
                <?php 
                $rank = 1; // Menambahkan peringkat
                while ($row = $result->fetch_assoc()): ?>
                    <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item">
                            <div class="service-inner">
                                <div class="service-img">
                                    <img src="<?php echo $row['poster']; ?>" class="img-fluid w-100 rounded" alt="Image">
                                </div>
                                <div class="service-title">
                                    <div class="service-title-name">
                                        <div class="bg-primary text-center rounded p-3 mx-5 mb-4">
                                            <h4 class="h4 text-white mb-0">#<?php echo $rank; ?> - <?php echo $row['nama_film']; ?></h4>
                                        </div>
                                        <a class="btn bg-light text-secondary rounded-pill py-3 px-5 mb-4">Explore More</a>
                                    </div>
                                    <div class="service-content pb-4">
                                        <h4 class="text-white mb-4 py-3"><?php echo $row['nama_film']; ?></h4>
                                        <div class="px-4">
                                            <p class="mb-4"><?php echo $row['usia']; ?>+</p>
                                         
                                            <a class="btn bg-light text-secondary rounded-pill py-3 px-5 mb-4" href="film.php?id=<?php echo $row['id']; ?>">Explore More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                $rank++; // Menambah peringkat
                endwhile; ?>
            </div>
        </div>
    </div>

    <?php
}
?>



    <?php
    $conn->close();
    ?>
    <!-- Services End -->

    <!-- Features Start -->
    <!-- Contact Start -->

    <!-- Contact End -->


    <!-- Footer Start -->
    <?php include 'components/footer.php' ?>
    <!-- Footer End -->


    <!-- Copyright Start -->

    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>
    <script>
        console.log([...document.querySelectorAll('*')].filter(el => el.scrollWidth > document.documentElement.clientWidth));
    </script>

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