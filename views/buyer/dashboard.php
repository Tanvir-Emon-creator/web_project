<?php
// NO session_start here (already in header)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'buyer') {
    header("Location: ../auth/login.php");
    exit;
}

require_once __DIR__ . '/../layouts/header.php';
?>

<div class="card">
    <h2>Buyer Dashboard</h2>
    <p>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></p>

    <ul>
        <li><a href="../profile.php">Edit Profile</a></li>
        <li><a href="browse_properties.php">Browse Properties</a></li>
        <li><a href="../contact_admin.php">Contact Admin</a></li>
        <li><a href="my_requests.php">My Requests</a></li>
    </ul>
</div>

<?php
// Include footer
require_once __DIR__ . '/../layouts/footer.php';
?>
