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

if (isset($_POST['upload'])) {
  $residentID = $_SESSION['auth_user']['resident_id'];

  // Define the directory where you want to save the images
  $uploadDirectory = '../imageFiles/'; // Change this to your desired directory

  // Generate a unique filename for the updated image
  $uniqueFilename = uniqid() . '-' . $_FILES['img_resident']['name'];

  // Define the full path to the saved image file
  $imagePath = $uploadDirectory . $uniqueFilename;

  // Retrieve the current image path from the database
  $row = $db->resident_data($residentID);
  $currentImagePath = $row['profile_picture'];


  // Delete the current image from the file system
  if (file_exists($currentImagePath)) {
      unlink($currentImagePath);
  }

  // Move the updated image to the specified directory
  if (move_uploaded_file($_FILES['img_resident']['tmp_name'], $imagePath)) {
      // Image has been successfully updated in the file system

      // Update the database with the new image path
      $sql = $db->UPDATE_resident_data_Profile($imagePath, $residentID);

      if ($sql) {

        date_default_timezone_set('Asia/Manila');
        $date = date('F / d l / Y');
        $time = date('g:i A');
        $logs = 'Profile picture updated successfully.';

        $sql2 = $db->resident_data_InsertNotification($residentID, $logs, $date, $time);

          $_SESSION['alert'] = "Success...";
          $_SESSION['status'] = "Image Updated";
          $_SESSION['status-code'] = "success";
      } else {
          $_SESSION['alert'] = "Failed!";
          $_SESSION['status'] = "Database update failed";
          $_SESSION['status-code'] = "error";
      }
  } else {
      $_SESSION['status'] = "Failed to move the uploaded image";
      $_SESSION['status-code'] = "error";
  }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Focus Admin Dashboard</title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">   

    <!-- Common -->
    <link href="css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="css/lib/themify-icons.css" rel="stylesheet">
    <link href="css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="css/lib/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/lib/sweetalert/sweetalert.css" rel="stylesheet">
</head>

<body>
<!---------NAVIGATION BAR-------->
<?php
require_once 'templates/resident_navbar.php';
?>
<!---------NAVIGATION BAR ENDS-------->



  <div class="content-wrap">
    <div class="main">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
              <div class="page-title">
                <h1>Student Profile
                </h1>
              </div>
            </div>
          </div>
          <!-- /# column -->
          <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
              <div class="page-title">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="dashboard.php">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">App-Profile</li>
                </ol>
              </div>
            </div>
          </div>
          <!-- /# column -->
        </div>
        <!-- /# row -->
        <section id="main-content">
          <!-- Begin Page Content -->
          <div class="container-fluid">

<!-- Page Heading -->

<div class="container bootstrap snippets bootdey">


<div class="panel-body inf-content">
<div class="row">
  <?php
if(isset($_SESSION['auth_user']['resident_id'])){

  $residentID = $_SESSION['auth_user']['resident_id'];

  $data = $db->resident_data($residentID);
    
}
?>

<div class="col-md-4">
<form action="" method="POST" enctype="multipart/form-data">
<img alt="" id="myImage" style="width:600px;" title="" class="img-circle img-thumbnail isTooltip" src="<?php echo $data['profile_picture']; ?>" data-original-title="Usuario">
<br><br>



<label>Update/Upload Image</label>

<input type="file" name="img_resident" onchange="previewImage(event)" required accept="image/*"><br><br>

<button name="upload" class="btn btn-primary">Upload</button>


</form>

</div>
<div class="col-md-6">
<strong>Information</strong><br>
<div class="table-responsive">
<table class="table table-user-information">
<tbody>

<tr>    
    <td>
        <strong>
            <span class="ti-user"></span>    
            Full Name                                                
        </strong>
    </td>
    <td class="text-primary">
    <?php echo $data['first_name']; ?> <?php echo $data['middle_name']; ?> <?php echo $data['last_name']; ?>  
    </td>
</tr>

<tr>        
    <td>
        <strong>
            <span class="ti-home"></span> 
            Complete Address                                                
        </strong>
    </td>
    <td class="text-primary">
    <?php echo $data['complete_address']; ?>
    </td>
</tr>

<tr>        
    <td>
        <strong>
            <span class="ti-mobile"></span> 
            Phone Number                                                
        </strong>
    </td>
    <td class="text-primary">
    <?php echo $data['phone_number']; ?>
    </td>
</tr>


<tr>        
    <td>
        <strong>
            <span class="ti-email"></span> 
            Email Address                                                
        </strong>
    </td>
    <td class="text-primary">
    <?php echo $data['resident_email']; ?>
    </td>
</tr>

                                    
</tbody>
</table>
</div>
</div>
</div>
</div>



</div>                                        

</div>
<!-- /.container-fluid -->
          <!-- /# row -->
          
          <div class="row">
            <div class="col-lg-12">
              <div class="footer">
                <p>
              
                </p>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>



<!----------------UPLOAD OR UPDATE AN IMAGE AND DISPLAYS THE SELECTED IMAGE FIRST BEFORE UPDATING OR UPLOADING--------------->
<script>
    function previewImage(event) {
  var reader = new FileReader();
  reader.onload = function () {
    var output = document.getElementById('myImage');
    output.src = reader.result;
  }
  reader.readAsDataURL(event.target.files[0]);
}
</script>



    <!-- Common -->
    <script src="js/lib/jquery.min.js"></script>
    <script src="js/lib/jquery.nanoscroller.min.js"></script>
    <script src="js/lib/menubar/sidebar.js"></script>
    <script src="js/lib/preloader/pace.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>

    <script src="js/lib/sweetalert/sweetalert.min.js"></script>
    <script src="js/lib/sweetalert/sweetalert.init.js"></script>

    <?php 
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {

?>
    <script>
    sweetAlert("<?php echo $_SESSION['alert']; ?>", "<?php echo $_SESSION['status']; ?>", "<?php echo $_SESSION['status-code']; ?>");
    </script>
<?php
unset($_SESSION['status']);
}
?>

</body>

</html>