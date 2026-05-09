<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./../style/signup.css">
    <title>SignUp</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../index.php">GlowTrack</a>
        </div>
        <nav class="navs">
            <div class="log">
                <a href="login.php">Log In</a>
            </div>
            <div class="sign">
                <a href="signup.php">Sign Up</a>
            </div>
        </nav>
    </header>
    <section class="entrance">
        <div class="halfL">
            <h2>Glow naturally with GlowTrack</h2>
            <form method="POST" action="../backend/logs.php">
                <input type="hidden" name="action" value="signup">
                <div class="others">
                    <input type="text" name="name" placeholder="Username" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Create Password" required>
                    <select name="role" required>
                        <option value="">Select Role</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="save">
                    <button type="submit" name="signup">Sign Up</button>
                </div>
                    <p>Already have an account? <a href="./login.php">SignIn</a></p>
            </form>
        </div>
        <div class="halfR">
            <img src="./../images/design.png" alt="design">
        </div>
    </section>
</body>
</html>