<?php

include '../connection/config.php';
$db = new Database();

//display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if($_SESSION['auth_user']['resident_id']==0){
    echo"<script>window.location.href='index.php'</script>";
    
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


    <!---------------------DATATABLES------------------------->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">

    

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
                                <h1>Incident Reports</h1>
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
                                    <li class="breadcrumb-item active">Student Narrative Report</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <table id="datatablesss" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Incident/Calamity</th>
                <th>Description</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
if(isset($_SESSION['auth_user']['resident_id'])) {
    $residentID = $_SESSION['auth_user']['resident_id'];

    $data = $db->SELECT_ALL_incidentREPORTS_resident_data($residentID);

    foreach ($data as $result) {
?>
        <tr>
            <td><?= $result['dateOFSubmit'] ?> - <?= $result['timeOfSubmit'] ?></td>
            <td><?= $result['calamities_incident'] ?></td>
            <td><?= $result['description'] ?></td>
            <td><?= $result['latitude'] ?></td>
            <td><?= $result['longitude'] ?></td>
            <td><?= $result['report_status'] ?></td>
            <td><?= $result['approval_remarks'] ?></td>
            <td>
                <button class="btn btn-primary view-image-btn" data-toggle="modal" data-target="#imageModal" data-image="<?= $result['incident_picture'] ?>">View Image File</button>

                 <button class="btn btn-warning view-image-btn" data-toggle="modal" data-target="#analysisModal" data-image="<?= $result['incident_picture'] ?>"

data-book-id="<?= $result['analysisHelp'] ?>"
                    >View Analysis</button>

            </td>
        </tr>
<?php
    }
}
?>

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
                <img id="modalImage" src="" alt="Image" style="width: 100%;">
            </div>
        </div>
    </div>
</div>


<!-- Modal to display the analysis -->
<div class="modal fade" id="analysisModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Analysis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
  -moz-binding: url('xbl.xml#wordwrap'); /* Firefox (using XBL) */"></p>
                <!-- <img id="modalImage" src="" alt="Image" style="width: 100%;"> -->
            </div>
        </div>
    </div>
</div>


        </tbody>
        <tfoot>
            <tr>
                <th>Date & Time</th>
                <th>Incident/Calamity</th>
                <th>Description</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>


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


<!-- <script>
    new DataTable('#datatablesss');
    
</script> -->

<!-- Initialize DataTables with export buttons -->
<script>
    $(document).ready(function() {
        $('#datatablesss').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $('#analysisModal').on('show.bs.modal', function(e) {

    //get data-id attribute of the clicked element
    var analysis = $(e.relatedTarget).data('book-id');

    //populate the textbox

    console.log($(e.currentTarget));
    

     $(e.currentTarget).find('#toAppend').text(analysis);
});

    });


</script>

<script>
    // JavaScript to set the image source when the button is clicked
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('view-image-btn')) {
            var imageSrc = event.target.getAttribute('data-image');
            document.getElementById('modalImage').setAttribute('src', imageSrc);
        }
    });
</script>


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>


    <!-- Common -->
    <script src="js/lib/jquery.nanoscroller.min.js"></script>
    <script src="js/lib/menubar/sidebar.js"></script>
    <script src="js/lib/preloader/pace.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>

    <!-- Sweet Alert -->
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