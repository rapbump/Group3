<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./../style/login.css">
    <title>login</title>
</head>
<body>
    <header>
        <h1>GlowTrack</h1>
        <nav class="navs">
            <div class="log">
                <a href="./login.php">Log In</a>
            </div>
            <div class="sign">
                <a href="./signup.php">Sign Up</a>
            </div>
        </nav>
    </header>
    <main>
        <section>
            <div class="container">
                <div class="form_box" id="login-form">
                    <form action="./../backend/logs.php" method="POST">
                        <h2>Log In</h2>
                        <input type="hidden" name="action" value="login">
                        <input type="text" name="name" placeholder="Username" required>
                        <input type="password" name="pass" placeholder="Password" reqired>
                        <button type="submit" name="login">Login</button>
                        <p>Don't have an account? <a href="../frontend/signup.php">SignUp</a></p>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>