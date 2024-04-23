<?php
include '../../config/koneksi.php';
if (isset($_POST['query'])) {
    $search = $_POST['query'];
    // Declaration of Pagination
    $limit = 8;
    $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
    $offset = ($halaman - 1) * $limit;

    $previous = ($halaman > 1) ? $halaman - 1 : 1;
    $next = $halaman + 1;

    $query_categories = mysqli_query($koneksi, "SELECT * FROM kategoribuku");
    $categories = mysqli_fetch_all($query_categories, MYSQLI_ASSOC);

    $query = mysqli_query($koneksi, "SELECT buku.*, kategoribuku.KategoriID, kategoribuku.NamaKategori
            FROM buku
            LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
            LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
            WHERE Judul LIKE '%$search%' OR NamaKategori LIKE '%$search%' OR Penulis LIKE '%$search%'
            LIMIT $offset, $limit");
if (!$query) {
    die("Error in query: " . mysqli_error($koneksi));
}


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
<?php }

                                    }
?>