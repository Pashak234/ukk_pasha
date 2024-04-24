<?php
include '../config/koneksi.php';
?>
<div class="card my-3">
    <div class="card-header">
        <h2 class="text-center">Daftar Petugas</h2>
    </div>
    <div class="card-body">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Tambahkan Petugas
        </button>
        <!-- Modal for adding data -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addModalUser" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPetugasModal">Tambah Data Petugas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../config/registrasi-admin.php" method="POST" enctype="multipart/form-data">
                            <label class="form-label" for="">Username</label>
                            <input type="text" name="username" id="" class="form-control" required>
                            <label class="form-label" for="">Password</label>
                            <input type="password" name="password" id="" class="form-control" required>
                            <label class="form-label" for="">Nama Lengkap</label>
                            <input type="text" name="nama" id="" class="form-control" required>
                            <label class="form-label" for="">Email</label>
                            <input type="text" name="email" id="" class="form-control" required>
                            <label class="form-label" for="">Level</label>
                            <select class="form-select" id="level" name="level">
                                <option value="admin" required>Admin</option>
                                <option value="petugas" required>Petugas</option>
                            </select>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="kirim">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>PetugasID</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM petugas");

                while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <td>PT-<?php echo $row['PetugasID'] ?>
                        </td>
                        <td>
                            <?php echo $row['Username'] ?>
                        </td>
                        <td>
                            <?php echo $row['NamaLengkap'] ?>
                        </td>
                        <td>
                            <?php echo $row['Email'] ?>
                        </td>
                        <td>
                            <?php echo $row['Level'] ?>
                        </td>
                        <td>
                            <!-- Add this button in your table for each row to trigger the modal -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal<?php echo $row['PetugasID']; ?>">
                                Edit
                            </button>
                            <!-- Modal for editing data -->
                            <div class="modal fade" id="editModal<?php echo $row['PetugasID']; ?>" tabindex="-1"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Data Petugas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="edit_data.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="PetugasID"
                                                    value="<?php echo $row['PetugasID']; ?>">
                                                <div class="mb-3">
                                                    <label for="editUsername" class="form-label">Username</label>
                                                    <input type="text" class="form-control" name="editUsername"
                                                        value="<?php echo $row['Username']; ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="editEmail" class="form-label">Email</label>
                                                    <input type="text" class="form-control" name="editEmail"
                                                        value="<?php echo $row['Email']; ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="editNama" class="form-label">Nama Lengkap</label>
                                                    <input type="text" class="form-control" name="editNama"
                                                        value="<?php echo $row['NamaLengkap']; ?>" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="update_petugas">Save
                                                        Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#hapus<?php echo $row['PetugasID'] ?>">Hapus</a>
                            <div class="modal fade" id="hapus<?php echo $row['PetugasID'] ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                Hapus data
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="edit_data.php" method="POST">
                                                <input type="hidden" name="PetugasID" class="form_control"
                                                    value="<?php echo $row['PetugasID'] ?>">
                                                <p>Apakah yakin ingin menghapus data <br>
                                                    <?php echo $row['Username'] ?>
                                                </p>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="hapus_petugas"
                                                        class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>

                <?php
                // Close the database connection
                mysqli_close($koneksi);
                ?>
            </tbody>
        </table>
    </div>
</div>