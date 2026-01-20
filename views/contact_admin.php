<?php
session_start();
require_once '../models/Message.php';
require_once '../models/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$messageModel = new Message();
$userModel = new User();

$role = $_SESSION['role'];

// ----------------- ADMIN -----------------
if ($role === 'admin') {
    $selected_user_id = $_GET['user_id'] ?? null;

    // Send reply
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'], $_POST['receiver_id'])) {
        $messageModel->send($_SESSION['user_id'], $_POST['receiver_id'], trim($_POST['message']));
        header("Location: contact_admin.php?user_id=" . $_POST['receiver_id']);
        exit;
    }

    // Get all users except admin
    $users = $userModel->getAllExceptAdmin();

    // Get conversation if user selected
    $conversation = [];
    if ($selected_user_id) {
        $conversation = $messageModel->getConversation($_SESSION['user_id'], $selected_user_id);
    }

// ----------------- BUYER / RENTER -----------------
} else {
    $admin_id = 1; // Admin user ID

    // Send message to admin
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
        $msg = trim($_POST['message']);
        if ($msg !== '') {
            $messageModel->send($_SESSION['user_id'], $admin_id, $msg);
            header("Location: contact_admin.php");
            exit;
        }
    }

    // Get conversation with admin
    $conversation = $messageModel->getConversation($_SESSION['user_id'], $admin_id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Admin</title>
</head>
<body>

<h2>Messages</h2>

<?php if ($role === 'admin'): ?>

    <h3>Users</h3>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <a href="contact_admin.php?user_id=<?= $user['id'] ?>">
                    <?= $user['name'] ?> (<?= ucfirst($user['role']) ?>)
                </a>
            </li>
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
            <textarea name="message" placeholder="Type your reply..." required style="width:100%;height:50px;"></textarea><br>
            <input type="hidden" name="receiver_id" value="<?= $selected_user_id ?>">
            <button type="submit">Send</button>
        </form>
    <?php else: ?>
        <p>Select a user to view conversation.</p>
    <?php endif; ?>

    <p><a href="dashboard.php">Back to Dashboard</a></p>

<?php else: ?>

    <h3>Conversation with Admin</h3>

    <div style="border:1px solid #000; padding:10px; height:300px; overflow:auto;">
        <?php if (!empty($conversation)): ?>
            <?php foreach ($conversation as $msg): ?>
                <p>
                    <strong><?= $msg['sender_name'] ?>:</strong> <?= $msg['message'] ?>
                    <small>(<?= $msg['created_at'] ?>)</small>
                </p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No messages yet. Start the conversation!</p>
        <?php endif; ?>
    </div>

    <form method="POST">
        <textarea name="message" placeholder="Type your message..." required style="width:100%;height:50px;"></textarea><br><br>
        <button type="submit">Send</button>
    </form>

   <p>
<p>
<?php
if ($_SESSION['role'] === 'admin') {
    echo '<a href="/project/views/admin/dashboard.php">Back to Dashboard</a>';
} elseif ($_SESSION['role'] === 'buyer') {
    echo '<a href="/project/views/buyer/dashboard.php">Back to Dashboard</a>';
} elseif ($_SESSION['role'] === 'renter') {
    echo '<a href="/project/views/renter/dashboard.php">Back to Dashboard</a>';
}
?>
</p>



<?php endif; ?>

</body>
</html>
