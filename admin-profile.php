<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if($user_id != 1){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>
    <link rel="stylesheet" href="style-admin-profile.css">

</head>
<body>
   
<div class="topnav">
  <a href="admin-panel.php">Dashboard</a>
  <a href="admin-profile.php" class="style-link-active">Profile</a>
</div>

<div class="container">

   <div class="profile">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
      ?>
      <h3><?php echo $fetch['name']; ?></h3>
      <a href="updateprofile-admin.php" class="btn">update profile</a>
      <a href="login.php?logout=<?php echo $user_id; ?>" class="delete-btn">logout</a>
   </div>

</div>

</body>
</html>