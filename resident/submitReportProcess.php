<?php

include '../connection/config.php';
$db = new Database();


// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if($_SESSION['auth_user']['resident_id']==0){
    echo"<script>window.location.href='index.php'</script>";
    
}



if (isset($_POST['successPhotoValidation'])) {
    $status = $_POST['successPhotoValidation'];
   
  $residentID = $_SESSION['auth_user']['resident_id'];
  $DESCRIPTION = $_POST['DESCRIPTION'];
   $latitude = $_POST['latitude'];
 $longitude = $_POST['longitude'];
 $analysisHelp = $_POST['analysisHelp'];

   $calamity_incident = $_POST['calamity_incident'];
   echo    $analysisHelp;


   $reason = '';

   if( $status !=  'Approved' ){
    $reason  = 'System detected that photo is not a valid incident.';
  
   }

  // Define the directory where you want to save the images
   $uploadDirectory = '../incident_report_images/'; // Change this to your desired directory

//   // Generate a unique filename for the uploaded image
  $uniqueFilename = uniqid() . '-' . $_FILES['incident_picture']['name'];

//   // Define the full path to the saved image file
 $imagePath = $uploadDirectory . $uniqueFilename;

  if (move_uploaded_file($_FILES['incident_picture']['tmp_name'], $imagePath)) {
 date_default_timezone_set('Asia/Manila');
 $date = date('F / d / Y');
 $time = date('g:i A');
 $month = date('F');
 $logs = 'Your report has been submitted, wait for the admin to confirm your report.';

 // Insert into the system_notification table
 $result1 = $db->resident_data_InsertNotification($residentID, $logs, $date, $time);

 // Insert into the incident_reports table
 $result2 = $db->submit_report_resident_data($residentID, $date, $time, $month, 
 $calamity_incident, $DESCRIPTION, $imagePath,
  $longitude, $latitude , $status , $reason , $analysisHelp);

 if ($result2) {
   $_SESSION['alert'] = "Success";
   $_SESSION['status'] = "Report saved successfully";
   $_SESSION['status-code'] = "success";
 } else {
   $_SESSION['alert'] = "Error";
   $_SESSION['status'] = "Failed to save the report";
   $_SESSION['status-code'] = "error";
   // Handle the error gracefully (e.g., log the error, show a user-friendly message)
 }
  }
}


//UPDATE LOCATION



?>
