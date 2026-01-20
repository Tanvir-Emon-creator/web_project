<?php
session_start();
require_once '../../models/Message.php';
require_once '../../models/User.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'buyer') {
    header("Location: ../auth/login.php");
    exit;
}

$messageModel = new Message();
$userModel = new User();

// Send message to Admin (ID = 1)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $messageModel->send($_SESSION['user_id'], 1, trim($_POST['message']));
    header("Location: messages.php");
    exit;
}

// Get conversation with Admin
$conversation = $messageModel->getConversation($_SESSION['user_id'], 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Messages with Admin</title>
</head>
<body>

<h2>Conversation with Admin</h2>

<div style="border:1px solid #000; padding:10px; height:300px; overflow:auto;">
    <?php foreach ($conversation as $msg): ?>
        <p>
            <strong><?= $msg['sender_name'] ?>:</strong> <?= $msg['message'] ?>
            <small>(<?= $msg['created_at'] ?>)</small>
        </p>
    <?php endforeach; ?>
</div>

<form method="POST">
    <textarea name="message" placeholder="Type your message..." required style="width:100%;height:50px;"></textarea><br>
    <button type="submit">Send</button>
</form>

<p><a href="dashboard.php">Back to Dashboard</a></p>

</body>
</html>
