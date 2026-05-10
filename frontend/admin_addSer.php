<?php
session_start();
include '../backend/connection.php';

$results = $conn->query("SELECT * FROM services");
if (!$results) {
    die('Query failed: ' . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../style/addSer.css">
     <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <title>Add Service</title>
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
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <?php while ($row = $results->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <form action="../backend/services_handler.php" method="POST">
            <h2>Add New Service</h2>
            <input type="hidden" name="action" value="add">
            <input type="text" name="service_name" placeholder="Service Name" required>
            <textarea name="description" placeholder="Service Description"></textarea>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <button type="submit">Add Service</button>
        </form>
    </main>
</body>
</html>