<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
require_once __DIR__ . '/../layouts/header.php';
?>

<h2>Admin Dashboard</h2>
<p>Welcome, <?= $_SESSION['name'] ?></p>

<ul>
    <li><a href="add_property.php">Add Property</a></li>
    <li><a href="properties.php">View All Properties</a></li>
    <li><a href="../contact_admin.php">View Messages</a></li>
    <li><a href="requests.php">Property Requests</a></li>
    <li><a href="../../controllers/AuthController.php?action=logout">Logout</a></li>
</ul>
<?php
// Include footer
require_once __DIR__ . '/../layouts/footer.php';
?>