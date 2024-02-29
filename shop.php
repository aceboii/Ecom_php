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


//adding product to the wishlist
if(isset($_POST['add_to_wishlist'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    
    
    $wishlist_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
    
    $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    
    if(mysqli_num_rows($wishlist_number)> 0){
        $message[] = 'product already exist in wish list';
    }else if(mysqli_num_rows($cart_num)>0){
        $message[] = 'product already exist in wish list';   
    }else {
        mysqli_query($conn, "INSERT INTO `wishlist` (user_id, pid, name, price, image) VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')");
        $message[] = 'product successfully added in your wishlist';
    }
    
    }
    //adding product to the cart
    if(isset($_POST['add_to_cart'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];
    
    $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
    
    if(mysqli_num_rows($cart_num)>0){
        $message[] = 'product already exist in wish list';   
    }else {
        mysqli_query($conn, "INSERT INTO `cart` (`user_id`, `pid`, `name`, `price`,`quantity`, `image`) VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
        $message[] = 'product successfully added in your cart';
    }
    
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


<section class="popular-brands">
    <h2>Popular brands</h2>

    <div class="box-container">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
        if (mysqli_num_rows($select_products)>0){
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {

                ?>
            <form class="box" method="post" style="height:auto;width:500px">
                <img src="image/<?php echo $fetch_products['image']?>" alt="some image">
                <!-- <div class="price"><?php echo $fetch_products['price'] ?></div> -->
                <div class="name"><?php echo $fetch_products['name'] ?></div>
                <input type="hidden" name="product_id" value= "<?php echo $fetch_products['id']?>">
                <input type="hidden" name="product_name" value= "<?php echo $fetch_products['name']?>">
                <input type="hidden" name="product_price" value= "<?php echo $fetch_products['price']?>">
                <input type="hidden" name="product_quantity" value="1" min="1">
                <input type="hidden" name="product_image"  value= "<?php echo $fetch_products['image']?>">
                <div class="icon">
                    <a href="view_page.php?pid=<?php echo $fetch_products['id']?>" class="bi bi-eye-fill"></a>
                    <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                </div>
            </form>
                <?php
            }
        }else{
            echo '<p class="empty">no product added yet!</p>';
        }
        ?>
    </div>
</section>
  


<script src="./script2.js"></script>

</body>
</html>