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
    // $adminID = $_SESSION['auth_user']['admin_id'];

    // $reportID = $_POST['report_id'];

    // $status = 'Completed';

    // $sql = $db->UPDATE_INCIDENT_REPORT($status, $reportID);

    // date_default_timezone_set('Asia/Manila');
    // $date = date('F / d l / Y');
    // $time = date('g:i A');
    // $logs = 'Completed.';

    // $sql2 = $db->adminsystem_INSERT_NOTIFICATION_3($adminID, $logs, $date, $time);

    //   $_SESSION['alert'] = "Success";
    //   $_SESSION['status'] = "Incident Report Completed";
    //   $_SESSION['status-code'] = "success";
  
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
    <link href="css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="css/lib/themify-icons.css" rel="stylesheet">
    <link href="css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" />
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
                                <h1>View Incident Report</h1>
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
                                    <li class="breadcrumb-item active">View Incident Report</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                <div class="page-header">
                        <div class="page-title">
                            <?php
                            if (isset($_GET['resident_ID'])) {
                                $residentID = $_GET['resident_ID'];

                                $data = $db->VIEW_RESIDENT_INCIDENT_REPORT($residentID);
                        
                              
                                $residentEmail = $data['resident_email'];
                                

                                if ($data) {  // Check if data exists
                            ?>
                                    <h1>
                                        <?php echo $data['first_name']; ?>
                                        <?php echo $data['middle_name']; ?>
                                        <?php echo $data['last_name']; ?>
                                        <span id="residentEmail" >

                                        ( <?php echo $residentEmail; ?>
                                        </span> )
                                    </h1>

                                   

                                <?php
                                } else {
                                    // Handle the case when no data is found, e.g., show an error message or redirect.
                                    echo "NO DAILY REPORTS";
                                }
                            }
                            ?>
                        </div>
                        </div>

                        </div>
                    </div>

                <?php
if(isset($_GET['report_ID'])){

  $reportID = $_GET['report_ID'];

$data = $db->VIEW_RESIDENT_INCIDENT_REPORT_2($reportID);
    
}
?>
<div class="form-inline">
  <div class="col-md-4 position-relative">
    <label for="validationTooltip02" class="form-label">Description</label>
    <textarea class="form-control" name="DESCRIPTION" id="validationTooltip02" required readonly style="height: 129px;width: 100%;"><?= $data['description'] ?></textarea>
  </div>

  <div class="col-md-4 position-relative text-center">
    <label for="validationTooltip02" class="form-label">Incident Picture</label>
    <button class="btn btn-primary view-image-btn" data-toggle="modal" data-target="#imageModal">View Picture<i class="ti-eye"></i></button>
</div>

  <!-- Modal to display the image -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="<?= $data['incident_picture'] ?>" alt="Image" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
<div class="col-md-4 position-relative">
    <label for="validationTooltip02" class="form-label">Incident/Calamity</label>
    <input type="text" class="form-control" name="latitude" value="<?= $data['calamities_incident'] ?>" required readonly style="width: 100%;">
  </div>
  <div class="col-md-4 position-relative">
    <label for="validationTooltip02" class="form-label">Latitude</label>
    <input type="text" class="form-control" name="latitude" value="<?= $data['latitude'] ?>" required readonly style="width: 100%;">
  </div>
  <div class="col-md-4 position-relative">
    <label for="validationTooltip02" class="form-label">Longitude</label>
<input type="text" class="form-control" name="longitude" value="<?= $data['longitude'] ?>" required readonly style="width: 100%;">
  </div><br><br>



 <div id="toAppend" class="text-justify" style="  /* The following styles prevent unbroken strings from breaking the layout */
    height: auto;            
  width: auto; /* set to whatever width you need */
  overflow: auto;
  white-space: -moz-pre-wrap; /* Mozilla */
  white-space: -hp-pre-wrap; /* HP printers */
  white-space: -o-pre-wrap; /* Opera 7 */
  white-space: -pre-wrap; /* Opera 4-6 */
  white-space: pre-wrap; /* CSS 2.1 */
  white-space: pre-line; /* CSS 3 (and 2.1 as well, actually) */
  word-wrap: break-word; /* IE */
  -moz-binding: url('xbl.xml#wordwrap'); /* Firefox (using XBL) */">
      <h2> Analysis Given to Resident</h2>
    <?php echo $data['analysisHelp'] ?>
  </div>
                <!-- <img id="modalImage" src="" alt="Image" style="width: 100%;"> -->
            </div>



          <div class="col-lg-12">
              <div class="card nestable-cart">
                  <div class="card-title">
                      <h4>Incident Location</h4>
                  </div>
                  <div class="Vector-map-js">
                      <iframe src="https://www.google.com/maps?q=<?= $data['latitude'] ?>,<?= $data['longitude'] ?>&hl=es;z=14&output=embed" style="width: 100%; height: 500px;"></iframe>
                  </div>
              </div>
              <!-- /# card -->
          </div>
          <!-- /# column -->
  </div>


