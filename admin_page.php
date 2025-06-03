<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | FoodExpress</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">FoodExpress</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>


    <div class="container text-center mt-5">
    <h1>ADMIN DASHBOARD</h1>
    <div class="row justify-content-center mt-4">
        <div class="col-md-4">
            <div class="card shadow p-3">
                <a href="food_status.php" class="btn btn-success btn-lg w-100">Food Status</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow p-3">
                <a href="admin_orders.php" class="btn btn-success btn-lg w-100">Orders</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow p-3">
                <a href="order_status.php" class="btn btn-success btn-lg w-100">Order Status</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>