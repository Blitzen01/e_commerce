<?php
include '../../render/connection.php';

if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']); // Escape input

    // Fetch user details
    $user_sql = "SELECT full_name, profile_picture FROM user_account WHERE id = '$user_id'";
    $user_result = mysqli_query($conn, $user_sql);

    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user = mysqli_fetch_assoc($user_result);

        // Fetch messages
        $messages_sql = "SELECT * FROM messages WHERE sender_id = '$user_id' OR receiver_id = '$user_id' ORDER BY timestamp ASC";
        $messages_result = mysqli_query($conn, $messages_sql);

        $messages_html = '';
        while ($message = mysqli_fetch_assoc($messages_result)) {
            if ($message['is_admin'] == 0) {
                $messages_html .= '<div id="user_chat"><p>' . htmlspecialchars($message['message']) . '</p></div>';
            } else {
                $messages_html .= '<div id="admin_chat"><p>' . htmlspecialchars($message['message']) . '</p></div>';
            }
        }

        echo json_encode([
            'full_name' => $user['full_name'],
            'profile_picture' => $user['profile_picture'],
            'messages' => $messages_html,
        ]);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
