<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/landing.css">
    <title>GlowTrack</title>
</head>
<body>
    <?php
    if (!empty($_SESSION['flash'])) {
        echo "<p>" . htmlspecialchars($_SESSION['flash']['text']) . "</p>";
        unset($_SESSION['flash']);
    }
    ?>
    <header>
        <div class="logo">
            <a href="index.php">GlowTrack</a>
        </div>
        <nav class="navs">
            <a href="#Home">Home</a>
            <a href="#About">About</a>
            <a href="#services">Services</a>
            <div class="log">
                <a href="./frontend/login.php">Log In</a>
            </div>
            <div class="sign">
                <a href="./frontend/signup.php">Sign Up</a>
            </div>
        </nav>
    </header>
    <main>
        <section id="Home">
            <div class="text">
                <h1>REVEL IN YOUR MOST NATURAL GLOW</h1>
                <p>Luxury, Science-led Natural Skincare made from high quality plant extracts.</p>
                <div class="book">
                    <form action="./backend/booking_handler.php" method="POST">
                        <input type="hidden" name="action" value="book">
                        <button type="submit" >Book an appointment</button>
                    </form>
                </div>
            </div>
            <div class="image">
                <img src="./images/cosmeticsakara-skincare-9126914_1920-removebg-preview.png" alt="Cosmetics">
            </div>
        </section>
        <section id="About">
            <div class="spark">
                <img src="./images/image1.png" alt="">
            </div>
            <h3>The ultimate guide to radiant beauty</h3>
            <p>At Glowtrack, we believe that healthy skin starts with pure, effective ingredients. Our journey began with a simple mission</p>
            <div class="Learn">
                <a href="">Learn More ></a>
            </div>
            <div class="boxes">
                <div class="box1">
                    <h2>Clean Ingredients</h2>
                    <p>We prioritize high-quality, natural ingredients that are safe and effective for your skin.</p>
                </div>
                <div class="box2">
                    <h2>Sustainable Beauty</h2>
                    <p>Our eco-conscious approach ensures that our products are kind to the environment and your skin.</p>
                </div>
                <div class="box3">
                    <h2>Dermatologist-Approved</h2>
                    <p>Each formula is rigorously tested for purity and efficacy, so you can trust what goes on your skin.</p>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer" id="services">
        <div class="footer-container">
            <h4>Services</h4>
            <ul class="footer-services">
                <li>Custom Facials</li>
                <li>Anti-aging Treatments</li>
                <li>Acne Solutions</li>
                <li>Hydration Therapy</li>
            </ul>
            <p class="footer-copy">&copy; 2026 GlowTrack. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>