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



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_race'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $seats = $_POST['seats'];
    $date = $_POST['date'];

    // SQL pentru adaugarea cursei
    $sql = "INSERT INTO race (name, location, price, seats, date) VALUES ('$name', '$location', '$price', '$seats', '$date')";

    if ($conn->query($sql) === TRUE) {
        header("location:admin-panel.php");
    } else {
        echo "Eroare: " . $sql . "<br>" . $conn->error;
    }
}

// Stergere cursa
if (isset($_GET['delete_race'])) {
    $race_id = $_GET['delete_race'];

    // SQL pentru ștergerea cursei
    $sql = "DELETE FROM race WHERE id = $race_id";

    if ($conn->query($sql) === TRUE) {
      header("location:admin-panel.php");
    } else {
        echo "Eroare: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style-adm.css">
</head>
<body>

  <div class="topnav">
    <a class ="active" href="admin-panel.php">Dashboard</a>
    <a href="admin-profile.php" class="style-link">Profile</a>
  </div>

    <h1>Dashboard</h1>

    <!-- Formular pentru adăugare cursa -->
    <form id='myform' method="post" action="">
        <label for="name">Race name:</label>
        <input type="text" name="name" required>
        <label for="location">Location:</label>
        <input type="text" name="location" required>
        <label for="price">Price:</label>
        <input type="text" name="price" required>
        <label for="price">Seats:</label>
        <input type="text" name="seats" required>
        <label for="date">Date:(yyyy-mm-dd)</label>
        <input type="text" name="date" required>
        <button type="submit" name="add_race">Add race</button>
    </form>

    <!-- Lista cu cursele existente -->
    <h2>Current races:</h2>
    <ul>
        <?php
        $result = $conn->query("SELECT * FROM race");

        while ($row = $result->fetch_assoc()) {
            echo "<li class='race-item'>{$row['name']} - Location: {$row['location']} - Price: {$row['price']} - Date: {$row['date']} <a href='?delete_race={$row['id']}'>Delete</a></li>";
        }
        ?>
    </ul>

</body>
</html>