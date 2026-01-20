<?php
session_start();
require_once '../../models/Property.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$propertyModel = new Property();
$properties = $propertyModel->getAll();
require_once __DIR__ . '/../layouts/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Properties</title>
</head>
<body>

<h2>All Properties</h2>
<p><a href="add_property.php">Add New Property</a></p>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Price</th>
        <th>Type</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($properties as $prop): ?>
    <tr>
        <td><?= $prop['id'] ?></td>
        <td><?= $prop['title'] ?></td>
        <td><?= $prop['description'] ?></td>
        <td><?= $prop['price'] ?></td>
        <td><?= $prop['type'] ?></td>
        <td>
            <?php if ($prop['image']): ?>
                <img src="../../resources/<?= $prop['image'] ?>" width="100">
            <?php else: ?>
                No Image
            <?php endif; ?>
        </td>
        <td>
            <a href="edit_property.php?id=<?= $prop['id'] ?>">Edit</a> |
            <a href="../../controllers/PropertyController.php?action=delete&id=<?= $prop['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
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