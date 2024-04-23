<?php
include '../config/koneksi.php';
if (isset($_POST['query'])) {
    $search = $_POST['query'];
    // Declaration of Pagination
    $limit = 8;
    $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
    $offset = ($halaman - 1) * $limit;

    $previous = ($halaman > 1) ? $halaman - 1 : 1;
    $next = $halaman + 1;

    $query = mysqli_query($koneksi, "SELECT buku.*, kategoribuku.NamaKategori
            FROM buku
            LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
            LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
            WHERE Judul LIKE '%$search%' OR NamaKategori LIKE '%$search%' OR Penulis LIKE '%$search%' 
            LIMIT $limit OFFSET $offset");

    while ($data = mysqli_fetch_assoc($query)) {
        $queryPeminjaman = mysqli_query($koneksi, "SELECT StatusPeminjaman FROM peminjaman WHERE BukuID = '{$data['BukuID']}'");
        $statusPeminjaman = mysqli_fetch_assoc($queryPeminjaman);

        $buttonHTML = '';
        $statusHTML = '';

        if ($statusPeminjaman) {
            $status = $statusPeminjaman['StatusPeminjaman'];

            if ($status == 'dipinjam') {
                $statusHTML = '<div><span class="badge bg-danger">Dipinjam</span></div>';
                $buttonHTML = '<button class="btn btn-secondary" disabled>Dipinjam</button>';
            } elseif ($status == 'dipesan') {
                $statusHTML = '<div><span class="badge bg-warning">Dipesan</span></div>';
                $buttonHTML = '<button class="btn btn-secondary" disabled>Dipesan</button>';
            } else {
                $statusHTML = '<div><span class="badge bg-success">Tersedia</span></div>';
                $buttonHTML = '<a href="index.php?page=pinjam&BukuID=' . $data['BukuID'] . '" class="btn btn-success">Pinjam</a>';
            }
        } else {
            $statusHTML = '<div><span class="badge bg-success">Tersedia</span></div>';
            $buttonHTML = '<a href="index.php?page=pinjam&BukuID=' . $data['BukuID'] . '" class="btn btn-success">Pinjam</a>';
        }
?>

        <div class="col-lg-3 col-md-6 col-sm-12 mt-4 mb-3">
            <div class="card" style="width: 100%">
                <img style="aspect-ratio: 3/4;" src="../assets/covers/<?php echo $data['CoverBuku']; ?>" class="card-img-top" alt="Book Cover" style="object-fit: cover;">
                <div class="card-body">
                    <h4 class="card-text-home"><?php echo $data['Judul']; ?></h4>
                    <p>Author: <?php echo $data['Penulis']; ?></p>
                    <p>Category: <?php echo $data['NamaKategori']; ?></p>
                    <div class="row">
                        <div class="col-8 mb-2">
                            Published : <?php echo $data['TahunTerbit']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <?php echo $statusHTML; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"><?php echo $buttonHTML; ?></div>
                        <div class="col-6">
                            <a href="detail.php?BukuID=<?php echo $data['BukuID']; ?>" class="btn btn-info">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>
    </div>
    
<?php } ?>
