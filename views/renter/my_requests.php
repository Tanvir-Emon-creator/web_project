<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['buyer','renter'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT pr.id, p.title AS property_title, p.type AS property_type, pr.status, pr.created_at
    FROM property_requests pr
    JOIN properties p ON pr.property_id = p.id
    WHERE pr.user_id = :uid
    ORDER BY pr.created_at DESC
");
$stmt->execute([':uid'=>$user_id]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
require_once __DIR__ . '/../layouts/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Property Requests</title>
</head>
<body>

<h2>My Requests</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Property</th>
        <th>Type</th>
        <th>Status</th>
        <th>Requested At</th>
    </tr>
    <?php foreach ($requests as $req): ?>
    <tr>
        <td><?= $req['id'] ?></td>
        <td><?= $req['property_title'] ?></td>
        <td><?= $req['property_type'] ?></td>
        <td><?= ucfirst($req['status']) ?></td>
        <td><?= $req['created_at'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="dashboard.php">Back to Dashboard</a></p>

</body>
</html>
<?php
// Include footer
require_once __DIR__ . '/../layouts/footer.php';
?>
