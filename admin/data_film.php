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
  <title>CineTix | Data Film </title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/seodashlogo.png" />
  <link rel="stylesheet" href="../../node_modules/simplebar/dist/simplebar.min.css">
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
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

      // Query untuk mengambil data film
      $sql = "SELECT * FROM film ORDER BY id ASC";
      $result = $conn->query($sql);
      $no = 1;
      ?>

<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Data Film</h5>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputFilmModal">
        Tambah Data Film
      </button>

      <div class="table-responsive">
        <table id="filmTable" class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Poster</th>
              <th>Nama Film</th>
              <th>Deskripsi</th>
              <th>Genre</th>
              <th>Total Menit</th>
              <th>Usia</th>
              <th>Dimensi</th>
              <th>Producer</th>
              <th>Director</th>
              <th>Writer</th>
              <th>Cast</th>
              <th>Distributor</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($no++) ?></td>
                  <td>
                    <?php if (!empty($row['poster'])): ?>
                      <img src="../<?= htmlspecialchars($row['poster']) ?>" alt="Poster" style="width: 100px; height: auto;" />
                    <?php else: ?>
                      <span class="text-muted">Tidak ada poster</span>
                    <?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars($row['nama_film']) ?></td>
                  <td>
                    <div class="description-container">
                      <div class="description-short">
                        <?= htmlspecialchars(substr($row['judul'], 0, 100)) ?>...
                      </div>
                      <div class="description-full d-none">
                        <?= htmlspecialchars($row['judul']) ?>
                      </div>
                      <button class="btn btn-link btn-sm read-more">Read More</button>
                    </div>
                  </td>
                  <td><?= htmlspecialchars($row['genre']) ?></td>
                  <td><?= htmlspecialchars($row['total_menit']) ?></td>
                  <td><?= htmlspecialchars($row['usia']) ?></td>
                  <td><?= htmlspecialchars($row['dimensi']) ?></td>
                  <td><?= htmlspecialchars($row['Producer']) ?></td>
                  <td><?= htmlspecialchars($row['Director']) ?></td>
                  <td><?= htmlspecialchars($row['Writer']) ?></td>
                  <td>
                    <div class="cast-container">
                      <div class="cast-short">
                        <?= htmlspecialchars(substr($row['Cast'], 0, 50)) ?>...
                      </div>
                      <div class="cast-full d-none">
                        <?= htmlspecialchars($row['Cast']) ?>
                      </div>
                      <button class="btn btn-link btn-sm read-more">Read More</button>
                    </div>
                  </td>
                  <td><?= htmlspecialchars($row['Distributor']) ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="13" class="text-center">Tidak ada data tersedia</td>
              </tr>
            <?php endif; ?>
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
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".read-more");

    buttons.forEach((button) => {
      button.addEventListener("click", function () {
        const container = this.parentElement;
        const shortText = container.querySelector(".description-short, .cast-short");
        const fullText = container.querySelector(".description-full, .cast-full");

        if (fullText.classList.contains("d-none")) {
          fullText.classList.remove("d-none");
          shortText.classList.add("d-none");
          this.textContent = "Show Less";
        } else {
          fullText.classList.add("d-none");
          shortText.classList.remove("d-none");
          this.textContent = "Read More";
        }
      });
    });
  });
</script>



  <script>
    $(document).ready(function() {
      $('#filmTable').DataTable();
    });
  </script>
<script>
  const selectedGenres = new Set(); // Menggunakan Set untuk mencegah duplikasi

  function addGenre() {
    const genreSelect = document.getElementById('genreSelect');
    const selectedValue = genreSelect.value;

    if (selectedValue && !selectedGenres.has(selectedValue)) {
      selectedGenres.add(selectedValue);

      // Menambahkan genre ke daftar tampilan
      const listItem = document.createElement('li');
      listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
      listItem.textContent = selectedValue;

      // Tombol untuk menghapus genre
      const removeBtn = document.createElement('button');
      removeBtn.className = 'btn btn-sm btn-danger';
      removeBtn.textContent = 'Hapus';
      removeBtn.onclick = () => {
        selectedGenres.delete(selectedValue);
        listItem.remove();
        updateHiddenInput();
      };

      listItem.appendChild(removeBtn);
      document.getElementById('selectedGenres').appendChild(listItem);

      // Memperbarui input tersembunyi
      updateHiddenInput();
    }

    // Reset pilihan dropdown
    genreSelect.value = '';
  }

  function updateHiddenInput() {
    document.getElementById('genreInput').value = Array.from(selectedGenres).join(',');
  }
