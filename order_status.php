<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Handle status updates
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    $conn->query("UPDATE orders SET status = '$new_status' WHERE id = $order_id");
}

// Fetch orders
$orders = $conn->query("SELECT * FROM orders");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Requests | Admin</title>
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

    <div class="container mt-4">
        <h1 class="text-center">ORDERS</h1>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Food Item</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?= $order['id']; ?></td>
                        <td><?= $order['user_name']; ?></td>
                        <td><?= $order['food_name']; ?></td>
                        <td>
                            <span class="badge bg-<?= $order['status'] === 'pending' ? 'warning' : ($order['status'] === 'preparing' ? 'info' : 'success'); ?>">
                                <?= ucfirst($order['status']); ?>
                            </span>
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                <select name="new_status" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="preparing">Preparing</option>
                                    <option value="completed">Completed</option>
                                </select>
                                <button name="update_status" type="submit" class="btn btn-primary mt-2">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>