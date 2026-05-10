<?php
session_start();
include "../backend/connection.php";

$result = $conn->query("SELECT user_id, username, email, role FROM users WHERE role = 'user'  ORDER BY  user_id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Customers</title>
    <link rel="stylesheet" href="../style/view_cus.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    
</head>
<body>
    <header>
        <div class="logo">
            <a href="../frontend/admin_page.php">GlowTrack Admin</a>
        </div>
        <nav>
            <a href="../frontend/admin_page.php">Back</a>
        </nav>
    </header>

    <main>
        <section class="customers">
            <h2>All Customers</h2>
            <?php if ($result->num_rows === 0): ?>
                <p>No customers found.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['user_id']) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['role']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>