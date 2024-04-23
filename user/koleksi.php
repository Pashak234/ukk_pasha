<?php
include '../config/koneksi.php';
if (empty($_SESSION['login'])) {
    header("location:../index.php");
    exit();
}

// Ambil UserID dari sesi yang sedang aktif
$UserID = $_SESSION['UserID'];

// Query untuk mengambil daftar buku dalam koleksi pribadi user
$query = mysqli_query($koneksi, "SELECT buku.*, koleksipribadi.UserID, kategoribuku.NamaKategori 
            FROM buku
            INNER JOIN koleksipribadi ON buku.BukuID = koleksipribadi.BukuID
            LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
            LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
            WHERE koleksipribadi.UserID = '$UserID'");

// Check if there are any rows returned from the query
$num_rows = mysqli_num_rows($query);
?>

<div class="container my-5 py-5">
    <div class="card shadow border-0 my-5">
        <h3 class="text-center">Koleksi Saya</h3>
        <div class="container">
            <hr>
            <?php if ($num_rows > 0) : ?>
                <div class="row g-4 mx-3 mt-2 mb-3 justify-content-center">
                    <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                        <div class="col-lg-3 col-md-6 col-sm-12 mt-4 mb-3">
                            <div class="card h-100">
                                <img src="../assets/covers/<?php echo $data['CoverBuku']; ?>" class="card-img-top" alt="Cover Buku">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $data['Judul']; ?></h5>
                                    <p class="card-text"><?php echo $data['Penulis']; ?></p>
                                    <p class="card-text"><?php echo $data['TahunTerbit']; ?></p>
                                    <p class="card-text"><?php echo $data['NamaKategori']; ?></p>
                                    <div class="row">
                                        <div class="col-md-8">
                                        <a class="btn btn-danger" href="hapus_koleksi.php?buku_id=<?php echo $data['BukuID']; ?>&user_id=<?php echo $data['UserID']; ?>">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <div class="text-center my-5">
                    <p>Tidak ada koleksi</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

