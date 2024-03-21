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



if (isset($_POST['Submit_Report'])) {

  $residentID = $_SESSION['auth_user']['resident_id'];
  $DESCRIPTION = $_POST['DESCRIPTION'];
  $latitude = $_POST['latitude'];
  $longitude = $_POST['longitude'];
  $status = $_POST['successPhotoValidation'];
   $analysisHelp =  $_POST['analysisHelp'];

  echo $residentID;
  $calamity_incident = $_POST['calamity_incident'];

  // Define the directory where you want to save the images
  $uploadDirectory = '../incident_report_images/'; // Change this to your desired directory

  // Generate a unique filename for the uploaded image
  $uniqueFilename = uniqid() . '-' . $_FILES['incident_picture']['name'];

  // Define the full path to the saved image file
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
     $longitude, $latitude , $status,'Approved',  $analysisHelp);

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




if(ISSET($_POST['update'])){
  $residentID = $_SESSION['auth_user']['resident_id'];

  $LONGITUDE = $_POST['longitude'];
  $LATITUDE = $_POST['latitude'];

  echo "<h1 class='page-title text-center'>
      LATITUDE: $LATITUDE
  

    </h1>";

      echo "<h1 class='page-title text-center'>
        
        LONGITUDE: $LONGITUDE

      </h1>";



$sql = $db->GET_UPDATE_resident_data_location_ONreport_incident($LONGITUDE, $LATITUDE, $residentID);

date_default_timezone_set('Asia/Manila');
$date = date('F / d l / Y');
$time = date('g:i A');
$logs = 'Location updated in submitting report';

$sql2 = $db->resident_data_InsertNotification($residentID, $logs, $date, $time);

$_SESSION['alert'] = "Success";
$_SESSION['status'] = "Location Located. The latitude & longitude of your location is updated";
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
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script type="module" src="./index.js"></script>
</head>

<body onload="getLocation();">
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
                                <h1>Submit Report</h1>
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
                                    <li class="breadcrumb-item active">Submit Report</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <?php
if(isset($_SESSION['auth_user']['resident_id'])){

  $residentID = $_SESSION['auth_user']['resident_id'];

  $data = $db->resident_data($residentID);
    
}
?>

                <!---------GET LOCATION. UPDATE LATITUDE & LONGITUDE---------->
                <form method="POST" class="myForm" >
                    <input type="hidden" class="form-control" name="longitude" required readonly>
                    <input type="hidden" class="form-control" name="latitude" required readonly>
                    <button name="update" class="btn btn-success">Get Location</button>
                </form>

                <form id="createIncident" action="" method="POST" class="row g-3 needs-validation" novalidate=""
                    enctype="multipart/form-data">

                    <div class="col-md-4 position-relative">
                        <label for="validationTooltip02" class="form-label">Description</label>
                        <textarea class="form-control" name="DESCRIPTION" id="validationTooltip02" required></textarea>
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="invalid-tooltip">
                            Description Required
                        </div>
                    </div>

                    <div class="col-md-4 position-relative">
                        <label for="validationTooltip02" class="form-label">Incident Picture</label>
                        <input type="hidden"  name="base64" id="base64" >
                        <input type="hidden"  name="successPhotoValidation" id="successPhotoValidation" >
                        <input type="file"  onchange="PreviewImage();" name="incident_picture" id="incident_picture" accept="image/*" required>
                        <img id="uploadPreview" style="width: 100px; height: 100px;" />
                        
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="invalid-tooltip">
                            Required
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationTooltip02" class="form-label">Incident/Calamity</label>

                        <select name="calamity_incident" class="form-control" id="calamity_incident" required>
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

                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="invalid-tooltip">
                            Required
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationTooltip02" class="form-label">Latitude</label>
                        <input type="text" class="form-control" name="latitude" value="<?= $data['latitude'] ?>"
                            id="latitude_value" required readonly>
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="invalid-tooltip">
                            Required
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationTooltip02" class="form-label">Longitude</label>
                        <input type="text" class="form-control" name="longitude" id="longitude_value"
                            value="<?= $data['longitude'] ?>" required readonly>
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="invalid-tooltip">
                            Required
                        </div>

                    </div><br><br>

                    <div class="col-lg-12">
                        <div class="card nestable-cart">
                            <div class="card-title">
                                <h4>Barangay Map</h4>
                            </div>
                            <div class="">
                                <!-- <?php
// var_dump($data);
                              ?> -->
                                <div id="map" style="height:100%"></div>


                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                    <!-- /# column -->

                    <div class="col-12" style="margin-top: 50px;">
                        <button class="btn btn-primary" name="Submit_Report" id="submitReport">Submit Report</button>
                    </div>
                </form>


                <!-- /# row -->
<div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="myModalLabel"> API CODE </h4>
       </div>
       <div class="modal-body" id="getCode" style="overflow-x: scroll;">
          //ajax success content here.
       </div>
    </div>
   </div>
 </div>

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
                alert("You must ALLOW the request for Location to locate your barangay.");
                location.reload();
                break;
            default:
                alert("An error occurred while getting your location.");
        }
    }

    function initMap() {

    }

    function placeMarkerAndPanTo(latLng, map) {
        new google.maps.Marker({
            position: latLng,
            map: map,
        });
        map.panTo(latLng);
    }

    window.initMap = initMap;
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
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
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
    sweetAlert("<?php echo $_SESSION['alert']; ?>", "<?php echo $_SESSION['status']; ?>",
        "<?php echo $_SESSION['status-code']; ?>");
    </script>
    <?php
