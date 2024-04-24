<?php
include '../config/koneksi.php';

if (isset($_GET['case'])) {
    $case = $_GET['case'];

    switch ($case) {
        case 'peminjaman': ?>
            <h2 align="center">Laporan Peminjaman Buku</h2>
            <table border="1" cellspacing="0" width="100%">
                <tr>
                    <th>No</th>
                    <th>user</th>
                    <th>Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status Peminjaman</th>
                </tr>
                <?php
                include "../config/koneksi.php";
                $i = 1;
                $query = mysqli_query($koneksi, "SELECT*FROM peminjaman LEFT JOIN user ON user.UserID = peminjaman.UserID LEFT JOIN buku ON buku.BukuID = peminjaman.BukuID");
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $data['Username'] ?></td>
                        <td><?php echo $data['Judul'] ?></td>
                        <td><?php echo $data['TanggalPeminjaman'] ?></td>
                        <td><?php echo $data['TanggalPengembalian'] ?></td>
                        <td><?php echo $data['StatusPeminjaman'] ?></td>
                    </tr>
                <?php } ?>

            </table>
            <script>
                window.print();

                setTimeout(function() {
                    window.close();
                }, 100);
            </script>
        <?php
            break;
        case 'riwayat': ?>
                <h2 align="center">Riwayat Peminjaman</h2>
            <table border="1" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>ID Peminjaman</td>
                        <td>Judul Buku</td>
                        <td>Peminjam</td>
                        <td>Tanggal Kembali</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($koneksi, "SELECT
                    rp.PeminjamanID,
                    buku.Judul AS JudulBuku,
                    user.Username AS NamaUser,
                    rp.TanggalKembali
                    FROM
                    riwayat rp
                    JOIN
                    buku ON rp.BukuID = buku.BukuID
                    JOIN
                    user ON rp.UserID = user.UserID;
                    ");
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td> RP-" . $row['PeminjamanID'] . "</td>";
                        echo "<td>" . $row['JudulBuku'] . "</td>";
                        echo "<td>" . $row['NamaUser'] . "</td>";
                        echo "<td>" . $row['TanggalKembali'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <script>
                window.print();

                setTimeout(function() {
                    window.close();
                }, 100);
            </script>
            </div>
<?php break;

        default:
            echo "gagal";
            break;
    }
} else {
    include 'dashboard.php';
}
