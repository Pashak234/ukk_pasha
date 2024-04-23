<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/koneksi.php';

if (isset($_POST['hapus_buku'])) {
    $id_buku = $_POST['BukuID'];
    
    $query = mysqli_query($koneksi, "SELECT * FROM buku WHERE BukuID='$id_buku'");
    
    if ($query === false) {
        die('Error in SELECT query: ' . mysqli_error($koneksi));
    }

    $data = mysqli_fetch_array($query);

    if ($data) {
        // If the record is found, delete the associated file
        $coverPath = '../assets/covers/' . $data['CoverBuku'];
        
        if (is_file($coverPath)) {
            if (unlink($coverPath) === false) {
                die('Error deleting cover file: ' . error_get_last()['message']);
            }
        }

        // Delete the record from the database
        $deleteQuery = mysqli_query($koneksi, "DELETE FROM buku WHERE BukuID='$id_buku'");
        
        if ($deleteQuery === false) {
            die('Error in DELETE query: ' . mysqli_error($koneksi));
        }

        header('location:index.php?page=list_buku');
    } else {
        die('Record not found.');
    }
}
if (isset($_POST['hapus_user'])) {
    $id_user = $_POST['UserID'];

    // Perform the DELETE query directly
    $query = mysqli_query($koneksi, "DELETE FROM user WHERE UserID='$id_user'");

    if ($query) {
        header('location:index.php?page=user');
    } else {
        // Handle the case where the DELETE query fails
        echo "Failed to delete user. Error: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['hapus_petugas'])) {
    $id_petugas = $_POST['PetugasID'];

    // Perform the DELETE query directly
    $query = mysqli_query($koneksi, "DELETE FROM petugas WHERE PetugasID='$id_petugas'");

    if ($query) {
        header('location:index.php?page=petugas');
    } else {
        // Handle the case where the DELETE query fails
        echo "Failed to delete user. Error: " . mysqli_error($koneksi);
    }
}
if (isset($_POST['hapus_ulasan'])) {
    $id_ulasan = $_POST['UlasanID'];

    // Perform the DELETE query directly
    $query = mysqli_query($koneksi, "DELETE FROM ulasanbuku WHERE UlasanID='$id_ulasan'");

    if ($query) {
        header('location:index.php?page=ulasan');
    } else {
        // Handle the case where the DELETE query fails
        echo "Failed to delete user. Error: " . mysqli_error($koneksi);
    }
}
if (isset($_POST['hapus_kategori'])) {
    $id_kategori = $_POST['KategoriID'];

    // Perform the DELETE query directly
    $query = mysqli_query($koneksi, "DELETE FROM kategoribuku WHERE KategoriID='$id_kategori'");

    if ($query) {
        header('location:index.php?page=list_kategori');
    } else {
        // Handle the case where the DELETE query fails
        echo "Failed to delete user. Error: " . mysqli_error($koneksi);
    }
}
if (isset($_POST['update_buku'])) {
    // Get the edited data from the form
    $id_buku = $_POST['BukuID'];
    $kategori = $_POST['kategori']; // Corrected typo here
    $judul = $_POST['editJudul'];
    $penulis = $_POST['editPenulis'];
    $penerbit = $_POST['editPenerbit'];
    $tahun_terbit = $_POST['editTahunTerbit'];
    $rekomendasi = $_POST['editRekomendasi'];

    // Handle the updated cover image (if provided)
    if ($_FILES['editCover']['size'] > 0) {
        // Delete the old cover image
        $old_cover = $_POST['oldCover'];
        if (is_file('../images/covers/' . $old_cover)) {
            unlink('../images/covers/' . $old_cover);
        }

        // Upload the new cover image
        $new_cover = $_FILES['editCover']['name'];
        $tmp_cover = $_FILES['editCover']['tmp_name'];
        $cover_location = '../images/covers/';
        move_uploaded_file($tmp_cover, $cover_location . $new_cover);
    } else {
        // If no new cover image provided, use the existing one
        $new_cover = $_POST['oldCover'];
    }

    // Update the data in the database
    $query = "UPDATE buku SET 
                Judul='$judul', 
                Penulis='$penulis', 
                Penerbit='$penerbit', 
                TahunTerbit='$tahun_terbit', 
                CoverBuku='$new_cover',
                Rekomendasi='$rekomendasi'
              WHERE BukuID='$id_buku'";
    $result = mysqli_query($koneksi, $query);

    // Update the category of the book
    $query_update_kategori = "UPDATE kategoribuku_relasi SET KategoriID='$kategori' WHERE BukuID='$id_buku'";
    $result_kategori = mysqli_query($koneksi, $query_update_kategori);

    if ($result && $result_kategori) {
        // If the update is successful, redirect to the index page
        header('location:index.php?page=list_buku');
    } else {
        // If there's an error, display an error message or handle it accordingly
        echo "Error updating data: " . mysqli_error($koneksi);
    }
}


if (isset($_POST['update_user'])){
    //Get edited data from the form
    $id_user = $_POST['UserID'];
    $username = $_POST['editUsername'];
    $email = $_POST['editEmail'];
    $nama = $_POST['editNama'];
    $alamat = $_POST['editAlamat'];

    //Update data
    $query = "UPDATE user SET 
                Username='$username',
                Email='$email',
                NamaLengkap='$nama',
                Alamat='$alamat'
                WHERE UserID='$id_user'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // If the update is successful, redirect to the index page
        header('location:index.php?page=user');
    } else {
        // If there's an error, display an error message or handle it accordingly
        echo "Error updating data: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['update_user'])){
    //Get edited data from the form
    $id_petugas = $_POST['PetugasID'];
    $username = $_POST['editUsername'];
    $email = $_POST['editEmail'];
    $nama = $_POST['editNama'];

    //Update data
    $query = "UPDATE petugas SET 
                Username='$username',
                Email='$email',
                NamaLengkap='$nama',
                WHERE UserID='$id_petugas'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // If the update is successful, redirect to the index page
        header('location:index.php?page=petugas');
    } else {
        // If there's an error, display an error message or handle it accordingly
        echo "Error updating data: " . mysqli_error($koneksi);
    }
}
if (isset($_POST['konfirmasi'])) {
    // Retrieve the peminjamanID from the form submission
    $peminjamanID = $_POST['peminjamanID'];

    // Perform the database update query
    $query = mysqli_query($koneksi, "UPDATE peminjaman SET StatusPeminjaman = 'dipinjam' WHERE PeminjamanID = '$peminjamanID'");

    if ($query) {
        // Update successful
        // Redirect back to the page where the confirmation was made or any other appropriate page
        header("Location: index.php?page=peminjaman");
        exit();
    } else {
        // Update failed
        // Handle the error accordingly, for example, display an error message
        echo "Failed to update peminjaman status.";
    }
}
?>
