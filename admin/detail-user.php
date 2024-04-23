<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userID = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE UserID = $userID");

    if (mysqli_num_rows($query) > 0) {
        $userData = mysqli_fetch_assoc($query);
        $alamat = $userData['Alamat'];

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
    LIMIT $offset, $limit;");

?>
        <div class="text-dark">
            <h1 class="text-dark">Detail Pengguna</h1>
            <p>ID Pengguna: <?php echo $userData['UserID']; ?></p>
            <p>Username: <?php echo $userData['Username']; ?></p>
            <p>Email: <?php echo $userData['Email']; ?></p>
            <p>Nama Lengkap: <?php echo $userData['NamaLengkap']; ?></p>
            <!-- Tampilkan alamat di luar tag PHP -->
            <p>Alamat: <?php echo $alamat; ?></p>
            <!-- Tambahkan informasi lain yang ingin Anda tampilkan -->
        </div>
        <div class="my-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center text-dark fw-bold">
                        Riwayat Peminjaman <br> <?php echo $userData['NamaLengkap']; ?>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Tanggal Pengembalian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if ($queryriwayat) {
                                while ($data = mysqli_fetch_array($queryriwayat)) {
                            ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data['JudulBuku'] ?></td>
                                        <td><?php echo $data['TanggalPeminjaman'] ?></td>
                                        <td><?php echo $data['TanggalKembali'] ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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
                </div>
            </div>
        </div>
<?php
    } else {
        echo "Pengguna tidak ditemukan.";
    }
} else {
    echo "ID Pengguna tidak valid.";
}
?>