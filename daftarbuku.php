<div class="container px-5">
            <div class="row justify-content-center">
                <h3 class="text-center">Menu Buku</h3>
                <?php
                // Deklarasi Pagination
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
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 mt-4 mb-3">
                        <div class="card" style="width: 100%">
                            <img style="aspect-ratio: 3/4;" src="assets/covers/<?php echo $data['CoverBuku']; ?>" class="card-img-top" alt="Book Cover" style="object-fit: cover;">
                            <div class="card-body">
                                <h4 class="card-text-home"><?php echo $data['Judul']; ?></h4>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" <?php if ($halaman > 1) {
                                                    echo "href='index.php?halaman=$previous'";
                                                } ?>>Previous</a>
                    </li>
                    <?php
                    $query_count = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku");
                    $data_count = mysqli_fetch_assoc($query_count);
                    $total_halaman = ceil($data_count['total'] / $limit);
                    for ($x = 1; $x <= $total_halaman; $x++) {
                    ?>
                        <li class="page-item"><a class="page-link" href="index.php?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                    <?php } ?>
                    <li class="page-item">
                        <a class="page-link" <?php if ($halaman < $total_halaman) {
                                                    echo "href='daftarbuku.php?halaman=$next'";
                                                } ?>>Next</a>
                    </li>
                </ul>
            </nav>
        </div>