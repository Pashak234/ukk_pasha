<?php
include 'koneksi.php';

if(isset($_POST['kirim'])){

$username = $_POST['username'];
$password = md5($_POST['password']);
$email = $_POST['email'];
$nama = $_POST['nama'];
$level = $_POST['level'];

$sql = mysqli_query($koneksi, "INSERT INTO petugas VALUES ('', '$username', '$password', '$nama', '$email', '$level')");

if($sql){
    header('location: ../admin/index.php?page=petugas');
}            

}
?>