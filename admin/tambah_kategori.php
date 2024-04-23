<main>
    <div class="container">
        <div class="mt-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Tambah Kategori</h3>
                </div>
                <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="InputKategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="InputKategori" name="kategori">
                    </div>
                    <button class="btn btn-info" name="kirim">Kirim</button>
                </form>

                <?php
                include '../config/koneksi.php';

                if(isset($_POST['kirim'])){
                    $nama_kategori = $_POST['kategori'];

                    $query = mysqli_query($koneksi,"INSERT INTO kategoribuku VALUES ('', '$nama_kategori')");
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</main>

