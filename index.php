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
  <link rel="stylesheet" href="style-home.css">
</head>
<body>
<div class="topnav">
  <a class="active" href="index.php">Home</a>
  <a href="contact.php">Contact</a>
  <a href="upcoming-races.php">Upcoming Races</a>
  <a href="profile.php" class="style-link">Profile</a>
</div>

<div class="title">
  <div id="scroll-text">
    <h1>Grand Prix Motorcycle Racing is back!</h1>
    <h1>Grand Prix Motorcycle Racing is back!</h1>
    <h1>Grand Prix Motorcycle Racing is back!</h1>
    <h1>Grand Prix Motorcycle Racing is back!</h1>
    <h1>Grand Prix Motorcycle Racing is back!</h1>
  </div>
</div>
<div class="container">
  <div id="c-video">
    <video class="videoprincipal" src="media/MotoGPvid.mp4" controls></video>
  </div>
</div>
</body>
</html>