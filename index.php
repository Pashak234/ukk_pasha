<?php
include 'config/koneksi.php'
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
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/home.css" rel="stylesheet" />

</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
        <div class="container px-5">
            <a class="navbar-brand fw-bold text-info fs-2" href="#page-top">WeLibrary</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                    <li class="nav-item"><a class="nav-link me-lg-3" href="#features">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link me-lg-3" href="#rekomendasi">Rekomendasi</a></li>
                    <li class="nav-item"><a class="nav-link me-lg-3" href="#menubuku">Menu Buku</a></li>
                    <li class="nav-item"><a class="nav-link me-lg-3" href="registrasi.php#registrasi">Sign Up</a></li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- Mashead header-->
    <header class="masthead">
        <div class="container px-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6">
                    <!-- -->
                    <div class="mb-5 mb-lg-0 text-center text-lg-start">
                        <h1 class="display-1 lh-1 mb-3">Membaca Membuka Jendela Dunia</h1>
                        <p class="lead fw-normal text-muted mb-3">Dapatkan pengalaman membaca yang imersif dan menyenangkan</p>
                        <div class="d-flex flex-column flex-lg-row align-items-center">
                            <a href="login.php" class="btn btn-primary btn-lg rounded-pill px-3 mx-3 mb-2 mb-lg-0">
                                <span class="d-flex align-items-center">
                                    <span class="small">Log In</span>
                                </span>
                            </a>
                            <a href="registrasi.php" class="btn btn-primary btn-lg rounded-pill px-3 mx-3 mb-2 mb-lg-0">
                                <span class="d-flex align-items-center">
                                    <span class="small">Sign Up</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Foto Header-->
                    <img src="assets/img/header.png" alt="" style="width: 512px;">

                </div>
            </div>
        </div>
    </header>
    <!-- Quote/testimonial aside-->
    <aside class="text-center bg-gradient-primary-to-secondary">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-xl-8">
                    <div class="h2 fs-1 text-white mb-4">"Semua hal yang ada dalam perpustakaan konvensional dalam satu aplikasi!"</div>
                    <h3 class="text-white fs-3">WeLibrary</h3>
                </div>
            </div>
        </div>
    </aside>
    <!-- App features section-->
    <section id="features">
        <div class="container px-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-8 order-lg-1 mb-3 mb-lg-0">
                    <div class="container-fluid px-5">
                        <div class="row gx-5">
                            <div class="col-md-6 mb-5">
                                <!-- Feature item-->
                                <div class="text-center">
                                    <i class="bi bi-book icon-feature text-gradient d-block mb-3"></i>
                                    <h3 class="font-alt">Mudah Diakses</h3>
                                    <p class="text-muted mb-0">Mudah diakses dimana saja dan kapan saja</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <!-- Feature item-->
                                <div class="text-center">
                                    <i class="bi bi-calendar-check icon-feature text-gradient d-block mb-3"></i>
                                    <h3 class="font-alt">Fleksibel Digunakan</h3>
                                    <p class="text-muted mb-0">Pinjam dimana saja, buku yang dipinjam akan langsung tersedia saat anda ke perpustakaan!</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-5 mb-md-0">
                                <!-- Feature item-->
                                <div class="text-center">
                                    <i class="bi-gift icon-feature text-gradient d-block mb-3"></i>
                                    <h3 class="font-alt">Gratis</h3>
                                    <p class="text-muted mb-0">Gunakan aplikasi secara gratis, akses ke buku-buku terbaik tanpa membayar</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Feature item-->
                                <div class="text-center">
                                    <i class="bi-patch-check icon-feature text-gradient d-block mb-3"></i>
                                    <h3 class="font-alt">Buku Berkualitas</h3>
                                    <p class="text-muted mb-0">Buku-buku yang kami sediakan semuanya Berkualitas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-lg-0">
                    <!-- Features section device mockup-->
                    <div class="images">
                        <img src="assets/img/benefit.jpg" alt="" style="width: 399px;">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Rekomendasi-->
    <section id="rekomendasi" class="bg-light">
        <?php
        include 'rekomendasi.php';
        ?>
    </section>
    <!-- Buku-->
    <section id="menubuku" class="bg-light">
        <?php
        include 'daftarbuku.php';
        ?>
    </section>
    <!-- Call to action section-->
    <section id="registrasi" class="cta">
        <div class="cta-content">
            <div class="container px-5">
                <h2 class="text-white display-1 lh-1 mb-4">
                    Mari membaca.
                    <br />
                    Tambah Ilmu.
                </h2>
                <a class="btn btn-outline-light py-3 px-4 rounded-pill" href="registrasi.php" target="_blank">Sign Up Sekarang</a>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="bg-black text-center py-5">
        <div class="container px-5">
            <div class="text-white-50 small">
                <div class="mb-2">&copy; Agung Pasha Kusuma 2024. All Rights Reserved.</div>
                <p>UKK RPL 2024</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>