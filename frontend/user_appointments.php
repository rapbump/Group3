<?php
session_start();
include '../backend/connection.php';

$user_id = (int)$_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT b.booking_id, s.service_name, s.price,
           b.appointment_date, b.appointment_time, b.phone, b.notes, b.status
    FROM booking b
    JOIN services s ON b.service_id = s.service_id
    WHERE b.user_id = ?
    ORDER BY b.appointment_date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$results = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/user_appointments.css">
    <title>My Appointments</title>
</head>
<body>
    <?php
    if (!empty($_SESSION['flash'])) {
        echo "<p>" . htmlspecialchars($_SESSION['flash']['text']) . "</p>";
        unset($_SESSION['flash']);
    }
    ?>
    <header>
        <h1 class="logo">GlowTrack</h1>
        <nav class="navs">
            <a href="../frontend/user_order.php">Order</a>
            <a href="../frontend/user_cart.php">Cart</a>
            <a href="../frontend/user_appointments.php">Appointments</a>
            <form action="../backend/users_logs.php" method="POST">
                <input type="hidden" name="action" value="logout">
                <button type="submit" name="logout">Log Out</button>
            </form>
        </nav>
    </header>
    <main>
        <section class="Appointments">
            <h2>My Appointments</h2>
            <div class="container">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Service</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Phone</th>
                        <th>Notes</th>
                        <th>Status</th>
                    </tr>
                    <?php if ($results->num_rows === 0): ?>
                        <tr><td colspan="8">You have no appointments yet.</td></tr>
                    <?php else: ?>
                        <?php while ($row = $results->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['booking_id']) ?></td>
                            <td><?= htmlspecialchars($row['service_name']) ?></td>
                            <td><?= htmlspecialchars($row['price']) ?></td>
                            <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                            <td><?= htmlspecialchars($row['appointment_time']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['notes']) ?></td>
                            <td>
                                <?php
                                    if ($row['status'] === 'accepted') {
                                        echo "<span style='color:green;'>Accepted</span>";
                                    } elseif ($row['status'] === 'rejected') {
                                        echo "<span style='color:red;'>Rejected</span>";
                                    } else {
                                        echo "<span style='color:orange;'>Pending</span>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
