<?php
include '../connection/config.php';
$db = new Database();
//display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receiver_id'])) {
    $receiverId = $_POST['receiver_id'];
    $status = 'Sent';
    
    $results = $db->count_NewMessages($receiverId, $status);

    $newMessageCount = $results['new_message_count'];

    // Close the PDO connection
    $pdo = null;

    // Return the new message count as a response to the Ajax request
    echo $newMessageCount;

}
?>