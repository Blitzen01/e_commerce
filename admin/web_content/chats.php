<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";

    session_start();
    $_SESSION['role'] = 'admin';
    if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
        header("Location: ../index.php");
        exit;
    }

    // Fetch all users
    $users = $conn->query("SELECT * FROM users WHERE role = 'user'");

    // Fetch messages with a specific user
    $selectedUserId = $_GET['user_id'] ?? null;
    $messages = [];
    if ($selectedUserId) {
        $messagesQuery = $conn->prepare("
            SELECT * FROM messages
            WHERE (sender_id = ? AND receiver_id = ?) 
               OR (sender_id = ? AND receiver_id = ?)
            ORDER BY created_at ASC
        ");
        $adminId = $_SESSION['id'];
        $messagesQuery->bind_param("iiii", $adminId, $selectedUserId, $selectedUserId, $adminId);
        $messagesQuery->execute();
        $messages = $messagesQuery->get_result();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: Inbox</title>

        <link rel="stylesheet" href="../../assets/style/admin_style.css">
        <link rel="icon" href="/e_commerce/assets/image/hfa_logo.png" type="image/png">
    </head>
    <body>
        <div id="admin-body">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <h3 class="p-3 text-center"><i class="fa-regular fa-comments"></i> Inbox</h3>
                    <div class="user-list">
                        <h5>Users</h5>
                        <ul>
                            <?php while ($user = $users->fetch_assoc()): ?>
                                <li>
                                    <a href="?user_id=<?= $user['id'] ?>">
                                        <?= $user['name'] ?> (<?= $user['email'] ?>)
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <?php if ($selectedUserId): ?>
                        <div class="chat-box">
                            <h5>Chat with User #<?= $selectedUserId ?></h5>
                            <div class="messages">
                                <?php while ($message = $messages->fetch_assoc()): ?>
                                    <div class="<?= $message['sender_id'] == $_SESSION['id'] ? 'sent' : 'received' ?>">
                                        <?= htmlspecialchars($message['message']) ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                            <form method="post" action="send_message.php">
                                <input type="hidden" name="receiver_id" value="<?= $selectedUserId ?>">
                                <textarea name="message" required></textarea>
                                <button type="submit">Send</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
