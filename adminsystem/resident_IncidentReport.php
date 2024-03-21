<?php

include '../connection/config.php';

$db = new Database();

//display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if($_SESSION['auth_user']['admin_id']==0){
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
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">

        <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
 <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

</head>

<body>


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
                                <h1 id="toClick" class="">Incident Reports</h1>
                                
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
                                    <li class="breadcrumb-item active">Residents Incident Report</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <div class="row">

          <div class="col-lg-6">
                        <div class="card">
                            <div class="card-title">
                                <h4> Total Reports Per Incidents </h4>

                            </div>
                            <div class="sales-chart">
                                <canvas id="myChart2_month"></canvas>
                            </div>
                        </div>
                    
                    </div>
               <div class="col-lg-6 d-none">
                        <div class="card">
                            <div class="card-title">
                                <h4>  Monthly report </h4>

                            </div>
                            <div class="sales-chart">
                                <!-- <canvas id="myChart_month"></canvas> -->
                            </div>
                        </div>
                        <!-- /# card -->
                    </div>

                  <!--   <div class="col-lg-6">
                        <div class="card">
                            <div class="card-title">
                                <h4> Incident/Calamity Report Per Month </h4>

                            </div>
                            <div class="sales-chart">
                                <canvas id="myChart_month"></canvas>
                            </div>
                        </div>
                       
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-title">
                                <h4> Total Reports Per Incidents </h4>

                            </div>
                            <div class="sales-chart">
                                <canvas id="myChart2_month"></canvas>
                            </div>
                        </div>
                    
                    </div>
 -->
                </div>
                <br>

                <div class="">
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Nav tabs -->
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs justify-content-start" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                                <i class="now-ui-icons objects_umbrella-13"></i> Pending
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                                <i class="now-ui-icons shopping_cart-simple"></i> Approved
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#rejected" role="tab">
                                                <i class="now-ui-icons shopping_cart-simple"></i> Rejected
                                            </a>
                                        </li>
 <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#completed" role="tab">
                                                <i class="now-ui-icons shopping_cart-simple"></i> Completed
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                                <div class="card-body">
                                    <!-- Tab panes -->
                                    <div class="tab-content text-center">
                                        <div class="tab-pane active" id="home" role="tabpanel">
                                            <table id="datatablesss" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Date </th>
                                                            <th>Time</th>
                                                        <th>Full Name</th>
                                                        <th>Complete Address</th>
                                                        <th>Phone Number</th>
                                                        <th>Email</th>
                                                        <th>Report Status</th>
                                                
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        
                                                        $data = $db->SELECT_ALL_INCIDENT_REPORT('Pending');


                       ;

                                                        foreach ($data as $result) {
                                                        ?>
                                                    <tr>
                                                        <td><?= $result['dateOFSubmit'] ?></td>
                                                             <td>
                                                            <?= $result['timeOfSubmit'] ?></td>


                                                        <td><?= $result['first_name'] ?> <?= $result['middle_name'] ?>
                                                            <?= $result['last_name'] ?>
                                                        </td>
                                                        <td><?= $result['complete_address'] ?></td>
                                                        <td><?= $result['phone_number'] ?></td>
                                                        <td><?= $result['resident_email'] ?></td>
                                                        <td><?= $result['report_status'] ?></td>
                                                        <td>
                                                            <a href="VIEWresident_IncidentReport.php?resident_ID=<?= $result['residentID'] ?>&&report_ID=<?= $result['reportID'] ?>"
                                                                class="btn btn-primary">View Report</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        }
                                                        ?>
                                                </tbody>

                                            </table>
                                        </div>
                                        <div class="tab-pane text-center" id="profile" role="tabpanel">
                                            <table id="datablesApproved"
                                                class="table table-striped table-bordered text-center"
                                                style=" width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Date & Time</th>
                                                        <th>Full Name</th>
                                                        <th>Complete Address</th>
                                                        <th>Phone Number</th>
                                                        <th>Email</th>
                                                        <th>Report Status</th>
                                                        <th>Reason</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        
                                                        $data = $db->SELECT_ALL_INCIDENT_REPORT('Approved');

                                                        foreach ($data as $result) {
                                                        ?>
                                                    <tr>
                                                        <td><?= $result['dateOFSubmit'] ?> -
                                                            <?= $result['timeOfSubmit'] ?></td>
                                                        <td><?= $result['first_name'] ?> <?= $result['middle_name'] ?>
                                                            <?= $result['last_name'] ?>
                                                        </td>
                                                        <td><?= $result['complete_address'] ?></td>
                                                        <td><?= $result['phone_number'] ?></td>
                                                        <td><?= $result['resident_email'] ?></td>
                                                        <td><?= $result['report_status'] ?></td>
                                                        <td><?= $result['approval_remarks'] ?></td>
                                                        <td>
                                                            <a href="VIEWresident_IncidentReport.php?resident_ID=<?= $result['residentID'] ?>&&report_ID=<?= $result['reportID'] ?>"
                                                                class="btn btn-primary">View Report</a>
                                                                  
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        }
                                                        ?>
                                                </tbody>

                                            </table>
                                        </div>
                                        <div class="tab-pane text-center" id="rejected" role="tabpanel">
                                            <table id="datablesRejected"
                                                class="table table-striped table-bordered text-center"
                                                style=" width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Date & Time</th>
                                                        <th>Full Name</th>
                                                        <th>Complete Address</th>
                                                        <th>Phone Number</th>
                                                        <th>Email</th>
                                                        <th>Report Status</th>
                                                        <th>Reason</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        
                                                        $data = $db->SELECT_ALL_INCIDENT_REPORT('Rejected');

                                                        foreach ($data as $result) {
                                                        ?>
                                                    <tr>
                                                        <td><?= $result['dateOFSubmit'] ?> -
                                                            <?= $result['timeOfSubmit'] ?></td>
                                                        <td><?= $result['first_name'] ?> <?= $result['middle_name'] ?>
                                                            <?= $result['last_name'] ?>
                                                        </td>
                                                        <td><?= $result['complete_address'] ?></td>
                                                        <td><?= $result['phone_number'] ?></td>
                                                        <td><?= $result['resident_email'] ?></td>
                                                        <td><?= $result['report_status'] ?></td>
                                                        <td><?= $result['approval_remarks'] ?></td>
                                                        <td>
                                                            <a href="VIEWresident_IncidentReport.php?resident_ID=<?= $result['residentID'] ?>&&report_ID=<?= $result['reportID'] ?>"
                                                                class="btn btn-primary">View Report</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        }
                                                        ?>
                                                </tbody>

                                            </table>
                                        </div>
                                             <div class="tab-pane text-center" id="completed" role="tabpanel">
                                            <table id="datablesCompleted"
                                                class="table table-striped table-bordered text-center"
                                                style=" width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Date & Time</th>
                                                        <th>Full Name</th>
                                                        <th>Complete Address</th>
                                                        <th>Phone Number</th>
                                                        <th>Email</th>
                                                        <th>Report Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        
                                                        $data = $db->SELECT_ALL_INCIDENT_REPORT('Completed');

                                                        foreach ($data as $result) {
                                                        ?>
                                                    <tr>
                                                        <td><?= $result['dateOFSubmit'] ?> -
                                                            <?= $result['timeOfSubmit'] ?></td>
                                                        <td><?= $result['first_name'] ?> <?= $result['middle_name'] ?>
                                                            <?= $result['last_name'] ?>
                                                        </td>
                                                        <td><?= $result['complete_address'] ?></td>
                                                        <td><?= $result['phone_number'] ?></td>
                                                        <td><?= $result['resident_email'] ?></td>
                                                        <td><?= $result['report_status'] ?></td>
                                                        <td>
                                                            <a href="VIEWresident_IncidentReport.php?resident_ID=<?= $result['residentID'] ?>&&report_ID=<?= $result['reportID'] ?>"
                                                                class="btn btn-primary">View Report</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        }
                                                        ?>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>




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
    </div>


  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>



    <script>
        // new DataTable('#datatablesss');

  $(document).ready(function() {

console.log("Dex");




$(window).on('shown.bs.modal', function() { 
    $('#analysisModal').modal('show');
   console.log("Dex");
});



  });


           let table = $('#datatablesss').DataTable({
                    dom: 'Bfrtip',
                    order: [[0, 'desc']],
                    buttons: [{
                        extend: ['print'],
                        title: ' ',
                        message: ' ',
                        customize: function (win) {

                   
                            $(win.document.body).append(
                                '<html elements here>'); //after the table
                            $(win.document.body).prepend(
                                `<h3 class="text-center">Report</h3>
                       
                                    
                                    `); //before the table
                        }
                    }, ]
                });






















 


                  $('#datablesApproved').DataTable( {
                dom: 'Bfrtip',
                          buttons: [{
                        extend: ['print'],
                        title: ' ',
                        message: ' ',
                        customize: function (win) {

                   
                            $(win.document.body).append(
                                '<html elements here>'); //after the table
                            $(win.document.body).prepend(
                                `<h3 class="text-center">Report</h3>
                       
                                    
                                    `); //before the table
                        }
                    }, ]
            } );

                    $('#datablesRejected').DataTable( {
                dom: 'Bfrtip',
                          buttons: [{
                        extend: ['print'],
                        title: ' ',
                        message: ' ',
                        customize: function (win) {

                   
                            $(win.document.body).append(
                                '<html elements here>'); //after the table
                            $(win.document.body).prepend(
                                `<h3 class="text-center">Report</h3>
                       
                                    
                                    `); //before the table
                        }
                    }, ]
            } );

           $('#datablesCompleted').DataTable( {
                dom: 'Bfrtip',
                          buttons: [{
                        extend: ['print'],
                        title: ' ',
                        message: ' ',
                        customize: function (win) {

                   
                            $(win.document.body).append(
                                '<html elements here>'); //after the table
                            $(win.document.body).prepend(
                                `<h3 class="text-center">Report</h3>
                       
                                    
                                    `); //before the table
                        }
                    }, ]
            } );

 

    </script>





    <!-- Common -->
    <script src="js/lib/jquery.min.js"></script>
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
        sweetAlert("<?php echo $_SESSION['alert']; ?>", "<?php echo $_SESSION['status']; ?>",
            "<?php echo $_SESSION['status-code']; ?>");
    </script>
    <?php