<?php if($data['report_status']== 'Completed' ): ?>



<?php elseif($data['report_status']== 'Approved' ): ?>


    <form action="" method="post">
    <input type="hidden" name="report_id" value="<?= $data['id'] ?>">
  <div class="col-12" style="margin-top: 50px;">
    <button class="btn btn-success" name="Complete_Report" id="complete_report_button">Mark Report as Completed</button>
  </div>
</form>



<?php else: ?>
<form action="" method="post" >
    <input type="hidden" name="report_id" value="<?= $data['id'] ?>">
  <div class="col-12" style="margin-top: 50px;">
    <button class="btn btn-success" name="Approved_Report">Approve Report</button>
  </div>
</form>

<form action="" method="post">
    <input type="hidden" name="report_id" value="<?= $data['id'] ?>">
  <div class="col-12" style="margin-top: 50px;">
    <button class="btn btn-danger" name="Reject_Report">Reject Report</button>
  </div>
</form>

<?php endif; ?>


                <!-- /# row -->
                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="extra-area-chart"></div>
                            <div id="morris-line-chart"></div>
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
            alert("You must ALLOW the request for Location to loacte your barangay.");
            location.reload();
            break;
        default:
            alert("An error occurred while getting your location.");
    }
}
</script>



    <!-- Common -->
    <script src="js/lib/jquery.min.js"></script>
    <script src="js/lib/jquery.nanoscroller.min.js"></script>
    <script src="js/lib/menubar/sidebar.js"></script>
    <script src="js/lib/preloader/pace.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>

    <!--  Peity -->
    <script src="js/lib/peitychart/jquery.peity.min.js"></script>
    <script src="js/lib/peitychart/peitychart.init.js"></script>

    <!--  Sparkline -->
    <script src="js/lib/sparklinechart/jquery.sparkline.min.js"></script>
    <script src="js/lib/sparklinechart/sparkline.init.js"></script>

    <!-- Select2 -->
    <script src="js/lib/select2/select2.full.min.js"></script>

    <!--  Validation -->
    <script src="js/lib/form-validation/jquery.validate.min.js"></script>
    <script src="js/lib/form-validation/jquery.validate-init.js"></script>

    <!-- Sweet Alert -->
    <script src="js/lib/sweetalert/sweetalert.min.js"></script>
    <script src="js/lib/sweetalert/sweetalert.init.js"></script>



    <script>
   var forms = document.querySelectorAll('.needs-validation')
Array.prototype.slice.call(forms)
  .forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
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


<script>

    $('#complete_report_button').on("click", function(e) {
       e.preventDefault();

       let email = "<?php echo $residentEmail;?>";


        

        
        sweetAlert({
        title: "Complete Report",
        text: "Please add a remark",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: ""
        },
        function(inputValue){
        if (inputValue === null) return false;
        
        if (inputValue === "") {
            sweetAlert.showInputError("Required");
            return false
        }
        
        e.preventDefault();
    var form_data = new FormData();                  
    form_data.append('Complete_Report', true);
    form_data.append('report_id', "<?php echo  $data['id'];?>");
    form_data.append('remarks', inputValue);


        // sweetAlert("Nice!", "You wrote: " + inputValue, "success");
 
        $.ajax({
        type:"post",
        url: 'submitCompleteIncidentProcess.php', // <-- point to server-side PHP script 
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function (response) {

           // You will get response from your PHP page (what you echo or print)
          
           
                $.ajax({
                type:"post",
                url: 'http://localhost:8080/approveIncidentReport',
              

                data: {
                    isApproved: true,
                    email
                },
                success: function (response) {

                // You will get response from your PHP page (what you echo or print)
                   location.reload()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                }
                });
                
          // location.reload()
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
        });



        });



    });

    </script>

</body>

</html>