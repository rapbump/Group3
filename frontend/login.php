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
    <section>   
        <div class="box1">
             <div class="log_cont">
                <h3>Log In</h3>
                <p>Use your email or other serivce to continue with us  </p>
                <form action="POST">
                    <input type="hidden" name="action" value="signin">
                    <input type="email" placeholder="Email Address" required>
                    <input type="password" placeholder="Password" required>
                    <button type="submit" class="btn">LOG IN</button>
                    <p>Forgot Password</p>
                </form>
                <div class="return">
                    <a href="./../index.php">Home</a>
                </div>
            </div>
        </div> 
    </section>
</body>
</html>