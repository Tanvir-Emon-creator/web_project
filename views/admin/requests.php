<?php
session_start();
require_once '../../models/PropertyRequest.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$requestModel = new PropertyRequest();

// Approve/Reject action
if (isset($_GET['action'], $_GET['id'])) {
    $status = $_GET['action'] === 'approve' ? 'approved' : 'rejected';
    $requestModel->updateStatus($_GET['id'], $status);
    header("Location: requests.php");
    exit;
}

$requests = $requestModel->getAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Property Requests</title>
</head>
<body>

<h2>Property Requests</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>User Name</th>
        <th>User Email</th>
        <th>Property</th>
        <th>Type</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach ($requests as $req): ?>
    <tr>
        <td><?= $req['id'] ?></td>
        <td><?= $req['user_name'] ?></td>
        <td><?= $req['user_email'] ?></td>
        <td><?= $req['property_title'] ?></td>
        <td><?= $req['property_type'] ?></td>
        <td><?= ucfirst($req['status']) ?></td>
        <td>
            <?php if ($req['status'] === 'pending'): ?>
                <a href="?action=approve&id=<?= $req['id'] ?>">Approve</a> |
                <a href="?action=reject&id=<?= $req['id'] ?>">Reject</a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="dashboard.php">Back to Dashboard</a></p>

</body>
</html>
