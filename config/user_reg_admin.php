<?php
include 'koneksi.php';

if(isset($_POST['kirim'])){

$username = $_POST['username'];
$password = md5($_POST['password']);
$email = $_POST['email'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];

// Cek jika username atau data yang sama sudah ada
$query = "SELECT * FROM user WHERE Username='$username' OR Email='$email'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    // Jika username atau email sudah ada, tampilkan pesan kesalahan
    $error_message = "Username atau email sudah digunakan. Silakan gunakan yang lain.";
} else {
    $sql = mysqli_query($koneksi, "INSERT INTO user VALUES ('', '$username', '$password', '$email', '$nama', '$alamat')");
    if($sql){
        header('location: ../admin/index.php?page=user');
    }            
    
}
}
?>