<?php  
session_start();
include 'koneksi.php';

// Mengambil username dan password
if(isset($_POST['kirim'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);

    // Query login
    $query = "SELECT * FROM petugas WHERE Username='$username' AND Password='$password'";
    $login = mysqli_query($koneksi, $query);

    // Cek eksekusi query dan fetch data
    if($login) {
        $data = mysqli_fetch_assoc($login);

        // Cek data login
        if ($data){
            $_SESSION['id_petugas'] = $data['PetugasID'];
            $_SESSION['nama_petugas'] = $data['NamaLengkap'];
            $_SESSION['login'] = $data['Level'];

            header('location: ../admin/');

        } else {
            // Data invalid
            $error_message = "Username atau Password salah";
        }
    } else {
         // Query execution error
         die('Query error: ' . mysqli_error($koneksi));
    }

    // Close connection
    mysqli_close($koneksi);
}
?>


