<?php

include 'config.php';
include_once 'submit.php';
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
  <title>Contact Us</title>
  <link rel="stylesheet" href="style-index.css">
  <link rel="stylesheet" href="style-contact.css">

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>
<body>
<div class="topnav">
  <a href="index.php">Home</a>
  <a class = "active" href="contact.php">Contact</a>
  <a href="upcoming-races.php">Upcoming Races</a>
  <a href="profile.php">Profile</a>
</div>

<div class="container">
  <div class="wrapper">
    <div class="form-inner-cnt">
      <form action="" method="post" class="cnt-form">
        <h2>Contact Us</h2>

        <?php if(!empty($statusMsg)){ ?>
          <div class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></div>
        <?php } ?>

      <div class="form-input">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Enter your name" value="<?php echo !empty($postData['name'])?$postData['name']:''; ?>" required="">
      </div>

      <div class="form-input">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Enter your email" value="<?php echo !empty($postData['email'])?$postData['email']:''; ?>" required="">
      </div>

      <div class="form-input">
        <label for="subject">Subject</label>
        <input type="text" name="subject" placeholder="Enter subject" value="<?php echo !empty($postData['subject'])?$postData['subject']:''; ?>" required="">
      </div>

      <div class="form-input">
        <label for="message">Message</label>
        <textarea name="message" placeholder="Type your message here" required=""><?php echo !empty($postData['name'])?$postData['name']:''; ?></textarea>
      </div>
      <div class="form-input">
        <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
      </div>

      <input type="submit" name="submit" class="btn" value="Submit">



      </form>
    </div>
  </div>
</div>

</body>
</html>