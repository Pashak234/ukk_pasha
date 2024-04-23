<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>WeLibrary</title>
    <link rel="icon" type="image/x-icon" href="../icon.ico" />
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
                    <li class="nav-item"><a class="btn btn-outline-info rounded me-lg-3 fs-6" href="../config/aksi_logout.php"><i class="bi bi-box-arrow-left fw-bold"></i> Log Out</a></li>
                </ul>

            </div>
        </div>
    </nav>
    <?php
    include '../config/koneksi.php';

    if (isset($_GET['BukuID'])) {
        $bukuID = $_GET['BukuID'];

        // Sanitize input (consider using prepared statements)
        $bukuID = mysqli_real_escape_string($koneksi, $bukuID);

        // Retrieve borrowing status along with the book title
        $queryPeminjaman = mysqli_query($koneksi, "SELECT peminjaman.*, buku.Judul 
                                               FROM peminjaman 
                                               INNER JOIN buku ON peminjaman.BukuID = buku.BukuID 
                                               WHERE peminjaman.BukuID = '$bukuID'");

        // Check for errors
        if (!$queryPeminjaman) {
            die('Query Error: ' . mysqli_error($koneksi));
        }

        // Fetch the result
        $statusPeminjaman = mysqli_fetch_assoc($queryPeminjaman);

        if ($statusPeminjaman) {
    ?>
            <div class="container mt-5">
                <h3>Status Peminjaman Buku</h3>
                <p>Informasi Buku:</p>
                <ul>
                    <li>Judul: <?php echo $statusPeminjaman['Judul']; ?></li>
                    <li>Status Peminjaman: <?php echo $statusPeminjaman['StatusPeminjaman']; ?></li>
                    <li>Tanggal Peminjaman: <?php echo $statusPeminjaman['TanggalPeminjaman']; ?></li>
                    <li>Tanggal Pengembalian: <?php echo $statusPeminjaman['TanggalPengembalian']; ?></li>
                </ul>
                <?php
                // Check if the book is borrowed
                if ($statusPeminjaman['StatusPeminjaman'] == 'dipinjam') {
                    // Calculate the return date
                    $tanggalPengembalian = date('Y-m-d', strtotime($statusPeminjaman['TanggalPengembalian']));
                    $today = date('Y-m-d');
                    if ($today > $tanggalPengembalian) {
                        // Display a warning if the book is overdue
                        echo '<div class="alert alert-danger" role="alert">Mohon kembalikan buku, Anda akan terkena denda bila melewati waktu pengembalian yang ditentukan.</div>';
                    } else {
                        // Display a notice with the return date
                        echo '<div class="alert alert-warning" role="alert">Mohon kembalikan buku pada ' . $tanggalPengembalian . '</div>';
                    }
                } elseif ($statusPeminjaman['StatusPeminjaman'] == 'dipesan') {
                    // Display a notice if the book is reserved
                    echo '<div class="alert alert-info" role="alert">Buku ini sudah dipesan dan belum dipinjamkan. Mohon datang ke perpustakaan pada tanggal peminjaman untuk meminjam buku</div>';
                }
                ?>
                <a href="index.php?page=home" class="btn btn-secondary">Ke Beranda</a>
                <a href="index.php?page=profile" class="btn btn-secondary">Ke Profil</a>
                <!-- Add cancel button and modal -->
                <?php if ($statusPeminjaman && $statusPeminjaman['StatusPeminjaman'] == 'dipesan') : ?>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">Batalkan Pemesanan</button>

                    <!-- Cancel modal -->
                    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelModalLabel">Konfirmasi Pembatalan Peminjaman</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin membatalkan pemesanan buku ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <form action="batal_pesan.php" method="POST">
                                        <input type="hidden" name="bukuID" value="<?php echo $bukuID; ?>">
                                        <button type="submit" class="btn btn-danger">Batalkan Pemesanan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
    <?php
        } else {
            echo '<div class="container mt-5"><p>Buku tidak ditemukan dalam daftar peminjaman.</p></div>';
        }
    } else {
        echo '<div class="container mt-5"><p>ID Buku tidak diberikan.</p></div>';
    }
    ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
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