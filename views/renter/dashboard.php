<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'renter') {
    header("Location: ../auth/login.php");
    exit;
}
require_once __DIR__ . '/../layouts/header.php';
?>

<h2>Renter Dashboard</h2>
<p>Welcome, <?= $_SESSION['name'] ?></p>
<p><a href="../profile.php">Edit Profile</a></p>


<ul>
    <li><a href="browse_properties.php">Browse Properties</a></li>
    <li><a href="../contact_admin.php">Contact Admin</a></li>
    <li><a href="my_requests.php">My Requests</a></li>
    <li><a href="../../controllers/AuthController.php?action=logout">Logout</a></li>
</ul>
<?php
// Include footer
require_once __DIR__ . '/../layouts/footer.php';
?>