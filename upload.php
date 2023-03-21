<?php

include 'config.php';

if(isset($_POST['submit'])){
   $user_id = $_POST['user_id'];

   // Check if user ID is valid
   $stmt = $conn->prepare("SELECT * FROM user_form WHERE id = ?");
   $stmt->bind_param("i", $user_id);
   $stmt->execute();
   $result = $stmt->get_result();
   if($result->num_rows == 0){
      echo "Invalid user ID";
      exit();
   }

   // Get the PDF file data
   $pdf_file = $_FILES['pdf_file']['tmp_name'];
   $pdf_data = file_get_contents($pdf_file);

   // Insert the PDF file data into the database
   $stmt = $conn->prepare("INSERT INTO user_files (user_id, file_name, file_data) VALUES (?, ?, ?)");
   $stmt->bind_param("iss", $user_id, $_FILES['pdf_file']['name'], $pdf_data);
   $stmt->execute();

   // Redirect back to the admin page
   header('location: admin_page.php');
   exit();
}
?>