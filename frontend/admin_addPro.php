<?php
session_start();
include '../backend/connection.php';

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
            <a href="admin_page.php">GlowTrack</a>
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
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['pname']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td>₱<?= htmlspecialchars($row['price']) ?></td>
                        <td><?= htmlspecialchars($row['stocks']) ?></td>
                        <td>
                            <form action="admin_edit_product.php" method="GET" class="inline-form">
                                <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                <button type="submit">Edit</button>
                            </form>
                            <form action="../backend/admin_products_handler.php" method="POST" class="inline-form">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                <button type="submit" class="delete" onclick="return confirm('Are you sure you want to delete this product?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <form action="../backend/admin_products_handler.php" method="POST">
            <h2>Add New Product</h2>
            <input type="hidden" name="action" value="add">
            <input type="text" name="product_name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Product Description"></textarea>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <input type="number" name="stocks" placeholder="Stock/s" required>
            <button type="submit">Add Product</button>
        </form>
    </main>
</body>
</html>