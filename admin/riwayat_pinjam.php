<?php 
include '../config/koneksi.php';
// Deklarasi Pagination
$limit = 10;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$offset = ($halaman - 1) * $limit;

$previous = ($halaman > 1) ? $halaman - 1 : 1;
$next = $halaman + 1;

$query = mysqli_query($koneksi, "SELECT
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
LIMIT $offset, $limit;
");

if (!$query) {
    die("Error in query: " . mysqli_error($koneksi));
}

$no = 1;
?>
<div class="card mt-3">
    <div class="card-header">
    <h2 class="text-center">Riwayat Peminjaman</h2>
    <a href="cetak_data.php?case=riwayat" class="btn btn-success">Generate Laporan</a>

    </div>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <td>#</td>
                <td>ID Peminjaman</td>
                <td>Judul Buku</td>
                <td>Peminjam</td>
                <td>Tanggal Dipinjam</td>
                <td>Tanggal Kembali</td>
            </tr>
        </thead>
        <tbody>
            <?php
             while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>";
                echo"<td>" .$no++ . "</td>";
                echo "<td> RP-" . $row['PeminjamanID'] . "</td>";
                echo "<td>" . $row['JudulBuku'] . "</td>";
                echo "<td>" . $row['NamaUser'] . "</td>";
                echo "<td>" . $row['TanggalPeminjaman'] . "</td>";
                echo "<td>" . $row['TanggalKembali'] . "</td>";
                echo "</tr>";
             }
            ?>
        </tbody>
    </table>
    <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" <?php if ($halaman > 1) {
                                                    echo "href='index.php?page=riwayat&halaman=$previous'";
                                                } ?>>Previous</a>
                    </li>
                    <?php
                    $query_count = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM riwayat");
                    $data_count = mysqli_fetch_assoc($query_count);
                    $total_halaman = ceil($data_count['total'] / $limit);
                    for ($x = 1; $x <= $total_halaman; $x++) {
                    ?>
                        <li class="page-item"><a class="page-link" href="index.php?page=riwayat&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                    <?php } ?>
                    <li class="page-item">
                        <a class="page-link" <?php if ($halaman < $total_halaman) {
                                                    echo "href='index.php?page=&halaman=riwayat$next'";
                                                } ?>>Next</a>
                    </li>
                </ul>
            </nav>
</div>