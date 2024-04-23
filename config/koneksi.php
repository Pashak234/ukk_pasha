<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'perpustakaan_ukk';
$koneksi = mysqli_connect("$servername","$username","$password","$dbname");

if(!$koneksi){
    echo "gagal koneksi ke MySQL: " . mysqli_connect_error();
}
?>