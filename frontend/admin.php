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

$results = $conn->query("SELECT * FROM service");
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
    <link rel="stylesheet" href="../style/admin.css">
     <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <title>Admin</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="admin.php">GlowTrack</a>
        </div>
        <nav>
            <a href="#users">Manage Dashboard</a>
            <a href="#services">Manage Services</a>
            <a href="#products">Manage Products</a>
            <form action="../backend/logs.php" method="POST">
                <input type="hidden" name="action" value="logout">
                <button type="submit">Log Out</button>
            </form>
        </nav>
    </header>
    <main class="manage-sections">
        <section class="manage-section" id="users">
            <h2>Manage Dashboard</h2>
            <h4>Current Users:</h4>
            <div class="data">
                <h3>Orders</h3>
                <h3>Customers</h3>
                <h3>Revenue</h3>
                <h3>Products</h3>
            </div>
            <div class="numbers">
                <h2 class="ol">30</h2>
                <h2 class="total">15</h2>
                <h2 class="revenue">$$</h2>
                <h2 class="products">$$</h2>
            </div>
            <div class="view">
                <a href="#">View Orders</a>
                <a href="#">View Customers</a>
                <a href="#">View Revenue</a>
                <a href="#">View Products</a>
            </div>
            <div class="bot-container">
                <div class="reviews">
                    <h3>Customer Reviews: </h3>
                    <p>"Amazing service and products! My skin has never felt better."</p>
                    <p>"The staff is so knowledgeable and friendly. Highly recommend!"</p>
                    <p>"I love the natural ingredients in their skincare line. My skin is glowing!"</p>
                    <a href="reviews.php">View All Reviews</a>
                </div>
                <div class="appointments">
                    <h3>Upcoming Appointments: </h3>
                    <p>Jane Doe - Facial - 10/15/2024 2:00 PM</p>
                    <p>John Smith - Acne Treatment - 10/16/2024 11:00 AM</p>
                    <p>Emily Davis - Hydration Therapy - 10/17/2024 1:00 PM</p>
                    <a href="appointments.php">View All Appointments</a>
                </div>
            </div>
        </section>
        <section class="manage-section" id="services">
            <h2>Manage Services</h2>
            <h4>Current Services:</h4>
            <div class="serve">
                <?php while ($row = $results->fetch_assoc()): ?>
                <div class="serves">
                    <h3><?php echo htmlspecialchars($row['service_name']); ?></h3>
                    <p>Description: <?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="add">
                <a href="addSer.php">Add New Service</a>
            </div>
        </section>
        <section class="manage-section" id="products">
            <h2>Manage Products</h2>
            <h4>Current Products: </h4>
            <div class="prod-container">
                <?php while ($row = $prodResults->fetch_assoc()): ?>
                <div class="prods">
                    <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                    <p>Description: <?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                </div>
                <?php endwhile; ?>
                <div>
                    <a href="products.php">View All Products</a>
                </div>
            </div>
            <div class="add">
                <a href="addPro.php">Add New Product</a>
            </div>
        </section>
    </main>
</body>
</html>