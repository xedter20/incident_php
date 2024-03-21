<?php
include '../connection/config.php';
$db = new Database();
session_start();

//display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_POST['message']) && isset($_POST['receiver_id'])) {
    // Insert the new message into the database (you'll need to modify this part)
    $senderId = $_SESSION['auth_user']['admin_uniqueID'];
    $receiverId = $_POST['receiver_id'];
    $message = $_POST['message'];

    date_default_timezone_set('Asia/Manila');
    $date = date('F d, Y'); 
    $time = date('g:i A');
    
    // Insert the message into the database (you'll need to modify this part)
    $stmt = $db->adminSEND_message_toUSERchat($senderId, $receiverId, $message, $date, $time);


}

?>
