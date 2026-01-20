<?php
session_start();
$role = $_SESSION['role'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Property Buy & Rent Management</title>
</head>
<body>
<h1>Welcome to Property Buy & Rent Management</h1>

<?php if (!$role): ?>
    <p><a href="views/auth/login.php">Login</a></p>
    <p><a href="views/auth/register.php">Register (Buyer/Renter)</a></p>
<?php else: ?>
    <p>Hello, <?= $_SESSION['name'] ?> (<?= ucfirst($role) ?>)</p>

    <?php if ($role === 'admin'): ?>
        <ul>
            <li><a href="views/admin/dashboard.php">Admin Dashboard</a></li>
            <li><a href="views/admin/add_property.php">Add Property</a></li>
            <li><a href="views/admin/properties.php">View All Properties</a></li>
            <li><a href="views/admin/requests.php">Property Requests</a></li>
            <li><a href="views/admin/messages.php">User Messages</a></li>
        </ul>
    <?php elseif ($role === 'buyer'): ?>
        <ul>
            <li><a href="views/buyer/dashboard.php">Buyer Dashboard</a></li>
            <li><a href="views/buyer/browse_properties.php">Browse Properties</a></li>
            <li><a href="views/buyer/my_requests.php">My Requests</a></li>
            <li><a href="views/contact_admin.php">Contact Admin</a></li>
        </ul>
    <?php elseif ($role === 'renter'): ?>
        <ul>
            <li><a href="views/renter/dashboard.php">Renter Dashboard</a></li>
            <li><a href="views/renter/browse_properties.php">Browse Properties</a></li>
            <li><a href="views/renter/my_requests.php">My Requests</a></li>
            <li><a href="views/contact_admin.php">Contact Admin</a></li>
        </ul>
    <?php endif; ?>

    <p><a href="controllers/AuthController.php?action=logout">Logout</a></p>
<?php endif; ?>

</body>
</html>
