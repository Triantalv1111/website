<?php

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header('Location: login_form.php');
    exit();
}

echo "User ID in session: " . $_SESSION['user_id'] . "<br>";

// Get the user ID and filename from the URL
if (isset($_GET['user_id']) && isset($_GET['filename'])) {
    $user_id = $_GET['user_id'];
    $filename = $_GET['filename'];

    echo "User ID in URL: " . $user_id . "<br>";

    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'user_db');

    // Retrieve the file data from the database
    $query = "SELECT file_data FROM user_files WHERE user_id = '$user_id' AND file_name = '$filename'";
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
