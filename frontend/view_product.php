<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "glowtrack_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


$result = $conn->query("
    SELECT product_id, pname, price, stocks
    FROM products 
    ORDER BY product_id ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/view_product.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../frontend/admin_page.php">GlowTrack Admin</a>
        </div>
        <nav>
            <a href="../frontend/view_customers.php">Customers</a>
            <a href="../frontend/view_orders.php">Orders</a>
            <a href="../frontend/admin_page.php">Back</a>
            </nav>
    </header>

    <main>
        <section class="products">
            <h2>All Products</h2>
            <?php if ($result->num_rows === 0): ?>
                <p>No products found.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['product_id']) ?></td>
                            <td><?= htmlspecialchars($row['pname']) ?></td>
                            <td>₱<?= htmlspecialchars($row['price']) ?></td>
                            <td><?= htmlspecialchars($row['stocks']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
             <?php endif; ?>
    </section>
  </main>
</body>
</html>
