<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

$messages = array(); // Inițializează array-ul pentru a evita erorile de tipul "Undefined variable"

if (isset($_POST['update_profile'])) {
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    $select_old_name = mysqli_query($conn, "SELECT name FROM `user_form` WHERE id = '$user_id'") or die('query failed');
    $old_name_result = mysqli_fetch_assoc($select_old_name);
    $old_name = $old_name_result['name'];

    $select_old_email = mysqli_query($conn, "SELECT email FROM `user_form` WHERE id = '$user_id'") or die('query failed');
    $old_email_result = mysqli_fetch_assoc($select_old_email);
    $old_email = $old_email_result['email'];
    
    if ($update_name != $old_name && $update_email != $old_email) {
        $messages[] = 'Username and email changed successfully!';
    } elseif ($update_name != $old_name) {
        $messages[] = 'Username changed successfully!';
    } elseif ($update_email != $old_email) {
        $messages[] = 'Email changed successfully!';
    }

    mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed');

    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));
 
    if(!($update_pass == 'd41d8cd98f00b204e9800998ecf8427e' || $new_pass == 'd41d8cd98f00b204e9800998ecf8427e' || $confirm_pass == 'd41d8cd98f00b204e9800998ecf8427e')){
       if($update_pass != $old_pass){
          $messages[] = 'old password not matched!';
       }elseif($new_pass != $confirm_pass){
          $messages[] = 'confirm password not matched!';}
       else{
          mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
          $messages[] = 'Password updated successfully!';
       }
    }
    if ($update_pass == 'd41d8cd98f00b204e9800998ecf8427e' && $new_pass != 'd41d8cd98f00b204e9800998ecf8427e' && $confirm_pass != 'd41d8cd98f00b204e9800998ecf8427e')
    {
       $messages[] = 'Old password is needed!';
    }
    elseif ($update_pass == 'd41d8cd98f00b204e9800998ecf8427e' && $new_pass != 'd41d8cd98f00b204e9800998ecf8427e' && $confirm_pass == 'd41d8cd98f00b204e9800998ecf8427e'){
       $messages[] = 'Old password is needed!';
    }
    else if ($update_pass == 'd41d8cd98f00b204e9800998ecf8427e' && $new_pass == 'd41d8cd98f00b204e9800998ecf8427e' && $confirm_pass != 'd41d8cd98f00b204e9800998ecf8427e'){
       $messages[] = 'Old password is needed!';
    }
    elseif(($update_pass != 'd41d8cd98f00b204e9800998ecf8427e' && $confirm_pass != 'd41d8cd98f00b204e9800998ecf8427e') && $new_pass == 'd41d8cd98f00b204e9800998ecf8427e')
    {
       $messages[] = 'New password is needed!';
    }
    elseif($confirm_pass == 'd41d8cd98f00b204e9800998ecf8427e' && ($update_pass != 'd41d8cd98f00b204e9800998ecf8427e' && $new_pass != 'd41d8cd98f00b204e9800998ecf8427e'))
    {
       $messages[] = 'Confirming the password is necessary!';
    }
 }


if (isset($_POST['delete_user'])) {
    $delete_user_id = $_POST['user_id'];
    mysqli_query($conn, "DELETE FROM `user_form` WHERE id = '$delete_user_id'") or die('query failed');
    $messages[] = 'User deleted successfully!';
    header('location:login.php');
}

$fetch = array(); // Inițializează array-ul pentru a evita erorile de tipul "Undefined variable"

$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>

   <link rel="stylesheet" href="style-register.css">
</head>
<body>
   
<div class="update-profile">
   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if (!empty($messages)) {
            foreach ($messages as $message) {
               echo '<div class="message">' . $message . '</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>Username:</span>
            <input type="text" name="update_name" value="<?php echo $fetch['name'] ?? ''; ?>" class="box">
            <span>Your email:</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email'] ?? ''; ?>" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password'] ?? ''; ?>">
            <span>Old password:</span>
            <input type="password" name="update_pass" class="box">
            <span>New password:</span>
            <input type="password" name="new_pass" class="box">
            <span>Confirm password:</span>
            <input type="password" name="confirm_pass" class="box">
         </div>
      </div>
      <input type="submit" value="Update Profile" name="update_profile" class="btn">
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
      <button type="submit" value="<?php echo $user_id; ?>" name="delete_user" class="delete-btn"  >Delete User</button>
      <a href="home.php" class="delete-btn">Go Back</a>
   </form>
</div>

</body>
</html>
