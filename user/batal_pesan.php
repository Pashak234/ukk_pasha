<?php
// Include your database connection file
include '../config/koneksi.php';

// Check if the bukuID is provided in the POST request
if(isset($_POST['bukuID'])) {
    // Retrieve the bukuID from the POST request
    $bukuID = $_POST['bukuID'];

    // Sanitize the input (optional but recommended)
    $bukuID = mysqli_real_escape_string($koneksi, $bukuID);

    // Query to delete the record from the peminjaman table
    $deleteQuery = "DELETE FROM peminjaman WHERE BukuID = '$bukuID'";

    // Execute the delete query
    $result = mysqli_query($koneksi, $deleteQuery);

    // Check if the deletion was successful
    if($result) {
        // Redirect back to the previous page
        header("Location: index.php?page=profile");
        exit();
    } else {
        // If deletion fails, display an error message or handle the error accordingly
        echo "Failed to cancel the booking. Please try again.";
    }
} else {
    // If bukuID is not provided, redirect the user to an error page or handle the error accordingly
    echo "BukuID is not provided.";
}
?>
