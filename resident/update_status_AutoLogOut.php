<?php 
include '../connection/config.php';
$db = new Database();

session_start();

if(isset($_POST['userId'])){

    $residentID = $_POST['userId'];

date_default_timezone_set('Asia/Manila');
$date = date('F / d l / Y');
$time = date('g:i A');
$logs = 'You successfully logged out to your account.';
$online_offline_status = 'Offline';

$sql = $db->resident_data_InsertNotification($residentID, $logs, $date, $time);

$sql2 = $db->UPDATE_resident_data_Online_Offline($online_offline_status, $residentID);

}

session_destroy();

?>