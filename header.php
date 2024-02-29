<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>admin header</title>
</head>

<body>

    <header class="header">
        <div class="flex">
            <!-- <a href="admin_pannel.php" class="logo"><img src="img/logo.png"></a> -->
            <nav class="navbar">
                <a href="index.php">home</a>
                <a href="about.php">about</a>
                <a href="shop.php">shop</a>
                <a href="order.php">orders</a>
                <a href="contact.php">contact</a>
            </nav>
            <div class="icons">
                <i class="bi bi-person" id="user-btn"></i>
                <a href="wishlist.php">
                    <?php $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
                    $wishlist_num_rows = mysqli_num_rows($select_wishlist);?>
                    <i class="bi bi-heart"></i><sup><?php echo $wishlist_num_rows ?></sup>
                </a>
                <a href="cart.php">
                    <?php $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                    $cart_num_rows = mysqli_num_rows($select_cart);
                    ?>
                    <i class="bi bi-cart"></i><sup><?php echo $cart_num_rows ?></sup>
                </a>

            </div>
            <div class="user-box">
                <p>username : <span>
                        <?php echo $_SESSION['user_name']; ?>
                    </span></p>
                <p>Email : <span>
                        <?php echo $_SESSION['user_email']; ?>
                    </span></p>
                </div>
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">log out</button>
                </form>
        </div>
    </header>
</body>

</html>