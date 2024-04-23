<?php
$buku = mysqli_query($koneksi, "SELECT * FROM buku");
$jml_buku = mysqli_num_rows($buku);
$pengguna = mysqli_query($koneksi, "SELECT * FROM user");
$jml_pengguna = mysqli_num_rows($pengguna);
$petugas = mysqli_query($koneksi, "SELECT * FROM petugas");
$jml_petugas = mysqli_num_rows($petugas);
$peminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman");
$jml_peminjaman = mysqli_num_rows($peminjaman);
$kategori = mysqli_query($koneksi, "SELECT * FROM kategoribuku");
$jml_kategori = mysqli_num_rows($kategori);
?>
<main>
    <div class="my-3">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="mt-2">
                <h1 class="h3 mb-0 text-gray-800">Dashboard Utama</h1>
                <p>Selamat datang,
                    <?php echo $_SESSION['nama_petugas'] ?>
                </p>
            </div>
        </div>
        <hr>
        <div class="mt-4">
            <div class="row justify-content-center">
                <div class="col-md-3 my-2">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Jumlah Buku</div>
                                    <div class="h1 mb-0 font-weight-bold text-gray-800">
                                        <?php echo "$jml_buku" ?> <br> <span class="h5">Buku</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($_SESSION['login'] != 'petugas'): ?>
                    <div class="col-md-3 my-2">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Jumlah Pengguna</div>
                                        <div class="h1 mb-0 font-weight-bold text-gray-800">
                                            <?php echo "$jml_pengguna" ?> <br> <span class="h5">Pengguna</span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-book-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 my-2">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Jumlah Petugas</div>
                                        <div class="h1 mb-0 font-weight-bold text-gray-800">
                                            <?php echo "$jml_petugas" ?> <br> <span class="h5">Petugas</span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-book-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-3 my-2">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Jumlah Peminjaman</div>
                                    <div class="h1 mb-0 font-weight-bold text-gray-800">
                                        <?php echo "$jml_peminjaman" ?> <br> <span class="h5">Buku dipinjam</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>