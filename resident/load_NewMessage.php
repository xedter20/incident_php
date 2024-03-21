<?php
include '../connection/config.php';
$db = new Database();

session_start();

//display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['receiver_id'])) {
    $senderId = $_SESSION['auth_user']['resident_uniqueID'];
    $receiverId = $_POST['receiver_id'];

    $messages = $db->show_messages($senderId, $receiverId);

    // Construct HTML for all messages
    foreach ($messages as $message) {
        if ($message['sender_id'] == $senderId) {
            ?>
            <div class="chat-message-right pb-4">
                <div>
                    <img src="<?= $message['profile_picture']; ?>" class="rounded-circle mr-1" alt="You" width="40" height="40">
                    <div class="text-muted small text-nowrap mt-2"><?= $message['time_only']; ?></div>
                    <div class="text-muted small text-nowrap mt-2"><?= $message['status']; ?></div>
                </div>
                <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                    <div class="font-weight-bold mb-1">You</div>
                    <?= $message['messages']; ?>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="chat-message-left pb-4">
                <div>
                    <img src="<?= $message['profile_picture']; ?>" class="rounded-circle mr-1" alt="<?= $message['first_name']; ?>" width="40" height="40">
                    <div class="text-muted small text-nowrap mt-2"><?= $message['time_only']; ?></div>
                    <div class="text-muted small text-nowrap mt-2"><?= $message['status']; ?></div>
                </div>
                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                    <div class="font-weight-bold mb-1"><?= $message['first_name']; ?> <?= $message['middle_name']; ?> <?= $message['last_name']; ?></div>
                    <?= $message['messages']; ?>
                </div>
            </div>
            <?php
        }
    }
    $message_status = 'Seen';

    $messages = $db->resident_message_markAS_seen($message_status, $receiverId);
}
?>
