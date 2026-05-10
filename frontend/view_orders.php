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
    SELECT o.order_id, u.username, p.pname AS product_name, o.quantity, o.total_price, o.status, o.order_date
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN products p ON o.product_id = p.product_id
    ORDER BY o.order_date DESC
");
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>All Orders</title>
        <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../style/view_orders.css">
    </head>
    <body>
    <header>
        <div class="logo">
            <a href="../frontend/admin_page.php">GlowTrack Admin</a>
        </div>
        <nav>
            <a href="../frontend/view_customers.php">Customers</a>
            <a href="../frontend/view_orders.php">Orders</a>
        </nav>
    </header>

    <main>
        <section class="orders">
            <h2>All Orders</h2>
            <?php if ($result->num_rows === 0): ?>
                <p>No orders found.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['order_id']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td>₱<?= htmlspecialchars($row['total_price']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= htmlspecialchars($row['order_date']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                </table>
            <?php endif; ?>
        </section>
    </main>
    </body>
</html>