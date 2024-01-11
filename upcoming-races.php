<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:login.php');
}

// Fetch upcoming races from the database
$query = "SELECT * FROM race WHERE date >= CURDATE()";
$result = mysqli_query($conn, $query);

$races = [];
while ($row = mysqli_fetch_assoc($result)) {
    $races[] = $row;
}

// Handle race reservation logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reserve'])) {
        $race_id = $_POST['race_id'];
        $num_tickets = $_POST['num_tickets'];

        // Check if there are enough seats available
        $query = "SELECT seats FROM race WHERE id = $race_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $available_seats = $row['seats'];

        if ($available_seats >= $num_tickets) {
            // Perform the reservation and update the seats
            $query = "INSERT INTO race_ticket (user_id, race_id, no_tickets) VALUES ($user_id, $race_id, $num_tickets)";
            mysqli_query($conn, $query);

            $query = "UPDATE race SET seats = seats - $num_tickets WHERE id = $race_id";
            mysqli_query($conn, $query);

            // Redirect to avoid form resubmission on refresh
            header('Location: upcoming-races.php');
            exit;
        } else {
            $error_message = "Not enough seats available!";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upcoming Races</title>
  <link rel="stylesheet" href="style-upcoming-races.css">
</head>
<body>
<div class="topnav">
  <a href="index.php">Home</a>
  <a href="contact.php">Contact</a>
  <a class="active" href="upcoming-races.php">Upcoming Races</a>
  <a href="profile.php" class="style-link">Profile</a>
</div>

<div style="padding-left:16px">
  <h2>Races</h2>
          <?php foreach ($races as $race): ?>
            <div class="race-box">
                <h3><?= $race['name']; ?></h3>
                <p><?= $race['location']; ?></p>
                <p>Date: <?= $race['date']; ?></p>
                <p>Price: <?= $race['price']; ?> USD</p>
                <p>Available Seats: <?= $race['seats']; ?></p>

                <form method="post" action="">
                    <label for="num_tickets">Number of Tickets:</label>
                    <input type="number" name="num_tickets" min="1" max="<?= $race['seats']; ?>" required>
                    <input type="hidden" name="race_id" value="<?= $race['id']; ?>">
                    <button type="submit" name="reserve">Reserve Tickets</button>
                </form>
                
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?= $error_message; ?></p>
                <?php endif; ?>
            </div>
          <?php endforeach; ?>
</div>

</body>
</html>