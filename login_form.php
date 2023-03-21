<?php

session_start();

if(isset($_POST['submit'])){

   // Include database connection file
   include 'config.php';

   // Get user input
   $email = $_POST['email'];
   $password = md5($_POST['password']);

   // Prepare and execute query to fetch user from database
   $stmt = $pdo->prepare("SELECT id, name, user_type FROM user_form WHERE email = ? AND password = ?");
   $stmt->execute([$email, $password]);
   $user = $stmt->fetch(PDO::FETCH_ASSOC);

   // Check if user was found
   if($user){

      // Set session variables based on user type
      if($user['user_type'] == 'admin'){
         $_SESSION['admin_name'] = $user['name'];
         header('location:admin_page.php');
      }
      elseif($user['user_type'] == 'user'){
         $_SESSION['user_name'] = $user['name'];
         $_SESSION['user_id'] = $user['id'];
         header('location:user_page.php');
      }
   }
   else{
      $error = 'Incorrect email or password';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Login Now</h3>
      <?php
      if(isset($error)){
         echo '<span class="error-msg">'.$error.'</span>';
      }
      ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login Now" class="form-btn">
      <p>Don't have an account? <a href="register_form.php">Register Now</a></p>
   </form>

</div>

</body>
</html>