unset($_SESSION['status']);
}
?>


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php
$data = $db->incidentREPORTS_graph();
?>

    <?php
$incidentREPORTS_graph_2_data = $db->incidentREPORTS_graph_2();
?>

  
  <script>
    // Use PHP data in JavaScript
    const labels3 = <?php echo json_encode(array_column($data, 'monthOfSubmit')); ?>;
    const labels3_2 = <?php echo json_encode(array_column($data, 'calamities_incident')); ?>;
    const values3 = <?php echo json_encode(array_column($data, 'Incident_Calamity')); ?>;

    // Function to generate random rgba color
    function getRandomColor() {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        return `rgba(${r}, ${g}, ${b}, 0.5)`;
    }

    // Create the chart
    // const ctx3 = document.getElementById('myChart_month').getContext('2d');
    // const myChart3 = new Chart(ctx3, {
    //     type: 'bar',
    //     data: {
    //         labels: labels3,
    //         datasets: [{
    //             label: 'Total Reports',
    //             backgroundColor: getRandomColor(),
    //             borderColor: getRandomColor(),
    //             borderWidth: 1,
    //             data: values3,
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true,
    //                 ticks: {
    //                     callback: (value) => value,
    //                 },
    //             },
    //         },
    //         plugins: {
    //             tooltip: {
    //                 callbacks: {
    //                     label: (context) => {
    //                         let label = 'Total Reports' + ': '; // Use the dynamically fetched label
    //                         if (context.parsed.y !== null) {
    //                             label += context.parsed.y;
    //                         }
    //                         return label;
    //                     },
    //                 },
    //             },
    //         },
    //     },
    // });
