<?php
// Pastikan untuk memulai sesi PHP jika belum dimulai
session_start();

// Sertakan file koneksi ke database Anda di sini
include '../config/koneksi.php';

// Periksa apakah tombol "Kembalikan" telah ditekan
if(isset($_POST['kembalikan'])) {
    // Ambil BukuID dari parameter POST
    $bukuID = $_POST['bukuID'];

    // Hapus data peminjaman berdasarkan BukuID yang statusnya telah diupdate menjadi tersedia
    // $updateTanggalQuery = "UPDATE peminjaman SET TanggalPengembalian = current_date() WHERE BukuID = $bukuID";
    // mysqli_query($koneksi, $updateTanggalQuery);

    $tanggalKembali = date('Y-m-d');

    // Impor peminjaman ke riwayat peminjaman
    $insertRiwayat = "INSERT INTO riwayat (PeminjamanID, BukuID, UserID, TanggalPeminjaman, TanggalKembali)
    SELECT PeminjamanID, BukuID, UserID, TanggalPeminjaman, NOW() AS TanggalKembali
    FROM peminjaman; -- Specify your source table here
    ";
    mysqli_query($koneksi, $insertRiwayat);

    // Delete data peminjaman
    $deletePeminjaman = "DELETE FROM peminjaman WHERE BukuID = $bukuID";
    mysqli_query($koneksi, $deletePeminjaman);


    // Redirect ke halaman sebelumnya atau halaman lain yang Anda inginkan setelah proses berhasil
    header("Location: index.php?page=peminjaman"); // Ganti dengan halaman yang sesuai
    exit();
}
?>
