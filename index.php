<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style-index.css">
</head>
<body>
<div class="topnav">
  <a class="active" href="index.php">Home</a>
  <a href="contact.php">Contact</a>
  <a href="upcoming-races.php">Upcoming Races</a>
  <a href="profile.php">Profile</a>
</div>

<div style="padding-left:16px">
  <h2>Home</h2>
</div>

</body>
</html>