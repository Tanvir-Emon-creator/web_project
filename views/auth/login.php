<?php
require_once '../../controllers/AuthController.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController();
    $error = $auth->login($_POST['email'], $_POST['password']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <input type="email" name="email" required placeholder="Email"><br><br>
    <input type="password" name="password" required placeholder="Password"><br><br>
    <button type="submit">Login</button>
</form>

</body>
</html>
