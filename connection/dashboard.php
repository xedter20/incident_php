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




if(ISSET($_POST['update'])){
    $ID = $_SESSION['auth_user']['admin_id'];

    $LONGITUDE = $_POST['longitude'];
    $LATITUDE = $_POST['latitude'];

    $sql = $db->adminsystem_UPDATE_BARANGAY_MAP($LONGITUDE, $LATITUDE, $ID);

date_default_timezone_set('Asia/Manila');
$date = date('F / d l / Y');
$time = date('g:i A');
$logs = 'Map is updated';

$sql2 = $db->adminsystem_INSERT_NOTIFICATION($ID, $logs, $date, $time);

        $_SESSION['alert'] = "Success";
        $_SESSION['status'] = "Map Updated";
        $_SESSION['status-code'] = "success";
    
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- theme meta -->
    <meta name="theme-name" content="focus" />
    <title>Focus Admin: Creative Admin Dashboard</title>
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
    <!-- Styles -->
    <link href="css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    <link href="css/lib/chartist/chartist.min.css" rel="stylesheet">
    <link href="css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="css/lib/themify-icons.css" rel="stylesheet">
    <link href="css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="css/lib/weather-icons.css" rel="stylesheet" />
    <link href="css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="css/lib/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/lib/sweetalert/sweetalert.css" rel="stylesheet">
</head>

<body onload="getLocation();">
<!---------NAVIGATION BAR-------->
<?php
require_once 'templates/admin_navbar.php';
?>
<!---------NAVIGATION BAR ENDS-------->


    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Hello, <span>Welcome Admin</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                                    </div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Total Residence</div>
                                        <?php

                                        $count = $db->COUNT_ALL_RESIDENTS();

                                        ?>
                                        <div class="stat-digit"><?php echo $count; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-user color-success border-success"></i>
                                    </div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Total Reports</div>
                                        <?php

                                        $count2 = $db->COUNT_ALL_REPORTS();

                                        ?>
                                        <div class="stat-digit"><?php echo $count2; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-user color-danger border-danger"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">New Reports</div>
                                        <?php

                                        $count3 = $db->COUNT_ALL_REPORTS_WHERE_PENDING();

                                        ?>
                                        <div class="stat-digit"><?php echo $count3; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-----------CHART-------------->
                    <?php
                    if (isset($_SESSION['auth_user']['admin_id'])) {
                        $id = $_SESSION['auth_user']['admin_id'];

                        $row = $db->adminsystemBARANGAY_MAP($coordinatorID);
                        if ($row) {
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card nestable-cart">
                                        <div class="card-title">
                                            <h4>Barangay Map</h4>
                                        </div>
                                        <div class="Vector-map-js">
                                            <iframe src="https://www.google.com/maps?q=<?= $row['latitude'] ?>,<?= $row['longitude'] ?>&hl=es;z=14&output=embed" style="width: 100%; height: 500px;"></iframe>
                                        </div>
                                    </div>
                                    <!-- /# card -->
                                </div>
                                <!-- /# column -->
                            </div>
                            <?php
                        }
                    }
                    ?>
                        <form method="POST"class="myForm">
                        <input type="hidden" class="form-control" name="longitude" required readonly>
                        <input type="hidden" class="form-control" name="latitude" required readonly>
                        <button name="update" class="btn btn-success">Update Map</button>
                        </form>
                        
<script>
    function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  }
}

function showPosition(position) {
  document.querySelector('.myForm input[name="latitude"]').value = position.coords.latitude;
  document.querySelector('.myForm input[name="longitude"]').value = position.coords.longitude;
}
function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("You must ALLOW the request for Location to locate your barangay.");
            location.reload();
            break;
        default:
            alert("An error occurred while getting your location.");
    }
}
</script>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer">
                              
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- jquery vendor -->
    <script src="js/lib/jquery.min.js"></script>
    <script src="js/lib/jquery.nanoscroller.min.js"></script>
    <!-- nano scroller -->
    <script src="js/lib/menubar/sidebar.js"></script>
    <script src="js/lib/preloader/pace.min.js"></script>
    <!-- sidebar -->

    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
    <!-- bootstrap -->

    <script src="js/lib/calendar-2/moment.latest.min.js"></script>
    <script src="js/lib/calendar-2/pignose.calendar.min.js"></script>
    <script src="js/lib/calendar-2/pignose.init.js"></script>

    <script src="js/lib/chart-js/Chart.bundle.js"></script>
    <script src="js/lib/chart-js/chartjs-init.js"></script>

    <script src="js/lib/weather/jquery.simpleWeather.min.js"></script>
    <script src="js/lib/weather/weather-init.js"></script>
    <script src="js/lib/circle-progress/circle-progress.min.js"></script>
    <script src="js/lib/circle-progress/circle-progress-init.js"></script>
    <script src="js/lib/chartist/chartist.min.js"></script>
    <script src="js/lib/sparklinechart/jquery.sparkline.min.js"></script>
    <script src="js/lib/sparklinechart/sparkline.init.js"></script>
    <script src="js/lib/owl-carousel/owl.carousel.min.js"></script>
    <script src="js/lib/owl-carousel/owl.carousel-init.js"></script>
    <!-- scripit init-->
    <script src="js/dashboard2.js"></script>

    
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