unset($_SESSION['status']);
}
?>



    <script>
    (g => {
        var h, a, k, p = "The Google Maps JavaScript API",
            c = "google",
            l = "importLibrary",
            q = "__ib__",
            m = document,
            b = window;
        b = b[c] || (b[c] = {});
        var d = b.maps || (b.maps = {}),
            r = new Set,
            e = new URLSearchParams,
            u = () => h || (h = new Promise(async (f, n) => {
                await (a = m.createElement("script"));
                e.set("libraries", [...r] + "");
                for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                e.set("callback", c + ".maps." + q);
                a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                d[q] = f;
                a.onerror = () => h = n(Error(p + " could not load."));
                a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                m.head.append(a)
            }));
        d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
            d[l](f, ...n))
    })
    ({
        key: "AIzaSyCcUfVGkScWmxL2GEFm1_vVzZvsoykFiuQ",
        v: "weekly"
    });
    </script>

    <script type="module" src="./index.js"></script>

    <script type="text/javascript">

 var email = "<?php echo $_SESSION['auth_user']["email"];?>";


var base64 = '';
  function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("incident_picture").files[0]);

        oFReader.onload = function (oFREvent) {

          
           let base64 = oFReader.result;
            $('#base64').val(base64);
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

    $("#submitReport").on("click", function(e) {
     
        let isFormValid = $("#createIncident").valid();

       let dex=  document.getElementById("incident_picture").files[0]

      



  
const file = document.getElementById("incident_picture").files[0];



let base64Image = $('#base64').val();

// $("#getCodeModal").modal('show');







        if (isFormValid) {
            sweetAlert({
            title: "<h1> Our system is validating your submitted photo. </h1>",
            icon: "info",
            html: `
                You can use <b>bold text</b>,
                <a href="#">links</a>,
                and other HTML tags
            `,
            showCloseButton: false,
            showCancelButton: false,
            showConfirmButton: false,
            focusConfirm: false,


            cancelButtonText: false,
            cancelButtonAriaLabel: "Thumbs down"
            })

   
         e.preventDefault();
    


            $.ajax({
              //  https://sounds-jet.vercel.app/validateIncidentPhoto
                url: 'http://localhost:8080/validateIncidentPhoto',
                type: 'post',
                data: {
                    incidentPhoto: base64Image,
                    email:email,
                  calamity_incident_type:  $('#calamity_incident').val(),
                  description: $('textarea[name="DESCRIPTION"]').val()
                },
                dataType: 'json',
                success: function(data) {

                let {success, isPassed , arrayOfPassedValues,labelFromGoogle,analysisHelp} = data;

                console.log({isPassed,success,arrayOfPassedValues,labelFromGoogle,analysisHelp});

             

         
                // sweetAlert.close()

                if(isPassed){
                 $('#successPhotoValidation').val('Approved');
                 
                 $('#createIncident').submit();
                    
              

                }else{

                    $('#successPhotoValidation').val('Rejected');
              
                    alert('Submitted photo is not a valid incident. Please submit another photo.');

                }


            let lat = parseFloat($('#latitude_value').val());
            let lng = parseFloat($('#longitude_value').val());
            let desc = $('#validationTooltip02').val();
            
            var file_data = document.getElementById("incident_picture").files[0];
    var form_data = new FormData();                  
    form_data.append('incident_picture', file_data);
    form_data.append('successPhotoValidation', $('#successPhotoValidation').val());
    form_data.append('DESCRIPTION', desc);
    form_data.append('latitude', lat);
    form_data.append('longitude', lng);
    form_data.append('calamity_incident', $('#calamity_incident').val());

    form_data.append('analysisHelp',analysisHelp);
    
    $.ajax({
        type:"post",
        url: 'submitReportProcess.php', // <-- point to server-side PHP script 
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function (response) {

           // You will get response from your PHP page (what you echo or print)

         
           location.reload()
        },
        error: function(jqXHR, textStatus, errorThrown) {

           console.log(textStatus, errorThrown);
                     return true
        }
    });









       },
       error: function(request, error) {
                    alert("Request: " + JSON.stringify(request));
                }
         });
         
           
            


        }

    });
    </script>

</body>
<!-- AIzaSyCcUfVGkScWmxL2GEFm1_vVzZvsoykFiuQ -->

</html>