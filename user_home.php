<?php 
session_start(); 
if (!isset($_SESSION['email'])) { header("Location: login.php"); exit(); } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Homepage | FoodExpress</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .nav-buttons{
            display: inline-block;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">FoodExpress</a>
            <div class="nav-buttons"> 
                <ul class="navbar-nav"> 
                    <li class="nav-item"><a class="nav-link" href="cart.php">CART</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu.php">MENU</a></li>
                    <li class="nav-item"><a class="nav-link" href="order_status_user.php">ORDER STATUS</a></li>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <h1>Welcome to FoodExpress!</h1>
        <p>Browse our delicious menu and enjoy your favorite meals with ease.</p>
        <a href="menu.php" class="btn btn-primary">Start Ordering</a>
    </div>
</body>
</html>