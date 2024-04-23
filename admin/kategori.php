<main>
    <div class="container">
        <div class="mt-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Daftar Kategori</h3>
                </div>
                <div class="card-body">
                    <table class="table tabel-striped table-hover">
                        <thead>
                            <th>No</th>
                            <th>ID</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                            include '../config/koneksi.php';
                            $no = 1;
                            $query = mysqli_query($koneksi, 'SELECT * FROM kategoribuku ORDER BY KategoriID ASC');
                            if($query){
                                while ($data = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td>
                                        <?php echo $no++; ?>
                                    </td>
                                    <td>KT-
                                        <?php echo$data['KategoriID']; ?>
                                    </td>
                                    <td>
                                        <?php echo$data['NamaKategori']; ?>
                                    </td>
                                    <td>
                                    <a href="" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#hapus<?php echo $data['KategoriID'] ?>">Hapus</a>
                                    <div class="modal fade" id="hapus<?php echo $data['KategoriID'] ?>" tabindex="-1"
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
                                                        <input type="hidden" name="Kate goriID" class="form_control"
                                                            value="<?php echo $data['KategoriID'] ?>">
                                                        <p>Apakah yakin ingin menghapus data <br>
                                                            <?php echo $data['NamaKategori'] ?>
                                                        </p>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" name="hapus_kategori"
                                                                class="btn btn-danger">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>