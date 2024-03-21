<?php

include '../connection/config.php';
$db = new Database();

error_reporting(0);

session_start();

if(ISSET($_POST['verifyNow'])){
		
    $otp_num = $_POST['verification_number'];
    $residentID = $_POST['residentid'];
    $verified = 'Verified';

    $user = $db->resident_data($residentID);

if($user["verification_code"]==$otp_num)
{
$stmt = $db->UPDATEresident_data_verify_status($verified, $residentID);

$_SESSION['alert'] = "Success!";
$_SESSION['status'] = "Student Account Verified. Log In Again.";
$_SESSION['status-code'] = "success"; 
header("location: ../resident/index.php");
}


else {
    $_SESSION['alert'] = "Error!";
    $_SESSION['status'] = "Wrong Verification Number";
    $_SESSION['status-code'] = "error"; 
    header("location: ../resident/resident_verify_account.php?id=$residentID");
}




}

?>