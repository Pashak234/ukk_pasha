<?php
include '../config/koneksi.php';

// Check if $_SESSION['UserID'] is set before accessing it
if (isset($_SESSION['UserID'])) {
    // $_SESSION['UserID'] is set, you can use it safely
    $userID = $_SESSION['UserID'];

    // Rest of your code
} else {
    // $_SESSION['UserID'] is not set, handle the case accordingly
    echo "UserID is not set in the session.";
}

if (isset($_GET['BukuID'])) {
    $bukuID = $_GET['BukuID'];

    // Sanitize input (consider using prepared statements)
    $bukuID = mysqli_real_escape_string($koneksi, $bukuID);

    // Check if the book is available for borrowing
    $queryPeminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE BukuID = '$bukuID' AND StatusPeminjaman = 'dipinjam'");
    $statusPeminjaman = mysqli_fetch_assoc($queryPeminjaman);
    $queryDataBuku = mysqli_query($koneksi, "SELECT * FROM buku WHERE BukuID = '$bukuID'");
    $data = mysqli_fetch_assoc($queryDataBuku);

    if ($statusPeminjaman) {
        // Book is already borrowed, redirect to status page
        header("Location: status_peminjaman.php?BukuID=$bukuID");
        exit();
    } else {
        ?>
        <div class="mt-5 py-1">
            <div class="container py-5">
                <h2>Pesan Buku</h2>
                <form method="post">
                    <div class="mb-3">
                        Apakah anda yakin ingin memesan buku
                        <h3><?php echo $data['Judul']; ?>?</h3>
                        <p class="fw-bold">Penulis: <br> <?php echo $data['Penulis']; ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalPesan" class="form-label">Tanggal Pemesanan</label>
                        <input type="date" class="form-control" id="tanggalPesan" value="<?php echo date("Y-m-d"); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalAmbil" class="form-label">Tanggal Pengambilan</label>
                        <input type="date" class="form-control" id="tanggalAmbil" name="tanggalAmbil" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <button type="submit" class="btn btn-success" name="pinjam">Pesan</button>
                </form>
            </div>
        </div>
        <?php
    }
}

// Process the borrowing action when the Pinjam button is clicked
if (isset($_POST['pinjam'])) {
    $tanggalPesan = date("Y-m-d");
    $tanggalAmbil = $_POST['tanggalAmbil'];

    // Menghitung tanggal pengembalian dengan menambahkan 7 hari dari tanggal pengambilan
    $batasPengembalian = date('Y-m-d', strtotime($tanggalAmbil . ' + 7 days'));

    // Insert into database
    $queryInsert = mysqli_query($koneksi, "INSERT INTO peminjaman VALUES ('', '$userID', '$bukuID', '$tanggalPesan', '$tanggalAmbil','$batasPengembalian', 'dipesan')");

    if ($queryInsert) {
        ?>
        <div class="container mb-4">
            <p>Buku berhasil dipesan.</p>
            <a href="index.php?page=home" class="btn btn-secondary">Ke Beranda</a>
            <a href="status_peminjaman.php?BukuID=<?php echo $bukuID; ?>" class="btn btn-primary">Lihat Status Peminjaman</a>
            <a href="index.php?page=profile" class="btn btn-secondary">Ke Profil</a>
        </div>
        <?php
    } else {
        ?>
        <div class="container">
            <h3>Pesan Buku</h3>
            <p>Gagal memesan buku.</p>
            <?php var_dump($queryInsert) ?>
            <a href="index.php?page=profile" class="btn btn-secondary">Ke Profil</a>
        </div>
        <?php
    }
}
?>
