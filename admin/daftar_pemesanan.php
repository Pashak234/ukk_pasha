<?php
include '../config/koneksi.php';
// Deklarasi Pagination
$limit = 10;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$offset = ($halaman - 1) * $limit;

$previous = ($halaman > 1) ? $halaman - 1 : 1;
$next = $halaman + 1;
?>
<div class="mt-3">
</div>
<div class="card">
    <div class="card-header">
        <h2 class="text-center">
            Daftar Pemesanan
        </h2>
        <a href="cetak_data.php?case=peminjaman" class="btn btn-success">Generate Laporan</a>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM peminjaman JOIN user ON peminjaman.UserID = user.UserID JOIN buku ON peminjaman.BukuID = buku.BukuID
            WHERE StatusPeminjaman = 'dipesan'
            LIMIT $offset, $limit");
                if ($query) {
                    while ($data = mysqli_fetch_array($query)) {
                ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>PM-<?php echo $data['PeminjamanID'] ?></td>
                            <td><?php echo $data['NamaLengkap'] ?></td>
                            <td><?php echo $data['Judul'] ?></td>
                            <td><?php echo $data['TanggalPemesanan'] ?></td>
                            <td><?php echo $data['TanggalPeminjaman'] ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal<?php echo $data['PeminjamanID']; ?>">Konfirmasi</button>
                                <!-- Modal -->
                                <div class="modal fade" id="confirmationModal<?php echo $data['PeminjamanID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pemesanan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda ingin mengkonfirmasi pemesanan ini?</p>
                                                <!-- Hidden form inside modal -->
                                                <form id="confirmationForm<?php echo $data['PeminjamanID']; ?>" action="edit_data.php" method="POST">
                                                    <input type="hidden" name="peminjamanID" value="<?php echo $data['PeminjamanID']; ?>">
                                                    <!-- Additional fields if necessary -->
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <!-- Submit button inside modal -->
                                                <button type="submit" form="confirmationForm<?php echo $data['PeminjamanID']; ?>" name="konfirmasi" class="btn btn-primary">Konfirmasi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
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