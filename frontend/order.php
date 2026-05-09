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
        <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <title>Order</title>
    <link rel="stylesheet" href="../style/order.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../frontend/glowtrack.php">GlowTrack</a>
        </div>
        <nav>
            <a href="../frontend/cart.php">Cart</a>
        </nav>
    </header>
    <main class="market">
        <h2>Available Products:</h2>
        <div class="products">
            <?php while ($row = $results->fetch_assoc()): ?>
                <div class="product-card">
                    <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                    <form action="../backend/cart.php" method="POST">
                        <input type="hidden" name="action" value="add_to_cart">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['product_id']); ?>">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            <?php endwhile; ?>

    </main>
</body>
</html>