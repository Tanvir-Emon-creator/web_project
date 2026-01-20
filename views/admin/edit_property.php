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

// Get property ID
if (!isset($_GET['id'])) {
    header("Location: properties.php");
    exit;
}

$id = $_GET['id'];
$property = $propertyModel->getById($id);

if (!$property) {
    header("Location: properties.php");
    exit;
}

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

    if ($propertyModel->update($id, $title, $description, $price, $type, $image)) {
        $success = "Property updated successfully!";
        $property = $propertyModel->getById($id); // refresh data
    } else {
        $error = "Failed to update property.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Property</title>
</head>
<body>

<h2>Edit Property</h2>

<?php if ($success): ?>
    <p style="color:green"><?= $success ?></p>
<?php endif; ?>
<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= $property['title'] ?>" required><br><br>
    <textarea name="description" required><?= $property['description'] ?></textarea><br><br>
    <input type="number" name="price" step="0.01" value="<?= $property['price'] ?>" required><br><br>
    <select name="type" required>
        <option value="buy" <?= $property['type'] === 'buy' ? 'selected' : '' ?>>Buy</option>
        <option value="rent" <?= $property['type'] === 'rent' ? 'selected' : '' ?>>Rent</option>
    </select><br><br>
    <?php if ($property['image']): ?>
        <img src="../../resources/<?= $property['image'] ?>" width="100"><br><br>
    <?php endif; ?>
    <input type="file" name="image"><br><br>
    <button type="submit">Update Property</button>
</form>

<p><a href="properties.php">Back to Properties</a></p>

</body>
</html>
