<div class="container px-5">
    <div class="row justify-content-center">
        <h3 class="text-center">Buku Rekomendasi</h3>
        <?php
        // Deklarasi Pagination
        $limit = 8;
        $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
        $offset = ($halaman - 1) * $limit;

        $previous = ($halaman > 1) ? $halaman - 1 : 1;
        $next = $halaman + 1;

        $query = mysqli_query($koneksi, "SELECT buku.*, kategoribuku.NamaKategori
                       FROM buku
    LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
    LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
    WHERE Rekomendasi='ya'");

        while ($data = mysqli_fetch_assoc($query)) {
        ?>
            <div class="col-lg-3 col-md-6 col-sm-12 mt-4 mb-3">
                <div class="card card-home-text " style="width: 100%">
                    <img style="aspect-ratio: 3/4;" src="assets/covers/<?php echo $data['CoverBuku']; ?>" class="card-img-top" alt="Book Cover" style="object-fit: cover;">
                    <div class="card-body">
                        <h4 class="card-text-main"><?php echo $data['Judul']; ?></h4>
                        <p>Penulis: <?php echo $data['Penulis']; ?></p>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>