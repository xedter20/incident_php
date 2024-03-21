<?php

include '../connection/config.php';
$db = new Database();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../phpmailer/src/PHPMailer.php';
include '../phpmailer/src/SMTP.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_POST['register'])) {

    $first_name = $_POST['f_name'];
    $middle_name = $_POST['m_name'];
    $last_name = $_POST['l_name'];
    $CompleteAddress = $_POST['C_address'];
    $PhoneNumber = $_POST['cpNum'];
    $email = $_POST['eMail'];
    $pword = md5($_POST['pword']);
    $c_pword = md5($_POST['cpword']);
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $verification_code = rand(100000, 999999);

    $uniqueId = uniqid() . mt_rand(1000, 9999);


    // Define the directory where you want to save the images
    $uploadDirectory = '../imageFiles/'; // Change this to your desired directory

    // Generate a unique filename for the updated image
    $uniqueFilename = uniqid() . '-' . $_FILES['admin_pic']['name'];

    // Define the full path to the saved image file
    $imagePath = $uploadDirectory . $uniqueFilename;

    $user = $db->admin_register_select_email($email);

    if ($user) {
        // Email already exists
        $_SESSION['alert'] = "Oppss...";
        $_SESSION['status'] = "Email already exists";
        $_SESSION['status-code'] = "error";
        header("location: ../adminsystem/admin_register.php");
        exit();
    }

    $user = $db->admin_register_select_phoneNumber($PhoneNumber);

    if ($user) {
        // Phone Number already exists
        $_SESSION['alert'] = "Oppss...";
        $_SESSION['status'] = "Phone Number Already Exists!";
        $_SESSION['status-code'] = "error";
        header("location: ../adminsystem/admin_register.php");
        exit();
    }

    if ($pword == $c_pword) {
        // Move the uploaded image to the desired directory
        if (move_uploaded_file($_FILES['admin_pic']['tmp_name'], $imagePath)) {

            $sql = $db->admin_register_INSERT_Info($uniqueId, $first_name, $middle_name, $last_name, $CompleteAddress, $PhoneNumber, $email, $pword, $imagePath, $verification_code, $longitude, $latitude);


            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'orderfood188@gmail.com';
            $mail->Password = 'fduspcpqgisiiasg';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('orderfood188@gmail.com');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Account';
            $mail->Body = 'Your account verification code is <h1> ' . $verification_code . ' </h1>';
            $mail->send();

            $_SESSION['alert'] = "Success";
            $_SESSION['status'] = "Admin Registered";
            $_SESSION['status-code'] = "success";
            header("location: ../adminsystem/index.php");
        } else {
            $_SESSION['alert'] = "Oppss...";
            $_SESSION['status'] = "Failed to move image file.";
            $_SESSION['status-code'] = "error";
            header("location: ../adminsystem/admin_register.php");
        }
    } else {
        $_SESSION['alert'] = "Oppss...";
        $_SESSION['status'] = "PASSWORD NOT MATCH";
        $_SESSION['status-code'] = "error";
        header("location: ../adminsystem/admin_register.php");
    }
}
?>
