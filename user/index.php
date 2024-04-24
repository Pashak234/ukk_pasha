<?php
session_start();
include '../config/koneksi.php';
// cek login
if($_SESSION['user_login'] != true){
    header("location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>WeLibrary</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico>">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <!-- <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" /> -->
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
    <!-- <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/home.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/main.css">
</head>

<body id="page-top">
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
          <li class="nav-item"><a class="btn btn-outline-info rounded-pill me-lg-3 fs-6" href="../config/logout.php"><i class="bi bi-box-arrow-left fw-bold"></i> Log Out</a></li>
        </ul>

      </div>
    </div>
  </nav>
  <main class="mt-5 shades">
      <div class="container px-5 mt-5">
          <!-- Mengambil halaman -->
      <?php
      if (isset($_GET['page'])) {
        $page = $_GET['page'];

        switch ($page) {
          case 'profile':
            include 'profile.php';
            break;
          case 'koleksi':
            include 'koleksi.php';
            break;
          case 'home':
            include 'home.php';
            break;
          case 'pinjam':
            include 'pinjam_buku.php';
            break;
          case 'ulasan':
            include 'tambah_ulasan.php';
            break;
          default:
            echo "Halaman tidak tersedia";
            break;
        }
      } else {
        include 'home.php';
      }

      ?>
      </div>

</main>

<!-- Footer-->
<footer class="bg-black text-center py-5" styles="">
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
  <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
  <!-- Search Javascript -->
  <script>
    $(document).ready(function(){
        $('#searchInput').keyup(function(){
            var query = $(this).val();
            $.ajax({
                url: 'search.php',
                method: 'POST',
                data: {query:query},
                success: function(response){
                    $('#bookTable').html(response);
                }
            });
        });
    });
</script>
</body>
</html>