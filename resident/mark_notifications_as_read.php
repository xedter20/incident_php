<?php
include '../connection/config.php';
$db = new Database();

session_start();

if (isset($_SESSION['auth_user']['resident_id'])) {
    $residentID = $_SESSION['auth_user']['resident_id'];

    $read = 'Read';
    // Adjust your SQL query to update notifications as read based on your database schema
    $stmt = $db->resident_data_Notification_markASread($read, $residentID);

    // Respond to the AJAX request with a JSON response
    $response = array("success" => true);
    echo json_encode($response);
    exit;
}
?>
