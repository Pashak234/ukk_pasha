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
    $no = 1;

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE Username LIKE '%$search%' OR NamaLengkap LIKE '%$search%'
                        LIMIT $offset, $limit");
    if (!$query) {
        die("Error in query: " . mysqli_error($koneksi));
    }


    while ($data = mysqli_fetch_array($query)) { ?>
    <tr>
    <td>
        <?php echo $no++; ?>
    </td>
    <td>
        <a href="index.php?page=detail&&id=<?php echo $data['UserID'] ?>">
            <?php echo $data['Username']; ?>
        </a>
    </td>
    <td>
        <?php echo $data['NamaLengkap']; ?>
    </td>
    <td>
        <!-- Add this button in your table for each row to trigger the modal -->
        <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $data['UserID']; ?>">
            Edit
        </button>
        <!-- Modal for editing data -->
        <div class="modal fade" id="editModal<?php echo $data['UserID']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="edit_data.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="UserID" value="<?php echo $data['UserID']; ?>">
                            <div class="mb-3">
                                <label for="editUsername" class="form-label">Username</label>
                                <input type="text" class="form-control" name="editUsername" value="<?php echo $data['Username']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="text" class="form-control" name="editEmail" value="<?php echo $data['Email']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="editNama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="editNama" value="<?php echo $data['NamaLengkap']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="editAlamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" name="editAlamat" value="<?php echo $data['Alamat']; ?>" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="update_user">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['UserID'] ?>">Hapus</a>
        <div class="modal fade" id="hapus<?php echo $data['UserID'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            Hapus data
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="edit_data.php" method="POST">
                            <input type="hidden" name="UserID" class="form_control" value="<?php echo $data['UserID'] ?>">
                            <p>Apakah yakin ingin menghapus data <br>
                                <?php echo $data['Username'] ?>
                            </p>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="hapus_user" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
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