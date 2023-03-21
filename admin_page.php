<?php
session_start();

// Redirect to login page if user is not logged in
if(!isset($_SESSION['admin_name'])){
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
</head>
<body>
   
   <div class="container">

      <div class="content">
         <h3>Hi, <span>admin</span></h3>
         <h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
         <p>This is an admin page</p>

         <!-- Form for uploading PDF files -->
         <form method="post" action="upload.php" enctype="multipart/form-data">
            <h2>Upload PDF File</h2>
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" id="user_id"><br>
            <label for="pdf_file">PDF File:</label>
            <input type="file" name="pdf_file" id="pdf_file"><br>
            <input type="submit" name="submit" value="Upload">
         </form>

         <a href="logout.php" class="btn">Logout</a>
      </div>

   </div>

</body>
</html>