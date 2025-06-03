<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Fetch all pending orders
$orders = $conn->query("SELECT orders.*, users.name, food_status.food_name 
                        FROM orders 
                        JOIN users ON orders.user_email = users.email 
                        JOIN food_status ON orders.food_id = food_status.id 
                        WHERE orders.status = 'pending'");

// Approve order
if (isset($_POST['approve_order'])) {
    $order_id = $_POST['order_id'];
    $conn->query("UPDATE orders SET status = 'preparing' WHERE id = $order_id");
    echo "<script>alert('Order approved!'); window.location='admin_orders.php';</script>";
}

// Reject order
if (isset($_POST['reject_order'])) {
    $order_id = $_POST['order_id'];
    $conn->query("UPDATE orders SET status = 'cancelled' WHERE id = $order_id");
    echo "<script>alert('Order rejected!'); window.location='admin_orders.php';</script>";
}

// Update order status
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    $conn->query("UPDATE orders SET status = '$new_status' WHERE id = $order_id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Orders | FoodExpress</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center">Order Requests</h1>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Customer</th>
                    <th>Food Item</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?= $order['name']; ?></td>
                        <td><?= $order['food_name']; ?></td>
                        <td><?= $order['quantity']; ?></td>
                        <td>$<?= number_format($order['total_price'], 2); ?></td>
                        <td><?= date("M d, Y H:i", strtotime($order['order_date'])); ?></td>
                        <td>
                            <span class="badge bg-warning"><?= ucfirst($order['status']); ?></span>
                        </td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                <button name="approve_order" type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                <button name="reject_order" type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3 class="text-center mt-4">Update Order Status</h3>
        <form method="post" class="text-center">
            <select name="status" class="form-control w-50 mx-auto">
                <option value="preparing">Preparing</option>
                <option value="completed">Completed</option>
            </select>
            <button name="update_status" type="submit" class="btn btn-info mt-2">Update Status</button>
        </form>

        <div class="text-center mt-4">
            <a href="admin_dashboard.php" class="btn btn-secondary">⬅ Back to Dashboard</a>
        </div>
    </div>
</body>
</html>