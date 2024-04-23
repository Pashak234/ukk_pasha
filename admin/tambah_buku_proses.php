<?php
include '../config/koneksi.php';

if (isset($_POST['kirim'])) {
    // Retrieve form data
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];

    // Handle file upload
    $foto = $_FILES['cover']['name'];
    $tmp = $_FILES['cover']['tmp_name'];
    $lokasi = '../assets/covers/';
    $nama_foto = rand(0, 999) . '-' . $foto;
    $upload_path = $lokasi . '/' . $nama_foto;

    // Check for file upload errors
    if ($_FILES['cover']['error'] !== UPLOAD_ERR_OK) {
        echo "File upload error: " . $_FILES['cover']['error'];
    } elseif (move_uploaded_file($tmp, $upload_path)) {
        // Insert data into the 'buku' table
        $sql_buku = "INSERT INTO buku (Judul, Penulis, Penerbit, TahunTerbit, CoverBuku) 
                    VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$nama_foto')";

        if (mysqli_query($koneksi, $sql_buku)) {
            // Retrieve BukuID
            $buku_id = mysqli_insert_id($koneksi);

            // Retrieve selected category from form
            $selected_kategori = $_POST['kategori'];

            // Insert data into 'kategori_relasi' table
            $sql_kategori_relasi = "INSERT INTO kategoribuku_relasi (BukuID, KategoriID) 
                                    VALUES ('$buku_id', (SELECT KategoriID FROM kategoribuku WHERE NamaKategori = '$selected_kategori'))";

            if (mysqli_query($koneksi, $sql_kategori_relasi)) {
                header("location: index.php?page=list_buku");
                exit();
            } else {
                echo "Error inserting data into kategoribuku_relasi table: " . mysqli_error($koneksi);
            }
        } else {
            echo "Error inserting data into buku table: " . mysqli_error($koneksi);
        }
    } else {
        echo "Error moving uploaded file to destination.";
    }
}

?>
