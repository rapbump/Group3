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

$results = $conn->query("SELECT service_id, service_name FROM service");
if (!$results) {
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
    <link rel="stylesheet" href="/style/booking.css">
    <title>Booking</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../index.php">GlowTrack</a>
        </div>
    </header>
    <div class="container">
        <div class="image2">
            <img src="./../images/image2.png" alt="Face">
        </div>
        <div class="form_sec">
            <h3>Book an Appointment</h3>
            <form action="../backend/books.php" method="POST">
                <input type="hidden" name="action" value="book">
                <input type="text" name="fname" placeholder="Full Name" required>
                <input type="date" name="date" required>
                <input type="tel" name="phone" placeholder="Phone Number" required>
                <input type="time" name="time" placeholder="00:00 Am" required>
                <input type="email" name="email" placeholder="Email" required>
                <div class="form-row">
                    <label for="services">Choose Services</label>
                    <select name="services" required>
                        <?php while ($row = $results->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($row['service_id']); ?>">
                                <?php echo htmlspecialchars($row['service_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <textarea name="comment" placeholder="Write A Message"></textarea>
                <div class="btn">
                    <button type="submit">Submit</button>
                    <a href="glowtrack.php">Back</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>