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
    <div class="container">
        <div class="image2">
            <img src="./../images/image2.png" alt="Face">
        </div>
        <div class="form_sec">
            <h3>Book an Appointment</h3>
            <form action="GET">
                <input type="hidden" name="action" value="book">
                <input type="text" name="fname" placeholder="Full Name" required>
                <input type="date" name="date" required>
                <input type="tel" placeholder="Phone Number" required>
                <input type="time" placeholder="00:00 Am" required>
                <input type="email" placeholder="Email" required>
                <select name="services" required>
                    <option value="" disabled <? $services == "" ? "selected" : ""?>>Select Services</option>
                    <option value="Custom Facials" <? $services == "Custom Facials" ? "selected" : ""?>>Custom Facials</option>
                    <option value="Anti-aging treatments" <? $services == "Anti-aging treatments" ? "selected" : ""?>>Anti-aging treatments</option>
                    <option value="Acne Solutions" <? $services == "Acne Solutions" ? "selected" : ""?>>Acne Solutions</option>
                    <option value="Hydration Therapy" <? $services == "Hydration Therapy" ? "selected" : ""?>>Hydration Therapy</option>
                </select>
                <textarea name="comment" placeholder="Write A Message"></textarea>
                <div class="btn">
                    <button type="submit">Submit</button>
                    <a href="./../index.php">Back</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>