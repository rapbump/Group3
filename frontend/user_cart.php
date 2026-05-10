<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "glowtrack_db";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("Connection Failed: ". $conn->connect_error);
}

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

if (!isset($_SESSION['user']['id'])) {
    die("You must be logged in to view your cart.");
}
$customer_id = (int)$_SESSION['user']['id'];

$stmt = $conn->prepare("
    SELECT p.product_id, p.pname AS product_name, p.price, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$results = $stmt->get_result();

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../style/cart.css">
     <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../frontend/users_page.php">GlowTrack</a>
        </div>
        <nav class="order">
            <a href="../frontend/user_order.php">Products</a>
        </nav>
    </header>
    <section class="cart">
        <h2>Your Cart</h2>
        <div class="products">
            <?php if ($results->num_rows === 0) : ?>
                <div class="no-products">
                    <h3>No products available</h3>
                </div>
            <?php else: ?>
            <?php while ($row = $results->fetch_assoc()): ?>
                <div class="product-card">
                    <h3><?= htmlspecialchars($row['product_name']) ?></h3>
                    <p>Price: ₱<?= htmlspecialchars($row['price']) ?></p>
                    <p>Quantity: <?= htmlspecialchars($row['quantity']) ?></p>
                    <p>Total: ₱<?= htmlspecialchars($row['price'] * $row['quantity']) ?></p>
                    <form action="/backend/place_order.php" method="POST">
                        <input type="hidden" name="action" value="place_order">
                        <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                        <input type="hidden" name="quantity" value="<?= $row['quantity'] ?>">
                        <button type="submit">Checkout</button>
                    </form>
                </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>