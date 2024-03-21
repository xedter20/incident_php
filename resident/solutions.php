<?php

include '../connection/config.php';
$db = new Database();

error_reporting(0);
// Enable error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

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
                                <h1>Incident/Calamity Solutions</h1>
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
                                    <li class="breadcrumb-item active">Incident/Calamity Solutions</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <p>This shows the possible solutions based on the trending incident/calamity reports.</p>
                <?php
                $solutions = $db->SELECT_ALL_incidentREPORTS_Trending();

                $incident_calamity_name = $solutions['calamities_incident'];

                if ($incident_calamity_name == 'Fire') {
                  ?>
                <div class="col-lg-8 p-r-0 title-margin-right">

                  <div class="fire-prevention-solutions">
                      <h2>Possible Solutions to Prevent Fire Accidents:</h2>
                      <ul>
                          <li>
                              <strong>Education and Awareness:</strong>
                              <ul>
                                  <li>Implement comprehensive fire safety education programs...</li>
                                  <li>Conduct regular fire drills to ensure quick and effective responses.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Strict Building Codes and Inspections:</strong>
                              <ul>
                                  <li>Enforce and update building codes for fire-resistant structures.</li>
                                  <li>Conduct regular inspections focusing on fire exits and electrical systems.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Improved Electrical Safety:</strong>
                              <ul>
                                  <li>Encourage the use of certified electricians for wiring installations.</li>
                                  <li>Promote regular inspection and maintenance of electrical systems.</li>
                              </ul>
                          </li>

                          <!-- Add other solutions here following a similar structure -->

                      </ul>
                  </div>
              </div>

                <?php
                }else if ($incident_calamity_name == 'Earthquake') {
                  ?>
                <div class="col-lg-8 p-r-0 title-margin-right">

                  <!-- Earthquake Prevention Solutions -->
                  <div class="earthquake-prevention-solutions">
                      <h2>Possible Solutions to Prevent Earthquakes:</h2>
                      <ul>
                          <li>
                              <strong>Building Design and Retrofitting:</strong>
                              <ul>
                                  <li>Implement and enforce earthquake-resistant building codes.</li>
                                  <li>Retrofit older buildings to meet modern seismic safety standards.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Early Warning Systems:</strong>
                              <ul>
                                  <li>Establish and maintain earthquake early warning systems.</li>
                                  <li>Implement public alert systems to inform residents in advance.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Land Use Planning:</strong>
                              <ul>
                                  <li>Restrict development in high-seismic risk zones.</li>
                                  <li>Implement zoning regulations to ensure safe distances between structures.</li>
                              </ul>
                          </li>

                          <!-- Add other earthquake prevention solutions here following a similar structure -->

                      </ul>
                  </div>
              </div>

                <?php
                }else if ($incident_calamity_name == 'Flood') {
                  ?>
                <div class="col-lg-8 p-r-0 title-margin-right">

                  <!-- Flood Prevention Solutions -->
                  <div class="flood-prevention-solutions">
                      <h2>Possible Solutions to Prevent Floods:</h2>
                      <ul>
                          <li>
                              <strong>Improved Urban Drainage:</strong>
                              <ul>
                                  <li>Invest in better stormwater management systems for urban areas.</li>
                                  <li>Implement green infrastructure to absorb and slow down rainwater runoff.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Embankments and Levees:</strong>
                              <ul>
                                  <li>Construct and maintain embankments and levees to control river and coastal flooding.</li>
                                  <li>Regularly inspect and reinforce these structures to ensure effectiveness.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Early Warning Systems:</strong>
                              <ul>
                                  <li>Establish and maintain flood monitoring and early warning systems.</li>
                                  <li>Implement community alert systems to evacuate residents in at-risk areas.</li>
                              </ul>
                          </li>

                          <!-- Add other flood prevention solutions here following a similar structure -->

                      </ul>
                  </div>
              </div>

              <?php
                }else if ($incident_calamity_name == 'Health Emergencies') {
                  ?>
                <div class="col-lg-8 p-r-0 title-margin-right">

                  <!-- Health Emergency Prevention and Response Solutions -->
                  <div class="health-emergency-solutions">
                      <h2>Possible Solutions for Health Emergencies:</h2>
                      <ul>
                          <li>
                              <strong>Emergency Preparedness Training:</strong>
                              <ul>
                                  <li>Provide training programs for individuals and communities on basic first aid and emergency response.</li>
                                  <li>Establish community-based emergency response teams.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Accessible Healthcare Facilities:</strong>
                              <ul>
                                  <li>Ensure access to well-equipped healthcare facilities in both urban and rural areas.</li>
                                  <li>Regularly review and update emergency protocols in healthcare settings.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Public Health Campaigns:</strong>
                              <ul>
                                  <li>Conduct public health campaigns to educate communities on disease prevention and hygiene practices.</li>
                                  <li>Provide information on vaccination programs and disease control measures.</li>
                              </ul>
                          </li>

                          <!-- Add other health emergency prevention and response solutions here following a similar structure -->

                      </ul>
                  </div>
              </div>

              <?php
                }else if ($incident_calamity_name == 'Traffic Accidents') {
                  ?>
                <div class="col-lg-8 p-r-0 title-margin-right">

                  <!-- Traffic Accident Prevention Solutions -->
                  <div class="traffic-accident-solutions">
                      <h2>Possible Solutions to Prevent Traffic Accidents:</h2>
                      <ul>
                          <li>
                              <strong>Strict Traffic Regulations:</strong>
                              <ul>
                                  <li>Enforce and regularly update traffic laws and regulations.</li>
                                  <li>Implement strict penalties for traffic violations to deter reckless driving.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Infrastructure Improvements:</strong>
                              <ul>
                                  <li>Invest in well-designed and maintained road infrastructure.</li>
                                  <li>Implement traffic calming measures in accident-prone areas.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Public Awareness Campaigns:</strong>
                              <ul>
                                  <li>Conduct educational campaigns on safe driving practices and the dangers of distracted driving.</li>
                                  <li>Promote responsible alcohol consumption and discourage driving under the influence.</li>
                              </ul>
                          </li>

                          <!-- Add other traffic accident prevention solutions here following a similar structure -->

                      </ul>
                  </div>

              </div>

                <?php
                }else if ($incident_calamity_name == 'Criminal Activities') {
                  ?>
                <div class="col-lg-8 p-r-0 title-margin-right">

                  <!-- Crime Prevention Solutions -->
                  <div class="crime-prevention-solutions">
                      <h2>Possible Solutions to Prevent Criminal Activities:</h2>
                      <ul>
                          <li>
                              <strong>Community Policing:</strong>
                              <ul>
                                  <li>Encourage community engagement with local law enforcement.</li>
                                  <li>Establish neighborhood watch programs to enhance community safety.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Effective Law Enforcement:</strong>
                              <ul>
                                  <li>Invest in training and equipping law enforcement agencies.</li>
                                  <li>Implement intelligence-led policing strategies.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Crime Deterrence Measures:</strong>
                              <ul>
                                  <li>Install surveillance cameras in public spaces to deter criminal activities.</li>
                                  <li>Implement well-lit and well-maintained public areas.</li>
                              </ul>
                          </li>

                          <!-- Add other crime prevention solutions here following a similar structure -->

                      </ul>
                  </div>
                  
              </div>

              <?php
                }else if ($incident_calamity_name == 'Environmental Incidents') {
                  ?>
                <div class="col-lg-8 p-r-0 title-margin-right">

                  <!-- Environmental Incident Prevention Solutions -->
                  <div class="environmental-incident-solutions">
                      <h2>Possible Solutions to Prevent Environmental Incidents:</h2>
                      <ul>
                          <li>
                              <strong>Environmental Education:</strong>
                              <ul>
                                  <li>Implement programs to educate the public on environmental conservation and sustainable practices.</li>
                                  <li>Promote responsible waste disposal and recycling.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Regulatory Compliance:</strong>
                              <ul>
                                  <li>Strengthen and enforce environmental regulations for industries and businesses.</li>
                                  <li>Implement monitoring systems to ensure compliance with environmental standards.</li>
                              </ul>
                          </li>

                          <li>
                              <strong>Emergency Response Planning:</strong>
                              <ul>
                                  <li>Develop and regularly update emergency response plans for environmental incidents.</li>
                                  <li>Conduct drills and simulations to ensure effective responses to spills, leaks, or other incidents.</li>
                              </ul>
                          </li>

                          <!-- Add other environmental incident prevention solutions here following a similar structure -->

                      </ul>
                  </div>
                  
              </div>

                <?php
                }
                ?>

                







               <!-- MAIN BODY --> 







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


</body>

</html>