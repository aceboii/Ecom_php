<?php
include "connection.php";
session_start();
if(isset($_POST['submit-btn'])){

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed...');

    $message = []; // Initialize $message as an array

    if (mysqli_num_rows($select_user)>0) {
      $row = mysqli_fetch_assoc($select_user);
      if ($row['user_type'] == 'admin') {
        $_SESSION['admin_name'] = $row['name'];
        $_SESSION['admin_email'] = $row['email'];
        $_SESSION['admin_id'] = $row['id'];
        header('location:admin_panel.php');
      }
      else if($row['user_type'] = 'user'){
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_id'] = $row['id'];
        header('location:index.php');
      }
      else{
        $message[] = 'incorrect credentials';
      }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>Login page</title>
</head>
<body>    
    <section class="form-container">
    <?php
        if (isset($message)) {
            foreach ($message as $message) {
                echo '
                <div class="message">
                <span>' .$message. '</span>
                <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                </div>
                ';
            }
        }
    ?>
        <form method="post">
            <h1>Login Now</h1>
            <div class="input-field">
                <label for="email">Your email</label>
                <input type="email" name="email" placeholder="enter your email" required>
            </div>
            <div class="input-field">
                <label for="password">Your password</label>
                <input type="password" name="password" placeholder="enter your password" required>
            </div>
           
            <input type="submit" value="register now" name="submit-btn" class="btn">
            <p>Dont have an account? <a href="register.php">Register</a></p>
        </form>
    </section>
</body>
</html>