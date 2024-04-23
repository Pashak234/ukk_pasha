<?php
include '../config/koneksi.php';

if(isset($_GET['buku_id']) && isset($_GET['user_id']) && !empty($_GET['buku_id']) && !empty($_GET['user_id'])) {
    $bukuId = $_GET['buku_id'];
    $userId = $_GET['user_id'];
    
    // Perform the delete operation here
    $deleteQuery = mysqli_query($koneksi, "DELETE FROM koleksipribadi WHERE BukuID = '$bukuId' AND UserID = '$userId'");
    
    if($deleteQuery) {
        // Redirect to the page where koleksi is displayed
        header("Location: index.php?page=koleksi");    
        exit();
    } else {
        echo "Failed to delete koleksi.";
    }
} else {
    echo "Invalid request.";
}
?>