</script>

</body>
<div class="modal fade" id="inputFilmModal" tabindex="-1" aria-labelledby="inputFilmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inputFilmModalLabel">Tambah Data Film</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../proses_input.php" method="POST" enctype="multipart/form-data">
          <div class="row">
            <!-- Kolom Pertama -->
            <div class="col-md-4">
              <div class="mb-3">
                <label for="poster" class="form-label">Upload Poster</label>
                <input type="file" id="poster" name="poster" accept="image/*" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="nama_film" class="form-label">Nama Film</label>
                <input type="text" id="nama_film" name="nama_film" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <div class="d-flex">
                  <select id="genreSelect" class="form-select">
                    <option value="" disabled selected>Pilih Genre</option>
                    <option value="Action">Action</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Animation">Animation</option>
                    <option value="Biography">Biography</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Crime">Crime</option>
                    <option value="Disaster">Disaster</option>
                    <option value="Documentary">Documentary</option>
                    <option value="Drama">Drama</option>
                    <option value="Epic">Epic</option>
                    <option value="Erotic">Erotic</option>
                    <option value="Experimental">Experimental</option>
                    <option value="Family">Family</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Film-Noir">Film-Noir</option>
                    <option value="History">History</option>
                    <option value="Horror">Horror</option>
                    <option value="Martial Arts">Martial Arts</option>
                    <option value="Music">Music</option>
                    <option value="Musical">Musical</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Political">Political</option>
                    <option value="Psychological">Psychological</option>
                    <option value="Romance">Romance</option>
                    <option value="Sci-Fi">Sci-Fi</option>
                    <option value="Sport">Sport</option>
                    <option value="Superhero">Superhero</option>
                    <option value="Survival">Survival</option>
                    <option value="Thriller">Thriller</option>
                    <option value="War">War</option>
                    <option value="Western">Western</option>
                  </select>
                  <button type="button" class="btn btn-primary ms-2" onclick="addGenre()">Tambah</button>
                </div>
                <ul id="selectedGenres" class="mt-3 list-group d-flex flex-wrap" style="max-height: 200px; overflow-y: auto;"></ul>
                <input type="hidden" id="genreInput" name="genre">
              </div>
            </div>

            <!-- Kolom Kedua -->
            <div class="col-md-4">
              <div class="mb-3">
                <label for="banner" class="form-label">Upload Banner</label>
                <input type="file" id="banner" name="banner" accept="image/*" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="menit" class="form-label">Total Menit</label>
                <input type="text" id="menit" name="menit" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="usia" class="form-label">Usia</label>
                <select id="usia" name="usia" class="form-select" required>
                  <option value="" disabled selected>Pilih Usia</option>
                  <option value="13">13</option>
                  <option value="17">17</option>
                  <option value="SU">SU</option>
                </select>
              </div>
            </div>

            <!-- Kolom Ketiga -->
            <div class="col-md-4">
              <div class="mb-3">
                <label for="trailer" class="form-label">Upload Trailer</label>
                <input type="file" id="trailer" name="trailer" accept="video/*" class="form-control">
              </div>
              <div class="mb-3">
                <label for="judul" class="form-label">Deskripsi</label>
                <input type="text" id="judul" name="judul" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="dimensi" class="form-label">Berapa Dimensi</label>
                <select id="dimensi" name="dimensi" class="form-select" required>
                  <option value="" disabled selected>Pilih Dimensi</option>
                  <option value="2D">2D</option>
                  <option value="3D">3D</option>
                </select>
              </div>
            </div>
          </div>
          
          <!-- Kolom Keempat (Producer, Director, Writer, Cast, Distributor) -->
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="producer" class="form-label">Producer</label>
                <input type="text" id="producer" name="producer" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="director" class="form-label">Director</label>
                <input type="text" id="director" name="director" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="writer" class="form-label">Writer</label>
                <input type="text" id="writer" name="writer" class="form-control" required>
              </div>
            </div>
           
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="cast" class="form-label">Cast</label>
                <input type="text" id="cast" name="cast" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="distributor" class="form-label">Distributor</label>
                <input type="text" id="distributor" name="distributor" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="writer" class="form-label">Harga Per Tiket</label>
                <input type="number" id="harga" name="harga" class="form-control" required>
              </div>
            </div>
          </div>
          

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


</html>