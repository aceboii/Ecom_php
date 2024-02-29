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


    //updating product to the cart
    if(isset($_POST['update_qty_btn'])){
        $update_qty_id = $_POST['update_qty_id'];
        $update_value = $_POST['update_qty'];

        $udpate_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_qty_id'") or die('query failed');
        if($udpate_query){
            header('location:cart.php');
        }
    }

//deleting the product form wishlist
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id ='$delete_id' ") or die("query failed");

    header('location:cart.php');
}

//deleting all product from cart
if(isset($_GET['delete_all'])){
    echo "Value of delete_all parameter: " . $_GET['delete_all'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id ='$user_id' ") or die("query failed");

    // Redirect to the cart page after deletion
    header('location:cart.php');
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
    <h2>Cart</h2>

    <div class="box-container">
        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
        if (mysqli_num_rows($select_cart)>0){
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                ?>
            <div class="box">
                <div class="icon">
                    <a href="view_page.php?pid=<?php echo $fetch_cart['id']?>" class="bi bi-eye-fill"></a>
                    <a href="cart.php?delete=<?php echo $fetch_cart['id']?>" class="bi bi-x" onclick= "return confirm('do you want to delete this items in the cart')"></a>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                </div>
                <img src="image/<?php echo $fetch_cart['image']?>" alt="something">
                <div class="price">$<?php echo $fetch_cart['price']; ?></div>
                <div class="name"><?php echo $fetch_cart['name']; ?></div>
                <form method="post">
                    <input type="hidden" name="update_qty_id" value= "<?php echo $fetch_cart['id'] ?>">
                    <div class="qty">
                        <input type="number" name="update_qty" min="1" value="<?php echo $fetch_cart['quantity'] ?>">
                        <input type="submit" value="update" name="update_qty_btn">
                    </div>
                </form>
                <div class="total-amt">
                    total amount: <span>
                        <?php
                            echo $total_amt = ($fetch_cart['price']*$fetch_cart['quantity'])
                        ?>
                    </span>
                </div>
            </div>
                <?php
                $grand_total += intval($total_amt);
                }
                    }else{
                    echo '<p class="empty">no product added yet!</p>';
                    }       
        ?>
    </div>

    <div class="dlt">
    <a href="cart.php?delete_all" class="btn <?php echo ($grand_total)?'':'disabled' ?>" onclick= "return confirm('do you wnat to dleete all items form the cart')">Delete all</a>

    </div>

    <div class="wishlist_total">
        <p>total amount payable: <span>$ <?php echo $grand_total ?>/_</span></p>
        <a href="shop.php">Continue shoping</a>
        <a href="checkout.php?delete_all" class="btn <?php echo ($grand_total>1)?'':'disabled' ?>" onclick= "return confirm('do you wnat to dleete all items form the cart')">Proceed to checkout</a>
    </div>
</section>
  
<script src="./script2.js"></script>

</body>
</html>