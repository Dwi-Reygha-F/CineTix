<?php
include 'koneksi.php';

// Mengambil ID film dari URL
$id_film = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mengambil data film berdasarkan ID (termasuk harga tiket)
$sql = "SELECT * FROM film WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_film);
$stmt->execute();
$result = $stmt->get_result();

// Memeriksa apakah film ditemukan
if ($result->num_rows > 0) {
    $film = $result->fetch_assoc();
    $harga_tiket = $film['harga']; // Mengambil harga tiket dari tabel film
} else {
    echo "Film tidak ditemukan.";
    exit;
}

// Query untuk mengambil data jadwal film berdasarkan ID film
$sql_jadwal = "
    SELECT jadwal_film.*, akun_mall.nama_mall
    FROM jadwal_film
    INNER JOIN akun_mall ON jadwal_film.mall_id = akun_mall.id
    WHERE jadwal_film.film_id = ? AND CURDATE() BETWEEN jadwal_film.tanggal_tayang AND jadwal_film.tanggal_akhir_tayang
";
$stmt_jadwal = $conn->prepare($sql_jadwal);
$stmt_jadwal->bind_param("i", $id_film);
$stmt_jadwal->execute();
$jadwal_result = $stmt_jadwal->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CineTix | Jadwal Film</title>
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
        body {
            background-color: #f5f5f5;
        }

        .card {
            border: none;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .showtime-btn {
            border: 1px solid #d1d1d1;
            border-radius: 5px;
            padding: 5px 10px;
            margin-top: 10px;
            display: inline-block;
        }

        .showtime-btn:hover {
            background-color: #f0f0f0;
        }

        .cinema-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-top: 1px solid #d1d1d1;
        }

        .cinema-info:first-child {
            border-top: none;
        }

        .cinema-info {
            display: flex;
            margin-right: 450px;
            flex-direction: column;
            /* Ubah menjadi kolom untuk menampilkan elemen vertikal */
            gap: 15px;
            /* Jarak antara setiap jadwal */
        }

        .showtime-btn {
            display: inline-block;
            /* Pertahankan agar tombol tampil sebagai blok terpisah */
            margin-right: 10px;
            /* Tambahkan jarak antar waktu tayang */
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
    <!-- Navbar & Hero Start -->
    <?php include 'components/sidebar.php';
    $username = isset($_SESSION['email']) ? $_SESSION['email'] : null;

    ?>
    <!-- Navbar & Hero End -->
    <style>
        .cinema-info {
            display: flex;
            margin-right: 450px;
            flex-direction: column;
            /* Ubah menjadi kolom untuk menampilkan elemen vertikal */
            gap: 15px;
            /* Jarak antara setiap jadwal */
        }

        .showtime-btn {
            display: inline-block;
            /* Pertahankan agar tombol tampil sebagai blok terpisah */
            margin-right: 10px;
            /* Tambahkan jarak antar waktu tayang */
        }
    </style>

    <div class="container mt-5">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?php echo $film['poster'] ?>" class="img-fluid rounded-start" alt="Film Poster">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $film['nama_film'] ?></h5>
                        <p class="card-text"><i class="fas fa-clock"></i> <?php echo $film['total_menit'] ?> Minutes</p>
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-secondary btn-sm"><?php echo $film['dimensi'] ?></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm"><?php echo $film['usia'] ?></button>
                        </div>
                        <?php if ($jadwal_result->num_rows > 0): ?>
                            <?php while ($jadwal = $jadwal_result->fetch_assoc()): ?>
                                <?php
                                $today = date('Y-m-d');
                                $tanggal_tayang = date('Y-m-d', strtotime($jadwal['tanggal_tayang']));
                                $tanggal_akhir_tayang = date('Y-m-d', strtotime($jadwal['tanggal_akhir_tayang']));
                                ?>

                                <?php if ($tanggal_tayang <= $today && $tanggal_akhir_tayang >= $today): ?>
                                    <h6 class="mb-1"><?php echo $jadwal['nama_mall']; ?></h6>
                                    <p class="mb-1"><?php echo date('d-m-Y', strtotime($today)); ?></p>
                                    <?php if ($jadwal['jam_tayang_1']): ?>
                                        <button type="button" class="btn btn-primary showtime-btn"
                                            data-bs-jam="<?php echo date('H:i', strtotime($jadwal['jam_tayang_1'])); ?>"
                                            data-bs-mall="<?php echo $jadwal['nama_mall']; ?>"
                                            data-bs-toggle="modal" data-bs-target="#ticketModal">
                                            <?php echo date('H:i', strtotime($jadwal['jam_tayang_1'])); ?>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($jadwal['jam_tayang_2']): ?>
                                        <button type="button" class="btn btn-primary showtime-btn"
                                            data-bs-jam="<?php echo date('H:i', strtotime($jadwal['jam_tayang_2'])); ?>"
                                            data-bs-mall="<?php echo $jadwal['nama_mall']; ?>"
                                            data-bs-toggle="modal" data-bs-target="#ticketModal">
                                            <?php echo date('H:i', strtotime($jadwal['jam_tayang_2'])); ?>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($jadwal['jam_tayang_3']): ?>
                                        <button type="button" class="btn btn-primary showtime-btn"
                                            data-bs-jam="<?php echo date('H:i', strtotime($jadwal['jam_tayang_3'])); ?>"
                                            data-bs-mall="<?php echo $jadwal['nama_mall']; ?>"
                                            data-bs-toggle="modal" data-bs-target="#ticketModal">
                                            <?php echo date('H:i', strtotime($jadwal['jam_tayang_3'])); ?>
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <?php
                            $id_film = isset($_GET['id']) ? intval($_GET['id']) : 0;

                            // Query ulang untuk mendapatkan tanggal tayang pertama jika tidak ada jadwal aktif
                            $jadwal_film = $conn->query("SELECT MIN(tanggal_tayang) as tanggal_terdekat FROM jadwal_film WHERE film_id = {$id_film}");
                            $row = $jadwal_film->fetch_assoc();
                            $tanggal_terdekat = $row['tanggal_terdekat'] ?? null;

                            // Jika tidak ada tanggal yang valid, tampilkan pesan "Belum Ada Jadwal"
                            if ($tanggal_terdekat) {
                                echo "<p>Jadwal Akan Tersedia Pada Tanggal: " . date('d-m-Y', strtotime($tanggal_terdekat)) . "</p>";
                            } else {
                                echo "<p>Belum Ada Jadwal</p>";
                            }
                            ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include Bootstrap JS (if not already included) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>


    <?php include 'components/footer.php' ?>

    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>






</body>
<!-- Script di akhir body -->
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketModalLabel">Pilih Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Film: </strong><span><?php echo $film['nama_film'] ?></span></p>
                <p><strong>Nama Mall:</strong> <span id="mallName"></span></p>
                <p><strong>Jam Tayang:</strong> <span id="showtime"></span></p>

                <p><strong>Harga Per Tiket:</strong> Rp <span id="ticketPrice"><?php echo number_format($harga_tiket, 0, ',', '.'); ?></span></p>

                <div class="form-group">
                    <label for="ticketCount">Jumlah Tiket</label>
                    <input type="number" class="form-control" id="ticketCount" readonly value="0">
                </div>
                <div class="form-group">
                    <label for="ticketCount">Total Harga Tiket</label>
                    <input type="text" class="form-control" id="hargatiket" readonly>
                </div>


                <div class="form-group">
                    <label for="seatSelection">Pilih Kursi</label>
                    <div id="seatSelection" class="d-flex flex-wrap gap-2"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="bookTicket">Pesan Tiket</button>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-V5H9kOqUHT5-hd80"></script>


<script>
    var username = "<?php echo $username; ?>"; // Username dari PHP session


    if (!username) {
        Swal.fire({
            icon: 'warning',
            title: 'Anda belum login',
            text: 'Login terlebih dahulu untuk melanjutkan.',
            confirmButtonText: 'Ke Halaman Login'
        }).then(() => {
            window.location.href = "authentication-login.php"; // Redirect ke halaman login
        });
    } else {
        document.addEventListener('DOMContentLoaded', function() {

            var ticketModal = document.getElementById('ticketModal');

            if (ticketModal) {
                var modalShown = false;

                ticketModal.addEventListener('show.bs.modal', function(event) {
                    if (modalShown) return;
                    modalShown = true;

                    var button = event.relatedTarget;
                    var mallName = button.getAttribute('data-bs-mall');
                    var showtime = button.getAttribute('data-bs-jam');

                    var mallNameElement = ticketModal.querySelector('#mallName');
                    var showtimeElement = ticketModal.querySelector('#showtime');

                    if (mallNameElement && showtimeElement) {
                        mallNameElement.textContent = mallName;
                        showtimeElement.textContent = showtime;
                    }

                    let seatContainer = document.getElementById("seatSelection");
                    seatContainer.innerHTML = "";

                    let seatWrapper = document.createElement("div");
                    seatWrapper.classList.add("seat-wrapper", "d-flex", "flex-column", "align-items-center");

                    let seatRows = [{
                            row: "A",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "B",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "C",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "D",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "E",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "F",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "G",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        {
                            row: "H",
                            seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    ];

                    seatRows.forEach(group => {
                        let row = document.createElement("div");
                        row.classList.add("d-flex", "justify-content-center", "mb-3");

                        // Kelompok pertama: A1, A2, A3
                        for (let i = 0; i < 3; i++) {
                            let seatDiv = document.createElement("div");
                            seatDiv.classList.add("seat", "btn", "btn-outline-primary", "m-1", "btn-sm");
                            seatDiv.setAttribute("data-seat", `${group.row}${group.seats[i]}`);
                            seatDiv.textContent = `${group.row}${group.seats[i]}`;
                            seatDiv.addEventListener("click", function() {
                                if (!this.classList.contains("btn-danger")) {
                                    this.classList.toggle("btn-primary");
                                    updatePrice();
                                }
                            });
                            row.appendChild(seatDiv);
                        }

                        // Tambahkan spacer setelah kelompok pertama
                        let spacer1 = document.createElement("div");
                        spacer1.classList.add("mx-4"); // Atur jarak sesuai kebutuhan
                        row.appendChild(spacer1);

                        // Kelompok kedua: A4, A5, A6, A7
                        for (let i = 3; i < 7; i++) {
                            let seatDiv = document.createElement("div");
                            seatDiv.classList.add("seat", "btn", "btn-outline-primary", "m-1", "btn-sm");
                            seatDiv.setAttribute("data-seat", `${group.row}${group.seats[i]}`);
                            seatDiv.textContent = `${group.row}${group.seats[i]}`;
                            seatDiv.addEventListener("click", function() {
                                if (!this.classList.contains("btn-danger")) {
                                    this.classList.toggle("btn-primary");
                                    updatePrice();
                                }
                            });
                            row.appendChild(seatDiv);
                        }

                        // Tambahkan spacer setelah kelompok kedua
                        let spacer2 = document.createElement("div");
                        spacer2.classList.add("mx-4"); // Atur jarak sesuai kebutuhan
                        row.appendChild(spacer2);

                        // Kelompok ketiga: A8, A9, A10
                        for (let i = 7; i < 10; i++) {
                            let seatDiv = document.createElement("div");
                            seatDiv.classList.add("seat", "btn", "btn-outline-primary", "m-1", "btn-sm");
                            seatDiv.setAttribute("data-seat", `${group.row}${group.seats[i]}`);
                            seatDiv.textContent = `${group.row}${group.seats[i]}`;
                            seatDiv.addEventListener("click", function() {
                                if (!this.classList.contains("btn-danger")) {
                                    this.classList.toggle("btn-primary");
                                    updatePrice();
                                }
                            });
                            row.appendChild(seatDiv);
                        }

                        seatWrapper.appendChild(row);
                    });

                    seatContainer.appendChild(seatWrapper);

                    seatContainer.appendChild(seatWrapper);
                    let ticketPriceElement = document.getElementById("ticketPrice");
                    let ticketCountInput = document.getElementById("ticketCount");
                    let totalPriceInput = document.getElementById("hargatiket"); // Ambil input form total harga tiket

                    if (ticketPriceElement && totalPriceInput) {
                        let ticketPrice = parseInt(ticketPriceElement.textContent.replace(/\./g, ""));

                        function updatePrice() {
                            let selectedSeats = document.querySelectorAll(".seat.btn-primary");
                            let totalTickets = selectedSeats.length;
                            let totalPrice = totalTickets * ticketPrice;

                            ticketCountInput.value = totalTickets;
                            totalPriceInput.value = "Rp " + totalPrice.toLocaleString("id-ID");
                        }
                    }
                    let filmName = document.querySelector("#ticketModal span").textContent.trim();
                    fetch(`fetch_seats.php?mall_name=${encodeURIComponent(mallName)}&film_name=${encodeURIComponent(filmName)}`)
                        .then(response => response.json())
                        .then(data => {
                            let occupiedSeats = data.occupiedSeats || [];
                            seatRows.forEach(group => {
                                group.seats.forEach(seat => {
                                    let seatNumber = `${group.row}${seat}`;
                                    let seatDiv = document.querySelector(`[data-seat='${seatNumber}']`);

                                    if (occupiedSeats.includes(seatNumber)) {
                                        seatDiv.classList.add("btn-danger", "disabled");
                                    }
                                });
                            });
                        })
                        .catch(error => console.error("Error fetching seat status:", error));
                });

            }

            document.getElementById("bookTicket").addEventListener("click", function() {
                let mallName = document.getElementById("mallName").textContent.trim();
                let filmName = document.querySelector("#ticketModal span").textContent.trim();
                let showtime = document.getElementById("showtime").textContent.trim();
                let price = parseInt(document.getElementById("ticketPrice").textContent.replace(/\./g, ""));
                let selectedSeats = document.querySelectorAll(".seat.btn-primary");
                let ticketCount = selectedSeats.length;
                let totalPrice = price * ticketCount;

                if (ticketCount === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Pilih Kursi',
                        text: 'Silakan pilih kursi terlebih dahulu.',
                        confirmButtonText: 'Tutup'
                    });
                    return;
                }

                let seatNumbers = Array.from(selectedSeats).map(seat => seat.getAttribute("data-seat")).join(",");


                fetch("insert_seat.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `seat_number=${seatNumbers}&mall_name=${mallName}&film_name=${filmName}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            selectedSeats.forEach(seat => {
                                seat.classList.remove("btn-outline-primary");
                                seat.classList.add("btn-danger", "disabled");
                            });

                            // Proceed to payment
                            $.ajax({
                                url: "process_transaction.php",
                                type: "POST",
                                data: {
                                    mall_name: mallName,
                                    showtime: showtime,
                                    ticket_count: ticketCount,
                                    total_price: totalPrice,
                                    seat_number: seatNumbers,
                                    username: username
                                },
                                success: function(response) {
                                    console.log("Response from process_transaction.php: ", response);
                                    let data = JSON.parse(response);
                                    if (data.snap_token) {
                                        window.snap.pay(data.snap_token, {
                                            onSuccess: function(result) {
                                                console.log("Payment Success Result: ", result);
                                                saveTransaction(result, seatNumbers, username);
                                            },
                                            onPending: function(result) {
                                                console.log("Payment Pending Result: ", result);
                                                saveTransaction(result, seatNumbers, username);
                                            },
                                            onError: function(result) {
                                                console.log("Payment Error Result: ", result);
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Pembayaran Gagal',
                                                    text: 'Ada masalah dengan pembayaran.',
                                                    confirmButtonText: 'Coba Lagi'
                                                });
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Token Pembayaran Gagal',
                                            text: 'Gagal mendapatkan token pembayaran.',
                                            confirmButtonText: 'Tutup'
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log("Error in AJAX request: ", error);
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memesan Tiket',
                                text: 'Terjadi kesalahan saat memesan tiket.',
                                confirmButtonText: 'Coba Lagi'
                            });
                        }
                    })
                    .catch(error => console.error("Error inserting seat:", error));
            });
        });

        function saveTransaction(transactionData, seatNumber, username) {
            let filmName = document.querySelector("#ticketModal span").textContent.trim();
            transactionData.seat_number = seatNumber;
            transactionData.film_name = filmName; // Menambahkan nama film ke dalam data transaksi
            transactionData.username = username;

            console.log("Saving transaction: ", transactionData); // Debugging log untuk memeriksa data yang dikirim
            console.log("dnakwnkd Name: ", filmName);
            $.ajax({
                url: "save_transaction.php",
                type: "POST",
                data: transactionData,
                success: function(response) {
                    console.log("Response from save_transaction.php: ", response);
                    // Setelah berhasil, lakukan update kursi menjadi 'occupied'
                    $.ajax({
                        url: "update_seat_status.php",
                        type: "POST",
                        data: {
                            seat_number: seatNumber,
                            transactionData,
                            filmName // Pastikan filmName juga dikirim ke update_seat_status.php
                        },
                        success: function(updateResponse) {
                            console.log("Seat status updated: ", updateResponse);
                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran Berhasil',
                                text: 'Tiket dan kursi Anda sudah dipesan.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // Reload halaman setelah berhasil
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log("Error in updating seat status: ", error);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.log("Error in saving transaction: ", error); // Debugging error log
                }
            });
        }

    }
</script>




<!-- Modal -->


</html>