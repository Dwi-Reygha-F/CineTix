<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
    /* Styling untuk input pencarian */
#searchMovie {
    width: 250px; /* Atur lebar input */
    padding: 8px 35px 8px 10px; /* Padding agar teks tidak terlalu mepet */
  
}

/* Posisi ikon search */
.search-container {
    position: relative;
    display: inline-block;
}

.search-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: gray;
    cursor: pointer;
}

/* Styling dropdown hasil pencarian */
#movieResults {
    position: absolute; /* Biar tampil di atas elemen lain */
    width: 100%; /* Sejajar dengan input */
    background: white;
    border: 1px solid #ddd;
    border-top: none;
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 200px;
    overflow-y: auto;
    z-index: 9999; /* Pastikan ini cukup tinggi */
  
}

/* Hover effect */
#movieResults li:hover {
    background: #f1f1f1;
}


/* Styling untuk setiap hasil pencarian */
#movieResults li {
    padding: 10px;
    cursor: pointer;
    transition: background 0.2s;
    display: flex;
    align-items: center;
}

/* Hover effect */
#movieResults li:hover {
    background: #f1f1f1;
}
body{
                overflow-x: hidden;
            }
            .nav-item .btn {
    max-width: 150px; /* Sesuaikan dengan kebutuhan */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

</style>

<div class="container-fluid nav-bar p-0">
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
        <a href="index.php" class="navbar-brand p-0">
            <h1 class="display-3 text-secondary m-0 d-flex align-items-center">
                <img src="img/logo.png" class="img-fluid me-2" alt="" style="height: 120px;">
                <span style="font-size: 3rem;">CineTix</span>
            </h1>


        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php" class="nav-item nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>">Home</a>
                <a href="coming-soon.php" class="nav-item nav-link <?= $current_page == 'coming-soon.php' ? 'active' : '' ?>">Upcoming</a>
                <a href="theater.php" class="nav-item nav-link <?= $current_page == 'theater.php' ? 'active' : '' ?>">Theater</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link <?= in_array($current_page, ['usia.php']) ? 'active' : '' ?>" data-bs-toggle="dropdown"><span class="dropdown-toggle">Usia</span></a>
                    <div class="dropdown-menu m-0">
                        <a href="usia.php?usia=SU" class="dropdown-item">SU</a>
                        <a href="usia.php?usia=13" class="dropdown-item">13</a>
                        <a href="usia.php?usia=17" class="dropdown-item">17</a>
                    </div>
                </div>

                <div class="nav-item dropdown">
                    <a class="nav-link  <?= in_array($current_page, ['genre.php']) ? 'active' : '' ?>" href="#" id="genreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                    <span class="dropdown-toggle">Genre</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="genreDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;">
                        <div class="row px-3">
                            <div class="col-12">
                                <ul class="list-unstyled">
                                    <li><a class="dropdown-item" href="genre.php?genre=Action">Action</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Adventure">Adventure</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Animation">Animation</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Biography">Biography</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Comedy">Comedy</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Crime">Crime</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Disaster">Disaster</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Documentary">Documentary</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Drama">Drama</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Epic">Epic</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Erotic">Erotic</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Experimental">Experimental</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Family">Family</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Fantasy">Fantasy</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Film-Noir">Film-Noir</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=History">History</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Horror">Horror</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Martial Arts">Martial Arts</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Music">Music</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Musical">Musical</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Mystery">Mystery</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Political">Political</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Psychological">Psychological</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Romance">Romance</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Sci-Fi">Sci-Fi</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Sport">Sport</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Superhero">Superhero</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Survival">Survival</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Thriller">Thriller</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=War">War</a></li>
                                    <li><a class="dropdown-item" href="genre.php?genre=Western">Western</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            
            <div class="relative w-64">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
    <input type="text" id="searchMovie" class="w-full border border-gray-300 rounded-md p-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari film..." autocomplete="off"/>

    
    <!-- Dropdown hasil pencarian -->
    <ul id="movieResults" class="absolute bg-white border border-gray-300 rounded-md w-full mt-1 shadow-md hidden overflow-y-auto max-h-52 z-50"></ul>
</div>







            <?php if (isset($_SESSION['name'])): ?>
                <div class="nav-item dropdown">
                    <a href="#" class="btn btn-primary border-secondary rounded-pill py-2 px-4 px-lg-3 mb-3 mb-md-3 mb-lg-0 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Hi, <?php echo htmlspecialchars($_SESSION['name']); ?></a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="riwayat.php?username=<?php echo $_SESSION['email']; ?>">Riwayat Transaksi</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="authentication-login.php" class="btn btn-primary border-secondary rounded-pill py-2 px-4 px-lg-3 mb-3 mb-md-3 mb-lg-0 <?= $current_page == 'authentication-login.php' ? 'active' : '' ?>">Login</a>
            <?php endif; ?>
        </div>
    </nav>
</div>

<script>
const searchInput = document.getElementById("searchMovie");
const resultsList = document.getElementById("movieResults");

searchInput.addEventListener("input", function() {
    const query = this.value.trim();
    resultsList.innerHTML = "";

    if (query.length > 0) {
        fetch(`get_movies.php?q=${query}`)
            .then(response => response.json())
            .then(data => {
                resultsList.classList.toggle("hidden", data.length === 0);
                resultsList.innerHTML = ""; // Hapus hasil lama

                data.forEach(movie => {
                    const li = document.createElement("li");
                    li.textContent = movie.nama_film;
                    li.className = "p-2 hover:bg-blue-100 cursor-pointer transition-all duration-200";
                    
                    // Ketika diklik, redirect ke film.php?id=...
                    li.onclick = () => {
                        window.location.href = `film.php?id=${movie.id}`;
                    };

                    resultsList.appendChild(li);
                });
            })
            .catch(error => console.error("Error fetching data:", error));
    } else {
        resultsList.classList.add("hidden");
    }
});

// Sembunyikan dropdown kalau klik di luar
document.addEventListener("click", function (e) {
    if (!searchInput.contains(e.target) && !resultsList.contains(e.target)) {
        resultsList.classList.add("hidden");
    }
});
</script>