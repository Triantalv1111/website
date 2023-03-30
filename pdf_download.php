<?php

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_name'])) {
    // Redirect to login page if user is not logged in
    header('Location: login_form.php');
    exit();
}

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'user_db');

// Get the user ID and filename from the URL
if (isset($_GET['user_id']) && isset($_GET['filename'])) {
    $user_id = $_GET['user_id'];
    $filename = $_GET['filename'];

    // Check if the logged-in user is an admin
    if (isset($_SESSION['admin_name'])) {
        // Retrieve the file data for admins
        $query = "SELECT file_data FROM user_files WHERE file_name = '$filename'";
    } else {
        // Retrieve the file data for regular users
        $query = "SELECT file_data FROM user_files WHERE user_id = '$user_id' AND file_name = '$filename'";
    }

    $result = mysqli_query($conn, $query);

    // Check if the file exists and the user has access to it
    if (mysqli_num_rows($result) == 1) {
        // Get the file data from the database
        $row = mysqli_fetch_assoc($result);
        $file_data = $row['file_data'];

        // Serve the file to the user
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($file_data));
        echo $file_data;
        exit();
    } else {
        // Redirect to unauthorized page if file does not exist or user does not have access
        header('Location: unauthorized.php');
        exit();
    }
} else {
    echo "User ID or filename not found in URL";
}
?>