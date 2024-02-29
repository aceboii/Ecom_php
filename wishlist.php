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


    //adding product to the cart
    if(isset($_POST['add_to_cart'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;
    
    $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
    
    if(mysqli_num_rows($cart_num)>0){
        $message[] = 'product already exist in wish list';   
    }else {
        mysqli_query($conn, "INSERT INTO `cart` (`user_id`, `pid`, `name`, `price`,`quantity`, `image`) VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
        $message[] = 'product successfully added in your cart';
    }
}

//deleting the product form wishlist
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE id ='$delete_id' ") or die("query failed");

    header('location:wishlist.php');
}

//deleting all product from wishlist
if(isset($_GET['delete_all'])){
    echo "Value of delete_all parameter: " . $_GET['delete_all'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id ='$user_id' ") or die("query failed");

    // Redirect to the wishlist page after deletion
    header('location:wishlist.php');
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
    <h2>Wish list</h2>

    <div class="box-container">
        <?php
        $grand_total = 0;
        $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist`") or die('query failed');
        if (mysqli_num_rows($select_wishlist)>0){
            while ($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)) {
                ?>
            <form method="post" class="box">
                <img src="image/<?php echo $fetch_wishlist['image']?>" alt="some image">
                <div class="name"><?php echo $fetch_wishlist['name'] ?></div>
                <input type="hidden" name="product_id" value= "<?php echo $fetch_wishlist['id']?>">
                <input type="hidden" name="product_name" value= "<?php echo $fetch_wishlist['name']?>">
                <input type="number" name="product_price" value= "<?php echo $fetch_wishlist['price']?>">
                <input type="hidden" name="product_image"  value= "<?php echo $fetch_wishlist['image']?>">
                <div class="icon">
                    <a href="view_page.php?pid=<?php echo $fetch_wishlist['id']?>" class="bi bi-eye-fill"></a>
                    <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']?>" class="bi bi-x" onclick= "return confirm('do you wnat to dleete this items in the wishlist')"></a>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                </div>
            </form>
                <?php
$grand_total += intval($fetch_wishlist['price']);
}
        }else{
            echo '<p class="empty">no product added yet!</p>';
        }
        ?>
    </div>

    <div class="wishlist_total">
        <p>total amount payable: <span>$ <?php echo $grand_total ?>/_</span></p>
        <a href="shop.php">Continue shoping</a>
        <a href="wishlist.php?delete_all" class="btn <?php echo ($grand_total)?'':'disabled' ?>" onclick= "return confirm('do you wnat to dleete all items form the wishlist')">Delete all</a>
    </div>
</section>
  
<script src="./script2.js"></script>

</body>
</html>