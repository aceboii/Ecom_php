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
                <a href="admin_panel.php">home</a>
                <a href="admin_product.php">products</a>
                <a href="admin_order.php">orders</a>
                <a href="admin_user.php">users</a>
                <a href="admin_message.php">messages</a>
            </nav>
            <div class="icons">
                <i class="bi bi-person" id="user-btn"></i>
            </div>
            <div class="user-box">
                <p>username : <span>
                        <?php echo $_SESSION['admin_name']; ?>
                    </span></p>
                <p>Email : <span>
                        <?php echo $_SESSION['admin_email']; ?>
                    </span></p>
                </div>
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">log out</button>
                </form>
        </div>
    </header>
</body>

</html>