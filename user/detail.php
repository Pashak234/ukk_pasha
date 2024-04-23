<?php
session_start();
include '../config/koneksi.php';
if (empty($_SESSION['login'])) {
  header("location:../index.php");
  exit();
}

// Ambil UserID dari sesi yang sedang aktif
$UserID = $_SESSION['UserID'];

// Ambil BukuID dari parameter URL
$BukuID = isset($_GET['BukuID']) ? $_GET['BukuID'] : 0;

// Query untuk mengambil detail buku, kategori, dan ulasan berdasarkan BukuID
$query = mysqli_query($koneksi, "SELECT buku.*, kategoribuku.NamaKategori, ulasanbuku.Ulasan, user.Username
            FROM buku
            LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
            LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
            LEFT JOIN ulasanbuku ON buku.BukuID = ulasanbuku.BukuID
            LEFT JOIN user ON ulasanbuku.UserID = user.UserID
            WHERE buku.BukuID = '$BukuID'");

if ($query) {
  $data = mysqli_fetch_assoc($query);

  // Check if the book is already in the user's collection
  $checkQuery = mysqli_query($koneksi, "SELECT * FROM koleksipribadi WHERE BukuID = '$BukuID' AND UserID = '$UserID'");
  $alreadyExists = mysqli_num_rows($checkQuery) > 0;

  // Determine the button style and text based on whether the book is already in the user's collection
  $buttonText = $alreadyExists ? "Dikoleksi" : "Koleksi";
  $buttonClass = $alreadyExists ? "btn-primary disabled" : "btn-outline-primary";

  // Define the button attributes based on the condition
  $buttonAttributes = $alreadyExists ? 'disabled' : '';
}

// Query untuk cek rating
$queryrating = mysqli_query($koneksi, "SELECT Rating FROM ulasanbuku WHERE BukuID = '$BukuID'");
$totalRatings = 0;
$numRatings = 0;

// Check if the query was successful
if ($queryrating) {
  // Loop through each rating
  while ($row = mysqli_fetch_assoc($queryrating)) {
    // Increment the total ratings and number of ratings
    $totalRatings += $row['Rating'];
    $numRatings++;
  }
}

// Calculate the average rating
$averageRating = $numRatings > 0 ? round($totalRatings / $numRatings, 1) : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>WeLibrary</title>
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Google fonts-->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <!-- <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" /> -->
  <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
  <!-- <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" /> -->
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="../css/styles.css" rel="stylesheet" />
</head>

<body>
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
    <div class="container px-5">
      <a class="navbar-brand fw-bold text-info fs-2" href="index.php?page=home">WeLibrary</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="bi-list"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <div class="">
          <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
            <li class="nav-item"><a class="nav-link me-lg-3" href="index.php?page=profile">Profil</a></li>
            <li class="nav-item"><a class="nav-link me-lg-3" href="index.php?page=koleksi">Koleksi</a></li>
          </ul>

        </div>
        <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
          <li class="nav-item"><a class="btn btn-outline-info rounded me-lg-3 fs-6" href="../config/aksi_logout.php"><i class="bi bi-box-arrow-left fw-bold"></i> Log Out</a></li>
        </ul>

      </div>
    </div>
  </nav>

  <!-- End Nav -->

  <div class="container my-5">
    <h3 class="text-center my-5">
      Detail Buku
    </h3>
    <div class="d-flex justify-content-center">
      <div class="card mb-3" style="max-width: 820px;">
        <div class="row g-0">
          <?php
          $BukuID = isset($_GET['BukuID']) ? $_GET['BukuID'] : 0;

          // Query untuk mengambil detail buku, kategori, dan ulasan berdasarkan BukuID
          $query = mysqli_query($koneksi, "SELECT buku.*, kategoribuku.NamaKategori, ulasanbuku.Ulasan, ulasanbuku.Rating, user.Username
                              FROM buku
                              LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
                              LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
                              LEFT JOIN ulasanbuku ON buku.BukuID = ulasanbuku.BukuID
                              LEFT JOIN user ON ulasanbuku.UserID = user.UserID
                              WHERE buku.BukuID = '$BukuID'");
          $data = array();
          // Check for SQL errors
          if (!$query) {
            echo "Query execution failed: " . mysqli_error($koneksi);
          } else {
            // Check if rows are found
            if (mysqli_num_rows($query) > 0) {
              // Fetch the data
              $data = mysqli_fetch_assoc($query);
            } else {
              echo "No rows found for BukuID: $BukuID";
            }
          }


          ?>

          <?php if ($data) : ?>
            <div class="col-md-4">
              <img src="../assets/covers/<?php echo $data['CoverBuku']; ?>" class="img-fluid rounded-start object-fit-fill" alt="Cover">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6">
                    <h4 class="card-title">
                      <?php echo $data['Judul']; ?>
                    </h4>
                    <p class="card-text">Penulis:
                      <?php echo $data['Penulis']; ?>
                    </p>
                    <p class="card-text">Terbit:
                      <?php echo $data['TahunTerbit']; ?>
                    </p>
                    <p class="card-text">Penerbit:
                      <?php echo $data['Penerbit']; ?>
                    </p>
                    <p class="card-text">Rating:
                      <span class="fw-bold"><?php echo $averageRating; ?>/10</span>
                    </p>
                  </div>
                  <div class="col-sm-6">
                    <div class="d-flex justify-content-center mt-5">
                    <a href="index.php?page=ulasan&BukuID=<?php echo $data['BukuID']; ?>" class="btn btn-lg btn-outline-info">Beri Ulasan</a>
                    </div>
                    <form class="d-flex justify-content-center mt-2" action="tambah_koleksi.php" method="post">
                      <input type="hidden" name="BukuID" value="<?php echo $BukuID; ?>">
                      <button type="submit" name="koleksi" class="btn btn-lg <?php echo $buttonClass; ?>" <?php echo $buttonAttributes; ?>><?php echo $buttonText; ?></button>
                    </form>
                  </div>
                </div>
                <h5 class="fw-bold mt-1">Ulasan</h5>
                <div class="card p-2">
                  <div class="overflow-y-scroll" style="max-height: 80px; overflow-y: auto;">
                    <?php
                    // Cek apakah ada ulasan
                    if ($data['Ulasan']) {
                      // Jika ada, tampilkan ulasan
                      do {
                        echo "<div class='my-1'>";
                        echo "<p class='fw-bold'>{$data['Username']}</p>";
                        echo "<p>{$data['Ulasan']}</p>";
                        echo "<p class='text-body-secondary'>Rating: {$data['Rating']}/10</p>"; // Ubah sesuai data yang ada
                        echo "</div>";
                      } while ($data = mysqli_fetch_assoc($query));
                    } else {
                      // Jika tidak ada ulasan
                      echo "<p>Belum ada ulasan untuk buku ini.</p>";
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          <?php else : ?>
            <p>Buku tidak ditemukan.</p>
          <?php endif; ?> 
        </div>
      </div>
    </div>
  </div>

  <!-- Footer-->
  <footer class="bg-black text-center py-5">
    <div class="container px-5">
      <div class="text-white-50 small">
        <div class="mb-2">&copy; Agung Pasha Kusuma 2023. All Rights Reserved.</div>
        <p>UKK RPL 2024</p>
      </div>
    </div>
  </footer>
  <!-- Bootstrap core JS-->
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
  <!-- * *                               SB Forms JS                               * *-->
  <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
  <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
  <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
  <!-- Search Javascript -->
  <script>
    $(document).ready(function() {
      // Ketika tombol pencarian diklik
      $('#search-button').click(function() {
        var searchQuery = $('#search-input').val(); // Dapatkan nilai pencarian

        // Kirim permintaan AJAX ke server
        $.ajax({
          url: 'search.php',
          method: 'POST',
          data: {
            query: searchQuery
          },
          success: function(response) {
            $('#search-results').html(response); // Tampilkan hasil pencarian di dalam #search-results
          }
        });
      });
    });
  </script>
</body>

</html>