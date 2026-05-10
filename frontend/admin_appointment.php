<?php
session_start();
include '../backend/connection.php';

$sql = "SELECT b.booking_id, u.username, u.email, s.service_name, s.price,
    b.appointment_date, b.appointment_time, b.phone, b.notes, b.status
    FROM booking b
    JOIN users u ON b.user_id = u.user_id
    JOIN services s ON b.service_id = s.service_id
    ORDER BY b.appointment_date DESC";

$results = $conn->query($sql);
if (!$results) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Booked Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/admin_appoinments.css">
</head>
<body>
    <header>
        <h1 class="logo">GlowTrack</h1>
        <nav class="navs">
            <a href="../frontend/admin_page.php">Dashboard</a>
            <a href="../frontend/admin_appointment.php">Appointments</a>
            <form action="../backend/users_logs.php" method="POST">
                <input type="hidden" name="action" value="logout">
                <button type="submit" name="logout">Log Out</button>
            </form>
        </nav>
    </header>
    <main>
        <section class="Appointments">
            <h2>All Booked Services</h2>
            <div class="container">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Service</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Phone</th>
                        <th>Notes</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['booking_id']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['service_name']) ?></td>
                        <td><?= htmlspecialchars($row['price']) ?></td>
                        <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                        <td><?= htmlspecialchars($row['appointment_time']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['notes']) ?></td>
                        <td><?= htmlspecialchars($row['status'] ?? 'pending') ?></td>
                        <td>
                            <?php if ($row['status'] === ['pending']):?>
                            <form method="post" action="../backend/update_status.php" style="display:inline;">
                                <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit">Accept</button>
                            </form>
                            <form method="post" action="../backend/update_status.php"style="display:inline;">
                                <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit">Reject</button>
                            </form>
                                <?php elseif ($row['status'] === 'accepted'): ?>
                                    <h5 style=color:green>Accepted</h5>
                                <?php elseif ($row['status'] === 'rejected'): ?>
                                    <h5 style=color:red>Rejected</h5>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
