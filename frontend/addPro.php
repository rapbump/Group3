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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../style/addPro.css">
     <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <title>Add Product</title>
</head>
<body>
    <?php
    if (!empty($_SESSION['flash'])) {
        echo "<p>" . htmlspecialchars($_SESSION['flash']['text']) . "</p>";
        unset($_SESSION['flash']);
    }
    ?>
    <header>
        <div class="logo">
            <a href="admin.php">GlowTrack</a>
        </div>
    </header>
    <h2 class="services">Current Services:</h2>
    <main class="add-service">
        <div class="service-list">
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <?php while ($row = $results->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <form action="../backend/products.php" method="POST">
            <h2>Add New Product</h2>
            <input type="hidden" name="action" value="add">
            <input type="text" name="product_name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Product Description"></textarea>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <button type="submit">Add Product</button>
        </form>
    </main>
</body>
</html>