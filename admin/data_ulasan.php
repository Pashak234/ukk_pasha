<div class="card mt-4">
    <div class="card-header">
        <h3 class="text-center my-2">Ulasan Buku</h3>

    </div>
    <table class="table table-striped table-hover my-2">
        <thead>
            <tr>
                <th>UlasanID</th>
                <th>Username</th>
                <th>Judul Buku</th>
                <th>Rating</th>
                <th>Isi Ulasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Deklarasi Pagination
            $limit = 10;
            $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
            $offset = ($halaman - 1) * $limit;

            $previous = ($halaman > 1) ? $halaman - 1 : 1;
            $next = $halaman + 1;

            $queryUlasan = mysqli_query($koneksi, "SELECT ulasanbuku.UlasanID, user.Username, buku.Judul, ulasanbuku.Rating, ulasanbuku.Ulasan
                                                FROM ulasanbuku
                                                LEFT JOIN user ON ulasanbuku.UserID = user.UserID
                                                LEFT JOIN buku ON ulasanbuku.BukuID = buku.BukuID
                                                LIMIT $offset, $limit");

            while ($dataUlasan = mysqli_fetch_assoc($queryUlasan)) {
            ?>
                <tr>
                    <td>UL-<?php echo $dataUlasan['UlasanID']; ?></td>
                    <td><?php echo $dataUlasan['Username']; ?></td>
                    <td><?php echo $dataUlasan['Judul']; ?></td>
                    <td><?php echo $dataUlasan['Rating']; ?>/10</td>
                    <td><?php echo $dataUlasan['Ulasan']; ?></td>
                    <td>
                        <!-- Trigger button for modal -->
                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $dataUlasan['UlasanID']; ?>">Hapus</a>

                        <!-- Modal -->
                        <div class="modal fade" id="hapus<?php echo $dataUlasan['UlasanID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus data</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="edit_data.php" method="POST">
                                            <input type="hidden" name="UlasanID" class="form_control" value="<?php echo $dataUlasan['UlasanID']; ?>">
                                            <p>Apakah yakin ingin menghapus data?</p>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="hapus_ulasan" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" <?php if ($halaman > 1) {
                                            echo "href='index.php?page=ulasan&halaman=$previous'";
                                        } ?>>Previous</a>
            </li>
            <?php
            $query_count = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM ulasanbuku");
            $data_count = mysqli_fetch_assoc($query_count);
            $total_halaman = ceil($data_count['total'] / $limit);
            for ($x = 1; $x <= $total_halaman; $x++) {
            ?>
                <li class="page-item"><a class="page-link" href="index.php?page=ulasan&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
            <?php } ?>
            <li class="page-item">
                <a class="page-link" <?php if ($halaman < $total_halaman) {
                                            echo "href='index.php?page=ulasan&halaman=$next'";
                                        } ?>>Next</a>
            </li>
        </ul>
    </nav>