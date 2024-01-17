<?php

require '../vendor/autoload.php';
use Dompdf\Dompdf;

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


if(isset($_POST['export_pdf'])) {
   $dompdf = new Dompdf();

   ob_start(); 

   include('content_for_pdf.php'); 

   $html = ob_get_clean(); 

   $dompdf->loadHtml($html); 
   $dompdf->setPaper('A4', 'landscape'); 
   $dompdf->render(); 

   $dompdf->stream("bilete.pdf", array("Attachment" => false)); 
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>
    <link rel="stylesheet" href="style-profile.css">

</head>
<body>
   
<div class="topnav">
  <a href="index.php">Home</a>
  <a href="contact.php">Contact</a>
  <a href="upcoming-races.php">Upcoming Races</a>
  <a class="style-link-active" href="profile.php">Profile</a>
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
      <a href="update_profile.php" class="btn">update profile</a>
      <a href="login.php?logout=<?php echo $user_id; ?>" class="delete-btn">logout</a>
      <p>new <a href="login.php">login</a> or <a href="register.php">register</a></p>
   </div>

</div>
<h1 id = "yourraces">Your Tickets</h1>
<form method="post" class = "button-form">
    <input type="submit" name="export_pdf" value="Export to PDF" />
</form>
<div class="user-races">
      <?php
         $select_races = mysqli_query($conn, "SELECT RACE.name, RACE.location, RACE.price, RACE.seats, RACE.date, RACE_TICKET.no_tickets FROM RACE INNER JOIN RACE_TICKET ON RACE.id = RACE_TICKET.race_id WHERE RACE_TICKET.user_id = '$user_id'");

         if(mysqli_num_rows($select_races) > 0){
            while($row = mysqli_fetch_assoc($select_races)){
               echo "<div class='race'>";
               echo "<h3 style='color:white;'>" . $row['name'] . "</h3>"; // Asigură-te că stilul CSS este valid
               echo "<p>Locatie: " . $row['location'] . "</p>";
               echo "<p>Data: " . $row['date'] . "</p>";
               echo "<p>Numar de bilete: " . $row['no_tickets'] . "</p>"; // Afișează numărul de bilete
               echo "</div>";
            }
         } else {
            echo "<p>Nu aveti bilete la nicio cursa in acest moment.</p>";
         }
      ?>
</div>

</body>
</html>