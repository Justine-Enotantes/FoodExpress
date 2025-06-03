<?php
require_once 'config.php';

// Get only available food items
$foods = $conn->query("SELECT * FROM food_status WHERE status = 'available'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>FoodExpress</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="position: sticky; top: 0; z-index: 1;">
        <div class="container">
            <a class="navbar-brand" href="index.html">FoodExpress</a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

          <div class="intro-section">
        <div class="container text-center">
            <h1>Welcome to FoodExpress!</h1>
            <p class="intro-text">
                Craving something delicious? At FoodExpress, we bring you the best meals from top restaurants,
                delivered right to your doorstep. Browse our menu, place an order, and enjoy great food hassle-free!
            </p>
        </div>
    </div>

    <h1 class="text-center mt-4">Our Top Dishes</h1>
    <div class="row">
        <?php while ($food = $foods->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="dish-card">
                    <img src="<?= $food['image_path']; ?>" alt="<?= $food['food_name']; ?>">
                    <div class="hover-overlay">
                        <h2 class="dish-name"><?= strtoupper($food['food_name']); ?></h2>
                        <button class="btn btn-primary" onclick="location.href='login.php'">Order Now</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>         