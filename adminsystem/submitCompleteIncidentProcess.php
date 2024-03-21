<?php

include '../connection/config.php';

$db = new Database();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if($_SESSION['auth_user']['admin_id']==0){
    echo"<script>window.location.href='index.php'</script>";
    
}


if (isset($_POST['Complete_Report'])) {
     $adminID = $_SESSION['auth_user']['admin_id'];


    $reportID = $_POST['report_id'];
    $remarks = $_POST['remarks'];

    echo     $remarks;
 
   $status = 'Completed';

    $sql = $db->UPDATE_INCIDENT_REPORT($status, $reportID ,$remarks);

    date_default_timezone_set('Asia/Manila');
    $date = date('F / d l / Y');
    $time = date('g:i A');
    $logs = 'Completed.';

    $sql2 = $db->adminsystem_INSERT_NOTIFICATION_3($adminID, $logs, $date, $time);

      $_SESSION['alert'] = "Success";
      $_SESSION['status'] = "Incident Report Completed";
      $_SESSION['status-code'] = "success";
  
}

if (isset($_POST['Approved_Report'])) {
    $adminID = $_SESSION['auth_user']['admin_id'];

    $reportID = $_POST['report_id'];

    $status = 'Approved';

    $sql = $db->UPDATE_INCIDENT_REPORT($status, $reportID);

    date_default_timezone_set('Asia/Manila');
    $date = date('F / d l / Y');
    $time = date('g:i A');
    $logs = 'You approve an incident report in your area.';

    $sql2 = $db->adminsystem_INSERT_NOTIFICATION_3($adminID, $logs, $date, $time);

      $_SESSION['alert'] = "Success";
      $_SESSION['status'] = "Incident Report Approved";
      $_SESSION['status-code'] = "success";
  
}




if (isset($_POST['Reject_Report'])) {
    $adminID = $_SESSION['auth_user']['admin_id'];

    $reportID = $_POST['report_id'];

    $status = 'Rejected';

    $sql = $db->UPDATE_INCIDENT_REPORT($status, $reportID);

    date_default_timezone_set('Asia/Manila');
    $date = date('F / d l / Y');
    $time = date('g:i A');
    $logs = 'You Rejected an incident report in your area.';

    $sql2 = $db->adminsystem_INSERT_NOTIFICATION_3($adminID, $logs, $date, $time);

      $_SESSION['alert'] = "Success";
      $_SESSION['status'] = "Incident Report Rejected";
      $_SESSION['status-code'] = "success";
  
}



?>


