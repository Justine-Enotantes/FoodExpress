<?php
session_start();
require_once 'config.php';

$foods = $conn->query("SELECT * FROM food_status WHERE status = 'available'");
if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }

if (isset($_POST['add_to_cart'])) {
    $food_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];
    $_SESSION['cart'][$food_id] = ($_SESSION['cart'][$food_id] ?? 0) + $quantity;
    echo "<script>alert('Added to cart!'); window.location='menu.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu | FoodExpress</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="user_home.php">FoodExpress</a>
            <a href="cart.php" class="btn btn-warning">View Cart</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center">Our Menu</h1>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Food Name</th>
                    <th>Price</th>
                    <th>Order</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($food = $foods->fetch_assoc()): ?>
                    <tr>
                        <td><img src="<?= $food['image_path']; ?>" width="80"></td>
                        <td><?= $food['food_name']; ?></td>
                        <td>$<?= number_format($food['price'], 2); ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="food_id" value="<?= $food['id']; ?>">
                                <input type="number" name="quantity" min="1" required class="form-control">
                                <button name="add_to_cart" type="submit" class="btn btn-success mt-2">Add to Cart</button>
                            </form>
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