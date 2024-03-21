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

    <link href="css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="css/lib/themify-icons.css" rel="stylesheet">
    <link href="css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="css/lib/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/lib/sweetalert/sweetalert.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="library/bootstrap-5/bootstrap.min.css" rel="stylesheet" />
    <link href="library/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="library/daterangepicker.css" rel="stylesheet" />

    <script src="library/jquery.min.js"></script>
    <script src="library/bootstrap-5/bootstrap.bundle.min.js"></script>
    <script src="library/moment.min.js"></script>
    <script src="library/daterangepicker.min.js" defer></script>
    <script src="library/Chart.bundle.min.js"></script>
    <script src="library/jquery.dataTables.min.js"></script>
    <script src="library/dataTables.bootstrap5.min.js"></script>


</head>

<body >
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
                                <div class="container-fluid">

                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col col-sm-9">Report and Analysis Per Incident Category</div>
                                        <div class="col col-sm-3">
                                                        <select id="calamity_incident" name="calamity_incident" class="form-control" id="calamity_incident" required>
                            <option selected value="" disabled>Select Type of Incident/Calamity</option>
                            <?php
      $show = $db->selectALL_CALAMITY_INCIDENT();
      foreach ($show as $key) {
      ?>
                            <option value="<?= $key['calamity_name'] ?>"><?= $key['calamity_name'] ?></option>
                            <?php
      }
      ?>
                        </select>
                                            <input type="text" id="daterange_textbox" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="chart-container pie-chart">
                                            <canvas id="bar_chart" height="40"> </canvas>
                                        </div>
                                        <table class="table table-striped table-bordered " id="order_table">
                                            <thead>
                                                <tr>
                                             
                                                    <th>Total</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                       <!--  <form method="POST"class="myForm">
                        <input type="hidden" class="form-control" name="longitude" required readonly>
                        <input type="hidden" class="form-control" name="latitude" required readonly>
                        <button name="update" class="btn btn-success">Update Map</button>
                        </form> -->
                        
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
<!--     <script src="js/lib/jquery.min.js"></script>
    <script src="js/lib/jquery.nanoscroller.min.js"></script> -->
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




    <script>
    $(document).ready(function () {

        fetch_data();

        var sale_chart;

        function fetch_data(start_date = '', end_date = '', type = 'All Incident') {

   
            var dataTable = $('#order_table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "genReport.php",
                    type: "POST",
                    data: {
                        action: 'fetch',
                        start_date: start_date,
                        end_date: end_date,
                        type
                    }
                },
                "drawCallback": function (settings) {
                    var sales_date = [];
                    var sale = [];

                    for (var count = 0; count < settings.aoData.length; count++) {
                        sales_date.push(settings.aoData[count]._aData[1]);
                        sale.push(parseFloat(settings.aoData[count]._aData[0]));
                    }



                    let sum = sale.reduce((acc, current) => {
                        return acc + current
                    }, 0)

                    var chart_data = {
                        labels: sales_date,
                        datasets: [{
                            label: `${type} Total = ${sum}`,
                            backgroundColor: 'rgb(255, 205, 86)',
                            color: '#fff',
                            data: sale
                        }]
                    };

                    var group_chart3 = $('#bar_chart');

                    if (sale_chart) {
                        sale_chart.destroy();
                    }

                    sale_chart = new Chart(group_chart3, {
                        type: 'bar',
                        data: chart_data
                    });
                }
            });
        }


        $('#calamity_incident').on('change', function() {
             let val =  $(this).val();
             $('#order_table').DataTable().destroy();


            let startDate = $('#daterange_textbox').data('daterangepicker').startDate.format('YYYY-MM-DD');
            let endDate = $('#daterange_textbox').data('daterangepicker').endDate.format('YYYY-MM-DD');

             fetch_data(startDate,endDate,val);
        });

        $('#daterange_textbox').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month')
                    .endOf('month')
                ]
            },
            format: 'YYYY-MM-DD'
        }, function (start, end) {

            $('#order_table').DataTable().destroy();

            fetch_data(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

        });

    });
</script>



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
