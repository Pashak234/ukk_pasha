<?php
// Ambil ID pengguna yang sedang masuk
$userID = $_SESSION['UserID'];

// Hitung jumlah buku yang pernah dipinjam
$qjmlpinjam = mysqli_query($koneksi, "SELECT COUNT(*) AS total_buku_dipinjam FROM riwayat WHERE UserID = '$userID'");
$data = mysqli_fetch_assoc($qjmlpinjam);
$total_buku_dipinjam = $data['total_buku_dipinjam'];
$jml_pinjam = ($total_buku_dipinjam == 0) ? 0 : $total_buku_dipinjam;

//hitung jumlah buku yang dikoleksi
$qjmlkoleksi = mysqli_query($koneksi, "SELECT COUNT(*) AS total_buku_dikoleksi FROM koleksipribadi WHERE UserID = '$userID'");
$data = mysqli_fetch_assoc($qjmlkoleksi);
$total_buku_dikoleksi = $data['total_buku_dikoleksi'];
$jml_koleksi = ($total_buku_dikoleksi == 0) ? 0 : $total_buku_dikoleksi;
?>
<div class="main pt-5">
    <div class="pt-2">
        <div class="main">
            <div class="pt-4 mb-5">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Profil</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="borrowed-books-tab" data-bs-toggle="tab" data-bs-target="#borrowed-books" type="button" role="tab" aria-controls="borrowed-books" aria-selected="false">Buku Dipinjam</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="booked-books-tab" data-bs-toggle="tab" data-bs-target="#booked-books" type="button" role="tab" aria-controls="booked-books" aria-selected="false">Buku Dipesan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="borrow-history-tab" data-bs-toggle="tab" data-bs-target="#borrow-history" type="button" role="tab" aria-controls="borrow-history" aria-selected="false">Riwayat Peminjaman</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        </span></p>
                        <?php
                        $qprofil = mysqli_query($koneksi, "SELECT * FROM user WHERE UserID = $userID");
                        $userdata = mysqli_fetch_array($qprofil);
                        if ($userdata) {
                        ?>
                            <!-- Profile card -->
                            <div class="card shadow-lg border-0">
                                <div class="card-body ">
                                    <p class="my-2 fs-2 fw-semibold">Profil <span class="text-info">
                                            <?php echo $_SESSION['username']; ?>
                                            <hr>
                                            <div class="row mb-2">
                                                <div class="col-md-3 col-sm-12">
                                                    Username
                                                </div>
                                                <div class="col-md-2 col-sm-12">:
                                                    <?php echo $userdata['Username'] ?>
                                                </div>
                                                <div class="col-md-6 col-sm-12"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3 col-sm-12">
                                                    Nama
                                                </div>
                                                <div class="col-md-3 col-sm-12">:
                                                    <?php echo $userdata['NamaLengkap'] ?>
                                                </div>
                                                <div class="col-md-6 col-sm-12"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3 col-sm-12">
                                                    Email
                                                </div>
                                                <div class="col-md-3 col-sm-12">:
                                                    <?php echo $userdata['Email'] ?>
                                                </div>
                                                <div class="col-md-6 col-sm-12"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3 col-sm-12">
                                                    Alamat
                                                </div>
                                                <div class="col-md-3 col-sm-12">:
                                                    <?php echo $userdata['Alamat'] ?>
                                                </div>
                                                <div class="col-md-6 col-sm-12"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3 col-sm-12">
                                                    Buku dipinjam
                                                </div>
                                                <div class="col-md-3 col-sm-12">:
                                                    <?php echo $jml_pinjam ?>
                                                </div>
                                                <div class="col-md-6 col-sm-12"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3 col-sm-12">
                                                    Buku dikoleksi
                                                </div>
                                                <div class="col-md-3 col-sm-12">:
                                                    <?php echo $jml_koleksi ?>
                                                </div>
                                                <div class="col-md-6 col-sm-12"></div>
                                            </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="borrowed-books" role="tabpanel" aria-labelledby="borrowed-books-tab">
                        <div class="card shadow-lg border-0 my-3">
                            <div class="gallery my-3 mx-3" id="search-results">
                                <div class="d-flex justify-content-center">
                                    <div class="text-center">
                                        <p class="fs-2 fw-bold text-info">Buku Dipinjam</p>
                                    </div>
                                </div>
                                <hr>
                                <?php
                                include 'buku-dipinjam.php';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="booked-books" role="tabpanel" aria-labelledby="booked-books-tab">
                        <div class="card shadow-lg border-0 my-3">
                            <div class="gallery my-3 mx-3" id="search-results">
                                <div class="d-flex justify-content-center">
                                    <div class="text-center">
                                        <p class="fs-2 fw-bold text-info">Buku Dipesan</p>
                                    </div>
                                </div>
                                <hr>
                                <?php
                                include 'buku-dipesan.php';
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    // Deklarasi Pagination
                    $limit = 10;
                    $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                    $offset = ($halaman - 1) * $limit;

                    $previous = ($halaman > 1) ? $halaman - 1 : 1;
                    $next = $halaman + 1;

                    $queryriwayat = mysqli_query($koneksi, "SELECT
    rp.PeminjamanID,
    buku.Judul AS JudulBuku,
    user.Username AS NamaUser,
    rp.TanggalPeminjaman,
    rp.TanggalKembali
    FROM
    riwayat rp
    JOIN
    buku ON rp.BukuID = buku.BukuID
    JOIN
    user ON rp.UserID = user.UserID
    WHERE rp.UserID = '$userID'
    ORDER BY TanggalPeminjaman DESC
    LIMIT $offset, $limit;");
                    $no = 1;
                    ?>

                    <div class="tab-pane fade" id="borrow-history" role="tabpanel" aria-labelledby="borrow-history-tab">
                        <?php if ($queryriwayat && mysqli_num_rows($queryriwayat) > 0) { ?>
                            <!-- Borrow history table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Tanggal Kembali</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($data = mysqli_fetch_array($queryriwayat)) { ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $data['JudulBuku'] ?></td>
                                            <td><?php echo $data['TanggalPeminjaman'] ?></td>
                                            <td><?php echo $data['TanggalKembali'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!-- Pagination -->
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" <?php if ($halaman > 1) {
                                                                    echo "href='index.php?page=list_buku&halaman=$previous'";
                                                                } ?>>Previous</a>
                                    </li>
                                    <?php
                                    $query_count = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM peminjaman");
                                    $data_count = mysqli_fetch_assoc($query_count);
                                    $total_halaman = ceil($data_count['total'] / $limit);
                                    for ($x = 1; $x <= $total_halaman; $x++) {
                                    ?>
                                        <li class="page-item"><a class="page-link" href="index.php?page=peminjaman&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                                    <?php } ?>
                                    <li class="page-item">
                                        <a class="page-link" <?php if ($halaman < $total_halaman) {
                                                                    echo "href='index.php?page=peminjaman&halaman=$next'";
                                                                } ?>>Next</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php } else {
                            // Jika tidak ada data, tampilkan pesan "Tidak ada riwayat"
                            echo "<h1 class='mt-4 mb-5'>Tidak ada riwayat</h1>";
                        } ?>
                    </div>


                </div>
            </div>
        </div>



    </div>
</div>
</main>