<?php
include '../config/koneksi.php';

$userID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : 0;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

?>

<div class="container mt-5">
    <div class="header" style="margin-top: 120px;">
        <div class="row">
            <div class="col-8">
                <p class="fs-1 text-bold">Welcome to <span class="text-info fw-bold">WeLibrary</span></p>
                <p class="fw-semibold fs-4">Welcome, <span class="text-info"><?php echo $username; ?></span></p>
            </div>
            <div class="col-lg-4 col-md-12">
                <form class="d-flex me-5" id="search-form">
                    <input class="form-control mx-2" type="text" id="searchInput" name="search" placeholder="Search by Title or Writer">
                    <button class="btn btn-outline-info" type="button" id="search-button">Search</button>
                </form>
            </div>
        </div>
        <div class="content">
        <div class="gallery mt-2">
            <hr>
            <p class="fs-3 text-center">Our Collection</p>
            <div class="row justify-content-center" id="siswaTable">
                <?php
                // Declaration of Pagination
                $limit = 8;
                $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                $offset = ($halaman - 1) * $limit;

                $previous = ($halaman > 1) ? $halaman - 1 : 1;
                $next = $halaman + 1;

                $query = mysqli_query($koneksi, "SELECT buku.*, kategoribuku.NamaKategori
                        FROM buku
                        LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
                        LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
                        LIMIT $limit OFFSET $offset");

                while ($data = mysqli_fetch_assoc($query)) {
                    $queryPeminjaman = mysqli_query($koneksi, "SELECT StatusPeminjaman FROM peminjaman WHERE BukuID = '{$data['BukuID']}'");
                    $statusPeminjaman = mysqli_fetch_assoc($queryPeminjaman);

                    $buttonHTML = '';
                    $statusHTML = '';

                    if ($statusPeminjaman) {
                        $status = $statusPeminjaman['StatusPeminjaman'];

                        if ($status == 'dipinjam') {
                            $statusHTML = '<div><span class="badge bg-danger">Dipinjam</span></div>';
                            $buttonHTML = '<button class="btn btn-secondary" disabled>Dipinjam</button>';
                        } elseif ($status == 'dipesan') {
                            $statusHTML = '<div><span class="badge bg-warning">Dipesan</span></div>';
                            $buttonHTML = '<button class="btn btn-secondary" disabled>Dipesan</button>';
                        } else {
                            $statusHTML = '<div><span class="badge bg-success">Tersedia</span></div>';
                            $buttonHTML = '<a href="index.php?page=pinjam&BukuID=' . $data['BukuID'] . '" class="btn btn-success">Pinjam</a>';
                        }
                    } else {
                        $statusHTML = '<div><span class="badge bg-success">Tersedia</span></div>';
                        $buttonHTML = '<a href="index.php?page=pinjam&BukuID=' . $data['BukuID'] . '" class="btn btn-success">Pinjam</a>';
                    }

                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 mt-4 mb-3">
                        <div class="card" style="width: 100%">
                            <img style="aspect-ratio: 3/4;" src="../assets/covers/<?php echo $data['CoverBuku']; ?>" class="card-img-top" alt="Book Cover" style="object-fit: cover;">
                            <div class="card-body">
                                <h4 class="card-text-home"><?php echo $data['Judul']; ?></h4>
                                <p>Author: <?php echo $data['Penulis']; ?></p>
                                <p>Category: <?php echo $data['NamaKategori']; ?></p>
                                <div class="row">
                                    <div class="col-8 mb-2">
                                        Published : <?php echo $data['TahunTerbit']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <?php echo $statusHTML; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6"><?php echo $buttonHTML; ?></div>
                                    <div class="col-6">
                                        <a href="detail.php?BukuID=<?php echo $data['BukuID']; ?>" class="btn btn-info">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" <?php if ($halaman > 1) {
                                                    echo "href='index.php?page=home&halaman=$previous'";
                                                } ?>>Previous</a>
                    </li>
                    <?php
                    $query_count = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku");
                    $data_count = mysqli_fetch_assoc($query_count);
                    $total_halaman = ceil($data_count['total'] / $limit);
                    for ($x = 1; $x <= $total_halaman; $x++) {
                    ?>
                        <li class="page-item"><a class="page-link" href="index.php?page=home&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                    <?php } ?>
                    <li class="page-item">
                        <a class="page-link" <?php if ($halaman < $total_halaman) {
                                                    echo "href='index.php?page=home&halaman=$next'";
                                                } ?>>Next</a>
                    </li>
                </ul>
            </nav>
    </div>
    