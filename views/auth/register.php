<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<?php
if (isset($_SESSION['error'])) {
    echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo "<p style='color:green'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
}
?>

<form method="POST" action="../../controllers/AuthController.php">
    <input type="text" name="name" required placeholder="Full Name"><br><br>
    <input type="email" name="email" required placeholder="Email"><br><br>
    <input type="password" name="password" required placeholder="Password"><br><br>
    <select name="role" required>
        <option value="">Select Role</option>
        <option value="buyer">Buyer</option>
        <option value="renter">Renter</option>
    </select><br><br>
    <button type="submit" name="register">Register</button>
</form>

<p>Already have an account? <a href="login.php">Login here</a></p>

</body>
</html>
