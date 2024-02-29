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

if (isset($_POST['order-btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['city'] . ', ' . $_POST['country']);
    $placed_on = date('d-M-Y');
    $cart_total= 0;
    $cart_product[] = '';
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($cart_query)>0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_product[] = $cart_item['name'].' (' . $cart_item['quantity']. ')';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }
    $total_products= implode(',', $cart_product);
    mysqli_query($conn, "INSERT INTO `order`('user_id', 'name','number', 'email', 'method', 'address' ,'total_products','total_price','placed_on') VALUES('$user_id','$name','$number','$email'
    ,'$method','$address','$total_products','$cart_total', '$placed_on')");
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
    $message[] = 'order placed successfully';
    header('location:checkout.php');
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
<div class="checkout-form">
    <h1 class="title">Payment Process</h1>
    <?php if(isset($message)){
        echo '<div class="message">
        <span> ' .$message. '</span>
        <i class= "bi bi-x-circle" onclick="this.parentElement.remove()"></i>
        </div>
        ';
    } ?>
<div class="display-order">
    <?php
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    $total = 0;
    $grand_total = 0;
    if(mysqli_num_rows($select_cart)>0){
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $total_price = ($fetch_cart['price']*$fetch_cart['quantity']);
            $grand_total = $total+=$total_price;

            ?>

            <div class="box-container">
                <div class="box">
                    <img src="image/<?php echo $fetch_cart['image'] ?>" alt="">
                    <span><?= $fetch_cart['name'];?>(<?= $fetch_cart['quantity'] ?>)</span>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
<span class="grand-total">Total Amount: $<?= $grand_total ?></span>
</div>
<form method="post">
    <div class="input-field">
        <label for="name">Your name</label>
        <input type="text" name="name" placeholder="name">
    </div>
    <div class="input-field">
        <label for="number">Your number</label>
        <input type="text" name="number" placeholder="number">
    </div>
    <div class="input-field">
        <label for="email">Your email</label>
        <input type="text" name="email" placeholder="email">
    </div>
    <div class="input-field">
        <label for="payment_method">Payment method</label>
        <select name="method" id="">
            <option selected disabled>Select method</option>
            <option value="cash on delivery">Cash on delivery</option>
            <option value="credit card">Card</option>
        </select>
    </div>
    <div class="input-field">
        <label for="city">Your city</label>
        <input type="text" name="city" placeholder="city">
    </div>
    <div class="input-field">
        <label for="country">Your country</label>
        <input type="text" name="country" placeholder="country">
    </div>
    <input type="submit" value="order now" class="btn" name="order-btn">
</form>
<script src="./script2.js"></script>

</body>
</html>