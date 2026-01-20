<?php
session_start();
require_once '../models/User.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['buyer','renter'])) {
    header("Location: auth/login.php");
    exit;
}

$userModel = new User();
$user = $userModel->findById($_SESSION['user_id']);

$success = "";
$error = "";

// Update profile (name & role)
if (isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $role = $_POST['role'];

    if ($name !== '' && in_array($role, ['buyer','renter'])) {
        $userModel->updateProfile($_SESSION['user_id'], $name, $role);
        $_SESSION['role'] = $role; // update session role
        $success = "Profile updated successfully!";
        $user['name'] = $name;
        $user['role'] = $role;
    } else {
        $error = "Invalid name or role.";
    }
}

// Update password
if (isset($_POST['change_password'])) {
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($new_password !== '' && $new_password === $confirm_password) {
        $userModel->updatePassword($_SESSION['user_id'], $new_password);
        $success = "Password changed successfully!";
    } else {
        $error = "Passwords do not match or empty.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>

<h2>Edit Profile</h2>

<?php if ($success) echo "<p style='color:green'>$success</p>"; ?>
<?php if ($error) echo "<p style='color:red'>$error</p>"; ?>

<h3>Update Name & Role</h3>
<form method="POST">
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br><br>
    <select name="role">
        <option value="buyer" <?= $user['role']==='buyer'?'selected':'' ?>>Buyer</option>
        <option value="renter" <?= $user['role']==='renter'?'selected':'' ?>>Renter</option>
    </select><br><br>
    <button type="submit" name="update_profile">Update Profile</button>
</form>

<h3>Change Password</h3>
<form method="POST">
    <input type="password" name="new_password" placeholder="New Password" required><br><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
    <button type="submit" name="change_password">Change Password</button>
</form>

<p>
    <?php
    // Back to dashboard
    if ($_SESSION['role'] === 'buyer') {
        echo '<a href="buyer/dashboard.php">Back to Dashboard</a>';
    } elseif ($_SESSION['role'] === 'renter') {
        echo '<a href="renter/dashboard.php">Back to Dashboard</a>';
    }
    ?>
</p>

</body>
</html>
