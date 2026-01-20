 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Property Buy & Rent Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- HEADER -->
<header class="navbar">
    <div class="logo">🏠 PropertyHub</div>
    <div class="nav-links">
        <a href="views/auth/login.php">Login</a>
        <a href="views/auth/register.php" class="btn">Register</a>
    </div>
</header>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-text">
        <h1>Find Your Perfect Property</h1>
        <p>
            Buy or rent properties easily with our secure and user-friendly
            property management system.
        </p>
        <a href="views/auth/login.php" class="btn-large">Get Started</a>
    </div>

    <div class="slider">
        <div class="slides">
            <img src="assets/images/house1.jpg">
            <img src="assets/images/house2.jpg">
            <img src="assets/images/house3.jpg">
        </div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section class="about">
    <h2>About This Project</h2>
    <p>
        This Property Buy & Rent Management System allows admins to manage properties,
        buyers and renters to browse listings, contact admins, send requests, and
        communicate securely.
    </p>
</section>

<!-- FOOTER -->
<footer>
    <p>© <?= date("Y") ?> PropertyHub | Web Technologies Project</p>
</footer>

</body>
</html>
