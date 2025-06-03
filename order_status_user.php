<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get user email
$user_email = $_SESSION['email'];

// Fetch orders for the logged-in user
$orders = $conn->query("SELECT orders.*, food_status.food_name 
                        FROM orders 
                        JOIN food_status ON orders.food_id = food_status.id 
                        WHERE orders.user_email = '$user_email'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Status | FoodExpress</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">FoodExpress</a>
            <div class="nav-buttons"> 
                <ul class="navbar-nav"> 
                    <li class="nav-item"><a class="nav-link" href="cart.php">CART</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu.php">MENU</a></li>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class="text-center">Your Order Status</h1>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Food Item</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?= $order['food_name']; ?></td>
                        <td><?= $order['quantity']; ?></td>
                        <td>$<?= number_format($order['total_price'], 2); ?></td>
                        <td><?= date("M d, Y H:i", strtotime($order['order_date'])); ?></td>
                        <td>
                            <span class="badge bg-<?= $order['status'] === 'pending' ? 'warning' : ($order['status'] === 'preparing' ? 'info' : 'success'); ?>">
                                <?= ucfirst($order['status']); ?>
                            </span>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="user_home.php" class="btn btn-secondary">⬅ Back to Homepage</a>
        </div>
    </div>
</body>
</html>