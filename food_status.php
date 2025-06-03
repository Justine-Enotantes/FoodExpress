<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Ensure the folder for food images exists
$upload_dir = "asset/food_images/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle new food addition
if (isset($_POST['add_food'])) {
    $food_name = $_POST['food_name'];
    $price = $_POST['food_price'];
    $image_name = $_FILES['food_image']['name'];
    $image_tmp = $_FILES['food_image']['tmp_name'];
    $image_path = $upload_dir . time() . '_' . $image_name; // Unique filename

    // Move uploaded image to the folder
    if (move_uploaded_file($image_tmp, $image_path)) {
        $conn->query("INSERT INTO food_status (food_name, image_path, price, status) VALUES ('$food_name', '$image_path', '$price', 'available')");
        echo "<script>alert('Food item added successfully!'); window.location='food_status.php';</script>";
    } else {
        echo "<script>alert('Error uploading image');</script>";
    }
}

// Handle food deletion
if (isset($_POST['delete_food'])) {
    $food_id = $_POST['food_id'];

    // Fetch the image path from the database
    $result = $conn->query("SELECT image_path FROM food_status WHERE id = $food_id");
    $row = $result->fetch_assoc();
    $image_path = $row['image_path'];

    // Delete the image file from the server
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    // Remove food from the database
    if ($conn->query("DELETE FROM food_status WHERE id = $food_id")) {
        echo "<script>alert('Food item removed successfully!'); window.location='food_status.php';</script>";
    } else {
        echo "<script>alert('Error deleting food item');</script>";
    }
}

// Handle status toggling
if (isset($_POST['toggle'])) {
    $food_id = $_POST['food_id'];
    $new_status = $_POST['status'] === 'available' ? 'not available' : 'available';
    $conn->query("UPDATE food_status SET status = '$new_status' WHERE id = $food_id");
}

// Handle price update
if (isset($_POST['update_price'])) {
    $food_id = $_POST['food_id'];
    $new_price = $_POST['new_price'];
    $conn->query("UPDATE food_status SET price = '$new_price' WHERE id = $food_id");
}

// Fetch food items
$foods = $conn->query("SELECT * FROM food_status");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Food Status | FoodExpress</title>
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
        <h1 class="text-center">FOOD STATUS</h1>

        <!-- Add Food Form -->
        <div class="card p-4 shadow">
            <h3>Add a New Food Item</h3>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="text" name="food_name" class="form-control" placeholder="Enter food name" required>
                </div>
                <div class="mb-3">
                    <input type="number" name="food_price" class="form-control" placeholder="Enter price" required>
                </div>
                <div class="mb-3">
                    <input type="file" name="food_image" class="form-control" accept="image/*" required>
                </div>
                <button name="add_food" type="submit" class="btn btn-success w-100">Add Food</button>
            </form>
        </div>

        <!-- Food List -->
        <table class="table table-bordered text-center mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($food = $foods->fetch_assoc()): ?>
                    <tr>
                        <td><img src="<?= $food['image_path']; ?>" alt="<?= $food['food_name']; ?>" width="80"></td>
                        <td><?= $food['food_name']; ?></td>
                        <td>$<?= number_format($food['price'], 2); ?></td>
                        <td><?= ucfirst($food['status']); ?></td>
                        <td>
                            <!-- Update Price Form -->
                            <form method="post" class="mb-2">
                                <input type="hidden" name="food_id" value="<?= $food['id']; ?>">
                                <input type="number" step="0.01" name="new_price" value="<?= $food['price']; ?>" class="form-control">
                                <button name="update_price" type="submit" class="btn btn-info mt-2">Update Price</button>
                            </form>

                            <!-- Other Actions (Toggle Status, Delete) -->
                            <form method="post">
                                <input type="hidden" name="food_id" value="<?= $food['id']; ?>">
                                <input type="hidden" name="status" value="<?= $food['status']; ?>">
                                <button name="toggle" type="submit" class="btn btn-warning">Toggle Status</button>
                                <button name="delete_food" type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>