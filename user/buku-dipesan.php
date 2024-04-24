<div class="row justify-content-center">
                                    <?php


                                    $query = mysqli_query($koneksi, "SELECT buku.*, kategoribuku.NamaKategori, peminjaman.*
                            FROM buku
                            LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
                            LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
                            LEFT JOIN peminjaman ON buku.BukuID = peminjaman.BukuID
                            WHERE peminjaman.UserID = $userID AND peminjaman.StatusPeminjaman = 'dipesan' ");



                                    // Periksa apakah ada data yang ditemukan
                                    if (mysqli_num_rows($query) > 0) {
                                        while ($data = mysqli_fetch_array($query)) {
                                            // Tampilkan data buku dalam galeri di sini
                                    ?>
                                            <div class="col-md-4 mt-4">
                                                <div class="card border" style="">
                                                    <img src="../assets/covers/<?php echo $data['CoverBuku']; ?>" class="card-img-top" alt="Book Cover" style="object-fit: cover; aspect-ratio: 3/4;">
                                                    <div class="card-body">
                                                        <h4><?php echo $data['Judul']; ?></h4>
                                                        <p class="my-1">Writer: <?php echo $data['Penulis']; ?></p>
                                                        <p class="my-1">Category: <?php echo $data['NamaKategori']; ?></p>
                                                        <div class="row my-0">
                                                            <div class="col-8 mb-1">Published on: <?php echo $data['TahunTerbit']; ?></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <?php
                                                                if ($data['StatusPeminjaman'] == 'dipinjam') {
                                                                    // Calculate the return date
                                                                    $batasKembali = date('Y-m-d', strtotime($data['BatasKembali']));
                                                                    $today = date('Y-m-d');
                                                                    if ($today > $batasKembali) {
                                                                        // Display a warning if the book is overdue
                                                                        echo '<div class="alert alert-danger" role="alert">Mohon kembalikan buku, Anda akan terkena denda bila melewati waktu pengembalian yang ditentukan.</div>';
                                                                    } else {
                                                                        // Display a notice with the return date
                                                                        echo '<div class="alert alert-warning" role="alert">Mohon kembalikan buku pada ' . $batasKembali . '</div>';
                                                                    }
                                                                } elseif ($data['StatusPeminjaman'] == 'dipesan') {
                                                                    // Display a notice if the book is reserved
                                                                    echo '<div class="alert alert-info" role="alert">Buku ini sudah dipesan. Mohon datang ke perpustakaan pada tanggal peminjaman untuk meminjam buku</div>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <a href="status_peminjaman.php?BukuID=<?php echo $data['BukuID']; ?>" class="btn btn-primary btn-sm">Status Peminjaman</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        // Jika tidak ada buku yang sedang dipinjam, tampilkan pesan
                                        echo "<p class='fs-2 my-5 text-center'>Tidak ada buku yang dipesan.  </p>";
                                    }
                                    ?>
                                </div>