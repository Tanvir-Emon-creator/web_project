<?php
session_start();
require_once '../../models/Property.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['buyer','renter'])) {
    header("Location: ../auth/login.php");
    exit;
}

$propertyModel = new Property();
$properties = $propertyModel->getAll();

// Filter by user role
$role = $_SESSION['role'];
if ($role === 'buyer') {
    $properties = array_filter($properties, fn($p) => $p['type'] === 'buy');
} else {
    $properties = array_filter($properties, fn($p) => $p['type'] === 'rent');
}

// Optional search
$keyword = $_GET['keyword'] ?? '';
if ($keyword) {
    $properties = array_filter($properties, fn($p) =>
        stripos($p['title'], $keyword) !== false ||
        stripos($p['description'], $keyword) !== false
    );
}
require_once __DIR__ . '/../layouts/header.php';
?>


<!DOCTYPE html>
<html>
<head>
    <title>Browse Properties</title>
</head>
<body>

<h2>Browse Properties</h2>

<form method="GET">
    <input type="text" name="keyword" placeholder="Search..." value="<?= htmlspecialchars($keyword) ?>">
    <select name="type">
        <option value="">All Types</option>
        <option value="buy" <?= $type==='buy' ? 'selected' : '' ?>>Buy</option>
        <option value="rent" <?= $type==='rent' ? 'selected' : '' ?>>Rent</option>
    </select>
    <button type="submit">Search</button>
</form>

<table border="1" cellpadding="5">
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Price</th>
        <th>Type</th>
        <th>Image</th>
        <th>Action</th>
    </tr>
    <?php foreach ($properties as $prop): ?>
    <tr>
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
            <a href="request_property.php?id=<?= $prop['id'] ?>">Request</a>
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