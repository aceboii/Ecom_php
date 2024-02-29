<?php

include 'connection.php';
session_start();
$admin_id = $_SESSION['admin_name'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if(isset($_POST['logout'])){
    session_destroy();
    header('location:login.php');
}

//delete from database
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `order` WHERE id = '$delete_id'") or die("query failed");
    $message[]= "order removed success";
    header('location:admin_order.php');
}

//updating order data
if(isset($_POST['update_payment'])){
    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `order` SET payment_status = '$update_payment' WHERE id='$order_id'") or die("query failed");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta detail="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>Admin Products</title>
</head>
<body>
    <?php include 'admin_header.php';?>
    <?php 
        if(isset($message)){
            foreach ($message as $message) {
                echo '
                <div class="message">
                <span>' . $message . '</span>
                <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                </div>
                ';
            }
        }
    ?>
    
    <section class="order-container"></section>
    <h2 class="title">total orders placed</h2>

    <div class="box-container">
        <?php 
        $select_orders = mysqli_query($conn, "SELECT * FROM `order`") or die('query failed');

        if(mysqli_num_rows($select_orders)> 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
                ?>

                <div class="box">
                    <p>user name: <span> <?php echo $fetch_orders['name'] ?></span></p>
                    <p>user id: <span> <?php echo $fetch_orders['user_id'] ?></span></p>
                    <p>placed on: <span> <?php echo $fetch_orders['placed_on'] ?></span></p>
                    <p>number <span> <?php echo $fetch_orders['number'] ?></span></p>
                    <p>email: <span> <?php echo $fetch_orders['email'] ?></span></p>
                    <p>total_price: <span> <?php echo $fetch_orders['total_price'] ?></span></p>
                    <p>method: <span> <?php echo $fetch_orders['method'] ?></span></p>
                    <p>address: <span> <?php echo $fetch_orders['address'] ?></span></p>
                    <p>total_products: <span> <?php echo $fetch_orders['total_products'] ?></span></p>
                    <form method="post">
                        <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id'] ?>">
                        <select name="update_payment">
                            <option disabled selected><?php echo $fetch_orders['payment_status'] ?></option>
                            <option value="pending">Pending</option>
                            <option value="complete">Complete</option>
                        </select>
                        <input type="submit" name="update_order" value="update_payment" class="btn" >
                        <a href="admin_order.php?delete=<?php echo $fetch_orders['id'];?>"
                        onclick="return confirm('this user will be deleted')" class="delete">Delete</a>
                    </form>
                    </div>
                <?php
            }
                    }else{
                        echo '
                        <div class="empty">
                        <p>no products added yet!</p>
                        </div>
                        ';
                        }
        ?>
    </div>

    <script src="script.js"></script>
</body>
</html>