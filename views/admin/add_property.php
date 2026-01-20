<?php
session_start();
require_once '../../models/Property.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$propertyModel = new Property();
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $type = $_POST['type'];

    // Image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../../resources/' . $image);
    }

    if ($propertyModel->create($title, $description, $price, $type, $image)) {
        $success = "Property added successfully!";
    } else {
        $error = "Failed to add property.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Property</title>
</head>
<body>

<h2>Add Property</h2>

<?php if ($success): ?>
    <p style="color:green"><?= $success ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" required placeholder="Property Title"><br><br>
    <textarea name="description" required placeholder="Description"></textarea><br><br>
    <input type="number" name="price" step="0.01" required placeholder="Price"><br><br>
    <select name="type" required>
        <option value="">Select Type</option>
        <option value="buy">Buy</option>
        <option value="rent">Rent</option>
    </select><br><br>
    <input type="file" name="image"><br><br>
    <button type="submit">Add Property</button>
</form>

<p><a href="dashboard.php">Back to Dashboard</a></p>

</body>
</html>
