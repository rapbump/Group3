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
    <section class="entrance">
        <div class="halfL">
            <h2>Glow naturally with GlowTrack</h2>
            <form action="POST">
                <input type="hidden" name="action" value="signup">
                <div class="FLName">
                    <input type="text" placeholder="First Name" required>
                    <input type="text" placeholder="Last Name" required>
                </div>
                <div class="others">
                    <input type="email" placeholder="Email" required>
                    <input type="password" placeholder="Create Password" required>
                    <input type="password" placeholder="Confirm Password" required>
                </div>
                <div class="save">
                    <button type="submit">Sign Up</button>
                    <a href="./../index.php">Cancel</a>
                </div>
            </form>
        </div>
        <div class="halfR">
            <img src="./../images/design.png" alt="design">
        </div>
    </section>
</body>
</html>