<?php
include '../config/koneksi.php';
$query_kategori = "SELECT * FROM kategoribuku";
$result_kategori = mysqli_query($koneksi, $query_kategori);

?>
<div class="container">
    <div class="card mt-4   ">
        <div class="card-header">
            <h3 class="text-center">
                Tambahkan Buku
            </h3>
        </div>
        <div class="card-body">
            <form action="tambah_buku_proses.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="InputKategori" class="form-label">Kategori</label>
                    <select class="form-select" name="kategori" id="InputKategori">
                        <?php
                        // Menampilkan pilihan kategori dari hasil query
                        while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
                            echo "<option>" . $row_kategori['NamaKategori'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="InputJudul" class="form-label">Judul</label>
                    <input type="text" class="form-control" name="judul" id="InputJudul">
                </div>
                <div class="mb-3">
                    <label for="InputPenulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" name="penulis" id="InputPenulis">
                </div>
                <div class="mb-3">
                    <label for="InputPenerbit" class="form-label">Penerbit</label>
                    <input type="text" class="form-control" name="penerbit" id="InputPenerbit">
                </div>
                <div class="mb-3">
                    <label for="InputTahun" class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" name="tahun_terbit" id="InputTahun">
                </div>
                <label for="formFile" class="form-label">Cover Buku</label>
                <input class="form-control" type="file" name="cover" id="formFile">
                <button type="submit" name="kirim" class="btn btn-info my-3 text-white">Submit</button>
            </form>
        </div>
    </div>
</div>