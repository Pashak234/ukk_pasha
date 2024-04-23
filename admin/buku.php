<?php
include '../config/koneksi.php';

// Deklarasi Pagination
$limit = 10;
$halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
$offset = ($halaman - 1) * $limit;

$previous = ($halaman > 1) ? $halaman - 1 : 1;
$next = $halaman + 1;
// Fetch categories from the database
$query_categories = mysqli_query($koneksi, "SELECT * FROM kategoribuku");
$categories = mysqli_fetch_all($query_categories, MYSQLI_ASSOC);

// Menampilkan Buku
$query = mysqli_query($koneksi, "SELECT buku.*, kategoribuku.KategoriID, kategoribuku.NamaKategori
            FROM buku
            LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
            LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
            LIMIT $offset, $limit");
if (!$query) {
    die("Error in query: " . mysqli_error($koneksi));
}
?>

<div class="mt-3">
    <div class="h2">Daftar Buku</div>
    <div class="card">
        <div class="d-flex justify-content-between mx-3">
            <div class="mt-3">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" id="searchInputBuku">
                        <div class="input-group-append">
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-2">
                <a role="button" href="index.php?page=tambah_buku" class="btn btn-info text-white">Tambah Data</a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Tahun Terbit</th>
                        <th scope="col">Cover</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Rekomendasi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="bookTable">
                    <?php
                    $no = $offset + 1;
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td>
                                <?php echo $no++; ?>
                            </td>
                            <td>
                                <?php echo $data['Judul']; ?>
                            </td>
                            <td>
                                <?php echo $data['Penulis']; ?>
                            </td>
                            <td>
                                <?php echo $data['Penerbit']; ?>
                            </td>
                            <td>
                                <?php echo $data['TahunTerbit']; ?>
                            </td>
                            <td><img src="../assets/covers/<?php echo $data['CoverBuku']; ?>" width="100" alt=""></td>
                            <td>
                                <?php echo $data['NamaKategori']; ?>
                            </td>
                            <td>
                                <?php echo $data['Rekomendasi']; ?>
                            </td>
                            <td>

                                <button type="button" class="btn btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $data['BukuID']; ?>">
                                    Edit
                                </button>
                                <a href="" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['BukuID'] ?>">Hapus</a>
                                <div class="modal fade" id="hapus<?php echo $data['BukuID'] ?>" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="hapusModalLabel">
                                                    Hapus data
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="edit_data.php" method="POST">
                                                    <input type="hidden" name="BukuID" class="form_control" value="<?php echo $data['BukuID'] ?>">
                                                    <p>Apakah yakin ingin menghapus data <br>
                                                        <?php echo $data['Judul'] ?>
                                                    </p>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="hapus_buku" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="editModal<?php echo $data['BukuID']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Data Buku</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="edit_data.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="BukuID" value="<?php echo $data['BukuID']; ?>">
                                                    <input type="hidden" name="oldCover" value="<?php echo $data['CoverBuku']; ?>">
                                                    <div class="mb-3">
                                                        <label for="editKategori">Kategori</label>
                                                        <select class="form-select" name="kategori" id="editKategori">
                                                            <?php
                                                            // Loop through the categories
                                                            foreach ($categories as $category) {
                                                                // Check if the category matches the book's current category
                                                                $selected = ($data['NamaKategori'] == $category['NamaKategori']) ? 'selected' : '';
                                                                // Output the option with the category name
                                                                echo "<option value='{$category['KategoriID']}' $selected>{$category['NamaKategori']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editJudul" class="form-label">Judul</label>
                                                        <input type="text" class="form-control" name="editJudul" value="<?php echo $data['Judul']; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editPenulis" class="form-label">Penulis</label>
                                                        <input type="text" class="form-control" name="editPenulis" value="<?php echo $data['Penulis']; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editPenerbit" class="form-label">Penerbit</label>
                                                        <input type="text" class="form-control" name="editPenerbit" value="<?php echo $data['Penerbit']; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editTahunTerbit" class="form-label">Tahun Terbit</label>
                                                        <input type="text" class="form-control" name="editTahunTerbit" value="<?php echo $data['TahunTerbit']; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editCover" class="form-label">Cover Buku</label>
                                                        <input type="file" class="form-control" name="editCover">
                                                        <small class="text-muted">Leave it empty if you don't want to change the cover.</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editKategori">Direkomendasikan</label>
                                                        <select class="form-select" name="editRekomendasi" id="">
                                                            <option value="ya" <?php if ($data['Rekomendasi'] == 'ya') echo 'selected'; ?>>Ya</option>
                                                            <option value="tidak" <?php if ($data['Rekomendasi'] == 'tidak') echo 'selected'; ?>>Tidak</option>
                                                        </select>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" name="update_buku">Save Changes</button>
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
                                                    echo "href='index.php?page=list_buku&halaman=$previous'";
                                                } ?>>Previous</a>
                    </li>
                    <?php
                    $query_count = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku");
                    $data_count = mysqli_fetch_assoc($query_count);
                    $total_halaman = ceil($data_count['total'] / $limit);
                    for ($x = 1; $x <= $total_halaman; $x++) {
                    ?>
                        <li class="page-item"><a class="page-link" href="index.php?page=list_buku&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                    <?php } ?>
                    <li class="page-item">
                        <a class="page-link" <?php if ($halaman < $total_halaman) {
                                                    echo "href='index.php?page=list_buku&halaman=$next'";
                                                } ?>>Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>