<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
<div class="user-races">
      <?php
         $select_races = mysqli_query($conn, "SELECT RACE.name, RACE.location, RACE.price, RACE.seats, RACE.date, RACE_TICKET.no_tickets FROM RACE INNER JOIN RACE_TICKET ON RACE.id = RACE_TICKET.race_id WHERE RACE_TICKET.user_id = '$user_id'");

         if(mysqli_num_rows($select_races) > 0){
            while($row = mysqli_fetch_assoc($select_races)){
               echo "<div class='race'>";
               echo "<h3 style='color:white;'>" . $row['name'] . "</h3>";
               echo "<p>Locatie: " . $row['location'] . "</p>";
               echo "<p>Data: " . $row['date'] . "</p>";
               echo "<p>Numar de bilete: " . $row['no_tickets'] . "</p>";
               echo "</div>";
            }
         } else {
            echo "<p>Nu aveti bilete la nicio cursa in acest moment.</p>";
         }
      ?>
</div>
</body>
</html>