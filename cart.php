<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }

if (isset($_POST['remove_from_cart'])) {
    $food_id = $_POST['food_id'];
    unset($_SESSION['cart'][$food_id]);
}

if (isset($_POST['checkout'])) {
    $user_email = $_SESSION['email'];
    foreach ($_SESSION['cart'] as $food_id => $quantity) {
        $result = $conn->query("SELECT price FROM food_status WHERE id = $food_id");
        $food = $result->fetch_assoc();
        $total_price = $food['price'] * $quantity;
        $conn->query("INSERT INTO orders (user_email, food_id, quantity, total_price) VALUES ('$user_email', $food_id, $quantity, $total_price)");
    }
    $_SESSION['cart'] = [];
    echo "<script>alert('Order placed successfully!'); window.location='cart.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping Cart | FoodExpress</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="user_home.php">FoodExpress</a>
            <a href="menu.php" class="btn btn-success">Continue Shopping</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center">Your Cart</h1>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Food Item</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $food_id => $quantity): ?>
                    <?php 
                    $result = $conn->query("SELECT food_name FROM food_status WHERE id = $food_id");
                    $food = $result->fetch_assoc();
                    ?>
                    <tr>
                        <td><?= $food['food_name']; ?></td>
                        <td><?= $quantity; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="food_id" value="<?= $food_id; ?>">
                                <button name="remove_from_cart" type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form method="post" class="text-center">
            <button name="checkout" type="submit" class="btn btn-primary mt-3">Checkout</button>
        </form>
    
</div>
    </div>
</body>
</html>