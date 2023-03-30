<?php
session_start();
include_once "header.php";

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_name'])) {
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">
   <script src="https://unpkg.com/html5-qrcode" type="text/javascript">

   // <script src="html5-qrcode.min.js"></script>
   <style>
      /* Main container styles */
      body {
         background-color: #f2f2f2;
         font-family: Arial, sans-serif;
         margin: 0;
         padding: 0;
      }

      .container {
         background-color: white;
         border-radius: 10px;
         box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
         display: flex;
         flex-direction: column;
         align-items: center;
         justify-content: center;
         margin: 50px auto;
         max-width: 600px;
         padding: 40px;
      }

      .content {
         display: flex;
         flex-direction: column;
         align-items: center;
         justify-content: center;
      }

      h2 {
         font-size: 32px;
         font-weight: bold;
         text-align: center;
         margin-bottom: 20px;
         color: #4d4d4d;
      }

      h2 span {
         color: #0066cc;
      }

      form {
         display: flex;
         flex-direction: column;
         align-items: center;
         justify-content: center;
      }

      h4 {
         font-size: 24px;
         font-weight: bold;
         text-align: center;
         margin-bottom: 20px;
         color: #4d4d4d;
      }

      label {
         font-size: 16px;
         font-weight: bold;
         margin-bottom: 10px;
         color: #4d4d4d;
      }

      input[type="text"],
      input[type="file"],
      input[type="submit"] {
         width: 100%;
         padding: 10px;
         border: 1px solid #d9d9d9;
         border-radius: 5px;
         font-size: 16px;
         color: #4d4d4d;
         margin-bottom: 20px;
      }

      input[type="submit"] {
         background-color: #0066cc;
         color: white;
         cursor: pointer;
      }

      input[type="submit"]:hover {
         background-color: #0059b3;
      }
   </style>
</head>

<body>

   <div class="container">

      <div class="content">
         <br>
         <h2>Welcome <span>
               <?php echo $_SESSION['admin_name'] ?>!
            </span></h2>
         <br>
         <!-- Form for uploading PDF files -->
         <form method="post" action="upload.php" enctype="multipart/form-data">
            <h4>Upload PDF File</h4><br>
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" id="user_id"><br><br>
            <label for="pdf_file">PDF File:</label>
            <input type="file" name="pdf_file" id="pdf_file"><br><br>
            <input type="submit" name="submit" value="Upload">
         </form>
      </div>

   </div>
</body>

</html>