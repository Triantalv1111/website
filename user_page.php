<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
   header('location:login_form.php');
}

// Fetch list of PDF files from database
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
   $stmt = $pdo->prepare("SELECT id, user_id, file_name FROM user_files WHERE user_id = ?");
   $stmt->execute([$_SESSION['user_id']]);
} else {
   $stmt = $pdo->prepare("SELECT id, user_id, file_name FROM user_files WHERE user_id = ?");
   $stmt->execute([$_SESSION['user_id']]);
}

$user_files = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>user page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         background-color: #f8f8f8;
         font-family: 'Roboto', sans-serif;
      }

      .container {
         max-width: 800px;
         margin: 0 auto;
         padding: 50px 0;
      }

      .content {
         background-color: #fff;
         border-radius: 10px;
         padding: 40px;
         box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      }

      h1,
      h3 {
         margin: 0;
         font-weight: normal;
      }

      h1 {
         font-size: 40px;
         margin-top: 10px;
      }

      h3 {
         font-size: 24px;
      }

      span {
         color: #e91e63;
      }

      img {
         display: block;
         margin: 20px auto;
         max-width: 100%;
         border-radius: 5px;
         box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      }

      p {
         font-size: 20px;
         margin-bottom: 20px;
      }

      a {
         display: block;
         font-size: 18px;
         color: #fff;
         background-color: #e91e63;
         padding: 10px 20px;
         border-radius: 5px;
         text-align: center;
         text-decoration: none;
         margin-top: 20px;
         transition: all 0.3s ease;
      }

      a:hover {
         background-color: #c2185b;
      }

      .logout {
         margin-top: 30px !important;
      }

      .pdf-container {
         display: flex;
         flex-wrap: wrap;
         justify-content: space-evenly;
      }

      .pdf-column {
         width: calc(33.33% - 10px);
         margin:5px;
      }

      .pdf-column a {
         display: block;
         font-size: 18px;
         color: #fff;
         background-color: #e91e63;
         padding: 10px 20px;
         border-radius: 5px;
         text-align: center;
         text-decoration: none;
         transition: all 0.3s ease;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
      }

      .pdf-column a:hover {
         background-color: #c2185b;
      }
   </style>
</head>

<body>

   <div class="container">

      <div class="content">
         <h3>hi, <span>user</span></h3>
         <h1>welcome <span>
               <?php echo $_SESSION['user_name'] ?>
            </span></h1>

         <?php
         $user_id = $_SESSION['user_id'];
         $qr_code_file = "qrcodes/user_$user_id.png";
         if (file_exists($qr_code_file)) {
            echo '<img width="200px" height="200px" src="' . $qr_code_file . '" alt="QR Code">';
         } else {
            echo '<p>No QR code available</p>';
         }
         ?>

         <?php $domain=$_SERVER['SERVER_NAME'];
            echo "<script>console.log($domain);</script>";
         ?>
         

         <p>Here are the available PDF files:</p>

         <div class="pdf-container">
            <?php foreach ($user_files as $pdf):
               $user_id = $pdf['user_id'];
               $filename = $pdf['file_name'];
               ?>
               <div class="pdf-column">
                  <a href="pdf_download.php?user_id=<?= $user_id ?>&filename=<?= $filename ?>"><?php echo $pdf['file_name'] ?></a>
               </div>
            <?php endforeach ?>
         </div>

         <a href="logout.php" class="btn logout">logout</a>
      </div>

   </div>

</body>

</html>