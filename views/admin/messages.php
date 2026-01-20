<?php
session_start();
require_once '../../models/Message.php';
require_once '../../models/User.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$messageModel = new Message();
$userModel = new User();

// Select user to chat with
$selected_user_id = $_GET['user_id'] ?? null;

// Send reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'], $_POST['receiver_id'])) {
    $messageModel->send($_SESSION['user_id'], $_POST['receiver_id'], $_POST['message']);
    header("Location: messages.php?user_id=" . $_POST['receiver_id']);
    exit;
}

// Get all users except admin
$users = $userModel->getAllExceptAdmin();

// Get conversation if user selected
$conversation = [];
if ($selected_user_id) {
    $conversation = $messageModel->getConversation($_SESSION['user_id'], $selected_user_id);
}
require_once __DIR__ . '/../layouts/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Messages</title>
</head>
<body>
<h2>Admin Messages</h2>

<h3>Users</h3>
<ul>
    <?php foreach ($users as $user): ?>
        <li><a href="messages.php?user_id=<?= $user['id'] ?>"><?= $user['name'] ?> (<?= ucfirst($user['role']) ?>)</a></li>
    <?php endforeach; ?>
</ul>

<?php if ($selected_user_id): ?>
    <h3>Conversation with <?= $userModel->findById($selected_user_id)['name'] ?></h3>

    <div style="border:1px solid #000; padding:10px; height:300px; overflow:auto;">
        <?php foreach ($conversation as $msg): ?>
            <p>
                <strong><?= $msg['sender_name'] ?>:</strong> <?= $msg['message'] ?>
                <small>(<?= $msg['created_at'] ?>)</small>
            </p>
        <?php endforeach; ?>
    </div>

    <form method="POST">
        <textarea name="message" required placeholder="Type your reply..." style="width:100%;height:50px;"></textarea><br>
        <input type="hidden" name="receiver_id" value="<?= $selected_user_id ?>">
        <button type="submit">Send</button>
    </form>
<?php else: ?>
    <p>Select a user to view conversation.</p>
<?php endif; ?>

<p><a href="dashboard.php">Back to Dashboard</a></p>

</body>
</html>
<?php
// Include footer
require_once __DIR__ . '/../layouts/footer.php';
?>