<?php
session_start();
include '../backend/connection.php';

if (!isset($_SESSION['user']['id'])) {
    die("You must be logged in to view your orders.");
}
$customer_id = (int)$_SESSION['user']['id'];

$stmt = $conn->prepare("
    SELECT o.order_id, p.pname AS product_name, o.quantity, o.total_price, o.status, o.order_date
    FROM orders o
    JOIN products p ON o.product_id = p.product_id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$results = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <title>My Orders</title>
  <link rel="stylesheet" href="../style/pay.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../frontend/users_page.php">GlowTrack</a>
        </div>
        <nav class="cart">
        <a href="../frontend/user_cart.php">Cart</a>
        </nav>
    </header>

    <main>
        <section class="orders">
            <h2>My Orders</h2>
            <?php if ($results->num_rows === 0): ?>
                <p>No orders yet.</p>
            <?php else: ?>
                <?php while ($row = $results->fetch_assoc()): ?>
                    <div class="order-card">
                        <h3><?= htmlspecialchars($row['product_name']) ?></h3>
                        <p>Quantity: <?= htmlspecialchars($row['quantity']) ?></p>
                        <p>Total: ₱<?= htmlspecialchars($row['total_price']) ?></p>
                        <p>Status: <?= htmlspecialchars($row['status']) ?></p>
                        <p>Date: <?= htmlspecialchars($row['order_date']) ?></p>
                        <form action="../backend/update_status.php" method="POST">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                            <button type="submit">Received</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </section>
  </main>
</body>
</html>
