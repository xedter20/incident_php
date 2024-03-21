<?php
include '../connection/config.php';
$db = new Database();
session_start();

//display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_POST['fetchAllIncidentReportLive'])) {
    // Insert the new message into the database (you'll need to modify this part)
    
    $data = $db->SELECT_ALL_INCIDENT_REPORT('Approved');
    echo json_encode($data);


}

?>
