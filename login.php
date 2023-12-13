<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']), ENT_QUOTES, 'UTF-8');
   $pass = htmlspecialchars(mysqli_real_escape_string($conn, md5($_POST['password'])), ENT_QUOTES, 'UTF-8');

   $stmt = mysqli_prepare($conn, "SELECT * FROM `user_form` WHERE email = ? AND password = ?");
   mysqli_stmt_bind_param($stmt, 'ss', $email, $pass);
   mysqli_stmt_execute($stmt);
   $select = mysqli_stmt_get_result($stmt);

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      if ($row['user_type'] == 'user'){
         header('location:index.php');
      }
      else{ // admin header
         header('location:admin-panel.php');
      }
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <link rel="stylesheet" href="style-register.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>login now</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="submit" name="submit" value="login now" class="btn">
      <p>don't have an account? <a href="register.php">regiser now</a></p>
   </form>

</div>

</body>
</html>