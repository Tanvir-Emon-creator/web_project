<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'buyer') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<h2>Buyer Dashboard</h2>
<p>Welcome, <?= $_SESSION['name'] ?></p>
<p><a href="../profile.php">Edit Profile</a></p>


<ul>
    <li><a href="browse_properties.php">Browse Properties</a></li>
    <li><a href="../contact_admin.php">Contact Admin</a></li>
    <li><a href="my_requests.php">My Requests</a></li>
    <li><a href="../../controllers/AuthController.php?action=logout">Logout</a></li>
</ul>