</script>



    <?php
$data = $db->incidentREPORTS_graph_2();
?>

    <script>
        // Use PHP data in JavaScript
        const labels4_2 = <?php echo json_encode(array_column($data, 'calamities_incident')); ?> ;
        const values4 = <?php echo json_encode(array_column($data, 'Incident_Calamity')); ?> ;



        // Function to generate random rgba color
        function getRandomColor() {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);
            return `rgba(${r}, ${g}, ${b}, 0.5)`;
        }

        // Create the chart
        const ctx4 = document.getElementById('myChart2_month').getContext('2d');
        const myChart4 = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: labels4_2,
                datasets: [{
                    label: 'Total Reports',
                    backgroundColor: getRandomColor(),
                    borderColor: getRandomColor(),
                    borderWidth: 1,
                    data: values4,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => value,
                        },
                    },
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                let label = 'Total Reports' + ': '; // Use the dynamically fetched label
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y;
                                }
                                return label;
                            },
                        },
                    },
                },
            },
        });
    </script>

<script>

(function ajaxRequest() {
  $.ajax('fetchAllIncidentReportLive.php', {
    type: 'post',
      data: {
       fetchAllIncidentReportLive:true
     }
  })
    .done(function (result) {
      // Do whatever you want with the data.

      let data = JSON.parse(result);

   let dates = data.map((res)=>{

    let date_from_database = new Date(`${res.dateOFSubmit} ${res.timeOfSubmit}`);

     var endTime = new Date();


     let startTimeMilli = new Date( Date.now() - 1000 * 60 ).getTime();
     var endTimeMilli = date_from_database;
      endTimeMilli.setMinutes(endTimeMilli.getMinutes()+1);
      let timeToCheckMilli = date_from_database.getTime();


    //   console.log({
    //     startTimeMilli: new Date(startTimeMilli),
    //     timeToCheckMilli: new Date(timeToCheckMilli),
    //     dex:new Date(endTimeMilli)
    // })


    let isPlaySound = false;

    // change >= to > or <= to < as you need
    if (timeToCheckMilli >= startTimeMilli && timeToCheckMilli <= new Date(endTimeMilli).getTime()) {
        isPlaySound = true;
    }else{
        // console.log("dex");
    }



    return  {
        isPlaySound
    };
    });
    
    // console.log(dates);




    function newTabFunction() {
        
            var win = window.open('https://cdn.freesound.org/previews/321/321685_5365416-lq.mp3', '_blank');
            if (win) {
                //Browser has allowed it to be opened
            // win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }


        let hasSound = dates.some((d)=>{
            return d.isPlaySound
        });
        if(hasSound){
            newTabFunction();
        }


    // var win = window.open('http://stackoverflow.com/', '_blank');
    //     if (win) {
    //         //Browser has allowed it to be opened
    //         win.focus();
    //     } else {
    //         //Browser has blocked it
    //         alert('Please allow popups for this website');
    //     }


    })
    .always(function (data) {
      // We are starting a new timer only AFTER COMPLETING the previous request.
      setTimeout(ajaxRequest, 5000);
    });
})();


</script>




</body>

</html>