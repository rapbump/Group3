<?php
session_start();
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'customer_db';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$results = $conn->query("SELECT * FROM products");
if (!$results) {
    die('Query failed: ' . $conn->error);
}
$prodResults = $conn->query("SELECT * FROM products");
if (!$prodResults) {        
    die('Query failed: ' . $conn->error);
}   
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
            <a href="../frontend/glowtrack.php">GlowTrack</a>
        </div>
        <nav>
            <a href="../frontend/order.php">Products</a>
        </nav>
    </header>
    <section class="cart">
        <h2>Your Cart</h2>
        <div class="products">
            <?php while ($row = $results->fetch_assoc()): ?>
                <div class="product-card">
                    <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</body>
</html>