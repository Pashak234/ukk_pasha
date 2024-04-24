<?php  
session_start();
include 'koneksi.php';

if(isset($_POST['kirim'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM petugas WHERE Username='$username' AND Password='$password'";
    $login = mysqli_query($koneksi, $query);

    if($login) {
        $data = mysqli_fetch_assoc($login);

        if ($data){
            $_SESSION['admin_login'] = true; // Gunakan session khusus untuk admin
            $_SESSION['id_petugas'] = $data['PetugasID'];
            $_SESSION['nama_petugas'] = $data['NamaLengkap'];
            $_SESSION['login'] = $data['Level'];

            header('location: ../admin/');
        } else {
            $error_message = "Username atau Password salah";
        }
    } else {
         die('Query error: ' . mysqli_error($koneksi));
    }

    mysqli_close($koneksi);
}
?>
