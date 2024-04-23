<?php
$userID = $_SESSION['UserID'];

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
        ORDER BY TanggalPeminjaman DESC;
        LIMIT $offset, $limit;");
                        $no = 1;
                        if ($queryriwayat && mysqli_num_rows($queryriwayat) > 0) {
                        ?>
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
                                    <?php
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
                        <?php
                        } else {
                            // Jika tidak ada data, tampilkan pesan "Tidak ada riwayat"
                            echo "<h1 class='mt-4 mb-5'>Tidak ada riwayat</h1>";
                            ?>
                            <div class="mb-5">
                            </div>
                            <?php
                        }
                        ?>