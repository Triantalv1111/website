<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_id'])){
   header('location:login_form.php');
}

// Fetch list of PDF files from database
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
   $stmt = $pdo->prepare("SELECT id, file_name FROM user_files WHERE user_id = ?");
   $stmt->execute([$_SESSION['user_id']]);
} else {
   $stmt = $pdo->prepare("SELECT id, file_name FROM user_files WHERE user_id = ?");
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

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>hi, <span>user</span></h3>
      <h1>welcome <span><?php echo $_SESSION['user_name'] ?></span></h1>
      <p>Here are the available PDF files:</p>

      <?php foreach ($user_files as $pdf): ?>
         <div>
            <a href="pdf_download.php?id=<?php echo $pdf['id'] ?>"><?php echo $pdf['file_name'] ?></a>
         </div>
      <?php endforeach ?>

      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>
