<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']), ENT_QUOTES, 'UTF-8');
   $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']), ENT_QUOTES, 'UTF-8');
   $pass = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']), ENT_QUOTES, 'UTF-8');
   $cpass = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['cpassword']), ENT_QUOTES, 'UTF-8');


   $stmt = mysqli_prepare($conn, "SELECT * FROM `user_form` WHERE email = ? OR name = ?");
   mysqli_stmt_bind_param($stmt, 'ss', $email, $name);
   mysqli_stmt_execute($stmt);
   $select = mysqli_stmt_get_result($stmt);

   if (mysqli_num_rows($select) > 0) {
      $message[] = 'User or email already exists';
   }else{
      if ($pass != $cpass) {
        $message[] = 'Confirm password not matched!';
      }else{
        $insert = mysqli_query($conn, "INSERT INTO `user_form` (name, email, password, user_type) VALUES ('$name', '$email', '$pass', 'user')") or die('query failed');

        if ($insert) {
            $message[] = 'Registered successfully!';
            header('location: login.php');
        } else {
            $message[] = 'Registration failed!';
        }
    }
}


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <link rel="stylesheet" href="style-register.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>register now</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="enter username" class="box" required>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>