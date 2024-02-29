<?php

session_start();
include 'connection.php';
$user_id = $_SESSION['user_name'];

if (!isset($user_id)) {
    header('location:login.php');
}

if(isset($_POST['logout'])){
    session_destroy();
    header('location:login.php');    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">

    <title>Index page of user</title>
</head>
<body>
<?php include "header.php" ?>
<div class="banner">
    <div class="order-section">
        <div class="box-container">
            <?php 
        $select_order = mysqli_query($conn, "SELECT * FROM `order` WHERE user_id = '$user_id'") or die('query failed');
                if(mysqli_num_rows($select_order)>0){
                    while ($fetch_order= mysqli_fetch_assoc($select_order)) {
                    ?>
                    
                    <div class="box">
                        <p>Placed On: <span><?php echo $fetch_order['placed_on'] ?></span></p>
                        <p>name: <span><?php echo $fetch_order['name'] ?></span></p>
                        <p>number: <span><?php echo $fetch_order['number'] ?></span></p>
                        <p>email: <span><?php echo $fetch_order['email'] ?></span></p>
                        <p>address: <span><?php echo $fetch_order['address'] ?></span></p>
                        <p>payment method: <span><?php echo $fetch_order['method'] ?></span></p>
                        <p>your order: <span><?php echo $fetch_order['total_products'] ?></span></p>
                        <p>total price: <span><?php echo $fetch_order['total_price'] ?></span></p>
                        <p>payment status: <span><?php echo $fetch_order['payment_status'] ?></span></p>
                    </div>
                    
                    
                    <?php
                    }
                }else {
                    echo '<div class="empty>no order palced</div>"';
                }
            ?>
        </div>
    </div>
</div>
<script src="./script2.js"></script>

</body>
</html>