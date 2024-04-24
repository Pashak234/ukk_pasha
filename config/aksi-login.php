<?php
session_start();
include 'koneksi.php';

if(isset($_POST['kirim'])){
    $username =  $_POST['username'];
    $password = $_POST['password'];

    $password_hashed = md5($password);

    $login = mysqli_query($koneksi, "SELECT * FROM user WHERE Username='$username' AND Password='$password_hashed';");

    if($login){
        $data = mysqli_fetch_assoc($login);

        if($data){
            $_SESSION['user_login'] = true; // Gunakan session khusus untuk pengguna
            $_SESSION['UserID'] = $data['UserID'];
            $_SESSION['username'] = $data['Username'];
            header('location: /ukk_pasha/user/index.php');
            exit();
        }else{
            $error_message = "Username atau password salah";
        }
    }else{
        echo "Error executing the query";
    }
}
?>
