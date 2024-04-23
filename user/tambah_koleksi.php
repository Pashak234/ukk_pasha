<?php
session_start();
include '../config/koneksi.php';

if (empty($_SESSION['login'])) {
    header("location:../index.php");
    exit();
}

if (isset($_POST['koleksi'])) {
    // Ambil data BukuID dari form
    $BukuID = isset($_POST['BukuID']) ? $_POST['BukuID'] : 0;

    // Ambil UserID dari sesi yang sedang aktif
    $UserID = $_SESSION['UserID'];

    // Query untuk menambahkan buku ke koleksi pribadi
    $query = mysqli_query($koneksi, "INSERT INTO koleksipribadi (UserID, BukuID) VALUES ('$UserID', '$BukuID')");

    if($query) {
        echo '<script>alert("Tambah Data Berhasil."); window.location.href = "detail.php?BukuID='.$BukuID.'";</script>';
        exit();
    }else{
        echo '<script>alert("Tambah Data Gagal."); </script>';
    }
} else {
    // Redirect jika bukan aksi POST
    header("Location: ../index.php");
    exit();
}
?>
