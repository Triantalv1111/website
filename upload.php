<?php

require_once "phpqrcode/qrlib.php";
include 'config.php';

if (isset($_POST['submit'])) {
   $user_id = $_POST['user_id'];

   // Check if user ID is valid
   $stmt = $conn->prepare("SELECT * FROM user_form WHERE id = ?");
   $stmt->bind_param("i", $user_id);
   $stmt->execute();
   $result = $stmt->get_result();
   if ($result->num_rows == 0) {
      echo "Invalid user ID";
      exit();
   } else {
      $row = $result->fetch_assoc();
      $name = $row['name'];
      $email = $row['email'];

   }

   // Get the PDF file data
   $pdf_file = $_FILES['pdf_file']['tmp_name'];
   $pdf_data = file_get_contents($pdf_file);
   $pdf_name = $_FILES['pdf_file']['name'];

   // Insert the PDF file data into the database
   $stmt = $conn->prepare("INSERT INTO user_files (user_id, file_name, file_data) VALUES (?, ?, ?)");
   $stmt->bind_param("iss", $user_id, $_FILES['pdf_file']['name'], $pdf_data);
   $stmt->execute();


   // Get all the PDF file names for the user
   $stmt = $conn->prepare("SELECT file_name FROM user_files WHERE user_id = ?");
   $stmt->bind_param("i", $user_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $pdf_links = '';
   while ($row = $result->fetch_assoc()) {
      $pdf_file_name = $row['file_name'];
      // Generate a link to the PDF file
      $pdf_link = "https://{$_SERVER['HTTP_HOST']}/website/pdf_download.php?user_id=$user_id&filename=$pdf_file_name";
      // Add the PDF file link to the QR code data
      $pdf_links .= '<a href="' . $pdf_link . '">' . $row['file_name'] . '</a>, ';
   }
   $pdf_links = rtrim($pdf_links, ", ");

   // Generate the QR code
   $qr_code_data = "ID: " . $user_id . "\nName: " . $name . "\nEmail: " . $email . "\nPDF Files:- \n" . '<div>' . $pdf_links . '</div>';
   $qr_code_file = "qrcodes/user_$user_id.png";
   QRcode::png($qr_code_data, $qr_code_file);

   // Give an alert and delay the redirection
   echo "<script>alert('Uploaded Successfully');setTimeout(function(){window.location.href='admin_page.php';}, 1000);</script>";
   exit();
}
?>