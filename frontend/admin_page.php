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

$results = $conn->query("SELECT * FROM services");
if (!$results) {
    die('Query failed: ' . $conn->error);
}
$prodResults = $conn->query("SELECT * FROM products");
if (!$prodResults) {        
    die('Query failed: ' . $conn->error);
}
$resultBook = $resultBook = $conn->query("
    SELECT b.booking_id, u.username, s.service_name, b.appointment_date, b.appointment_time
    FROM booking b
    JOIN users u ON b.user_id = u.user_id
    JOIN services s ON b.service_id = s.service_id
");
$total = $conn->query("SELECT COUNT(*) AS  total_orders from orders");
$total_row = $total->fetch_assoc();

$total_cus = $conn->query("SELECT COUNT(*) AS  total_customers from users  WHERE role = 'user'");
$total_c = $total_cus->fetch_assoc();

$total_p = $conn->query("SELECT COUNT(*) AS total_pro FROM products");
$total_prod = $total_p->fetch_assoc();

$total_a = $conn->query("SELECT COUNT(*) AS total_app FROM booking");
$total_s = $total_a->fetch_assoc();

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
            <a href="admin_page.php">GlowTrack</a>
        </div>
        <nav>
            <a href="#users">Manage Dashboard</a>
            <a href="#services">Manage Services</a>
            <a href="#products">Manage Products</a>
            <a href="../frontend/admin_appointment.php">Manage Appointments</a>
            <form action="../backend/users_logs.php" method="POST">
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
                <h3>Appointments</h3>
                <h3>Products</h3>
            </div>
            <div class="numbers">
                <h2 class="ol"><?php echo $total_row['total_orders']; ?></h2>
                <h2 class="total"><?php echo $total_c['total_customers']; ?></h2>
                <h2 class="appointment"><?php echo $total_s['total_app'];?></h2>
                <h2 class="products"><?php echo $total_prod['total_pro']; ?></h2>
            </div>
            <div class="view">
                <a href="/frontend/view_orders.php">View Orders</a>
                <a href="/frontend/view_customers.php">View Customers</a>
                <a href="/frontend/admin_appointment.php">View Appointments</a>
                <a href="/frontend/view_product.php">View Products</a>
            </div>
            <div class="bot-container">
                <?php while ($row = $resultBook->fetch_assoc()): ?>
                <?php
                    $date = !empty($row['appointment_date']) 
                        ? date("m/d/Y", strtotime($row['appointment_date'])) 
                        : "No date set";

                    $time = !empty($row['appointment_time']) 
                        ? date("g:i A", strtotime($row['appointment_time'])) 
                        : "No time set";
                ?>
                <div class="appointments">
                    <h2>Appointments: </h2>
                    <h3>
                        <?= htmlspecialchars($row['username']) ?>
                        - <?= htmlspecialchars($row['service_name']) ?>
                        - <?= $date . " " . $time ?>
                    </h3>
                </div>
                <?php endwhile ?>
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
                <a href="admin_addSer.php">Add New Service</a>
            </div>
        </section>
        <section class="manage-section" id="products">
            <h2>Manage Products</h2>
            <h4>Current Products: </h4>
            <div class="prod-container">
                <?php while ($row = $prodResults->fetch_assoc()): ?>
                <div class="prods">
                    <h3><?php echo htmlspecialchars($row['pname']); ?></h3>
                    <p>Description: <?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="add">
                <a href="admin_addPro.php">Add New Product</a>
            </div>
        </section>
    </main>
</body>
</html>