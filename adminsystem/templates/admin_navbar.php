<?php
$db = new Database();
?>


<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <div class="logo"><a href="dashboard.php">
                            <!-- <img src="images/logo.png" alt="" /> --><span>Baranggay Incident Management with Geospatial Analysis Based Tracking System</span></a></div>
                    <li class="label">Main</li>
                    <li><a href="dashboard.php"><i class="ti-home"></i> Dashboard </a></li>

                    <li class="label">Apps</li>
                    <li><a href="admin_profile.php"><i class="ti-user"></i><span>Profile</span></a></li>
                    <li><a href="admin_settings.php"><i class="ti-settings"></i><span>Settings</span></a></li>
                    <li><a href="resident_IncidentReport.php"><i class="ti-files"></i> Incident Report </a></li>
                    <li><a href="admin_message.php"><i class="ti-comment-alt"></i> Messages</a></li>
                    
                    
                    
                    <li><a href="admin_logout.php"><i class="ti-close"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /# sidebar -->

    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <div class="hamburger sidebar-toggle">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                    </div>
                    <div class="float-right">
                        <div class="dropdown dib">
                            <div class="header-icon" data-toggle="dropdown">
                                <i class="ti-bell">
                                    <span class="badge badge-danger" id="notification-badge">
                                    <?php
                                        if(isset($_SESSION['auth_user']['admin_id'])) {
                                            
                                            $adminID = $_SESSION['auth_user']['admin_id'];
                                            $unread = 'Unread';

                                            // Adjust your SQL query based on your database schema
                                            $total_unread = $db->adminsystemNOTIFICATION_COUNT($adminID, $unread);

                                            echo $total_unread;
                                        }
                                    ?>
                                    </span>
                                </i>
                                <div class="drop-down dropdown-menu dropdown-menu-right" style="position: absolute; transform: translate3d(-227px, -3px, 0px); top: 0px; left: 0px; will-change: transform; height: 300px; overflow: auto; border: 1px solid #ccc;">
                                    <div class="dropdown-content-heading">
                                        <span class="text-left">Recent Notifications</span>
                                    </div>
                                    <div class="dropdown-content-body">
                                        <ul>
                                        <li class="text-center">
                                                <a href="#" class="more-link" id="markASread"><i class="ti-email"></i> Mark all as read</a>
                                        </li>
                                        <?php
                                        if(isset($_SESSION['auth_user']['admin_id'])) {
                                            $coordinatorID = $_SESSION['auth_user']['admin_id'];
                                            
                                            // Adjust your SQL query based on your database schema
                                            $notifications = $db->adminsystemNOTIFICATION_Read_Unread($coordinatorID);
                                            
                                            foreach ($notifications as $notification) {
                                        ?>
                                                <li>
                                                    <a href="#">
                                                        <img class="pull-left m-r-10 avatar-img" src="<?php echo $notification['admin_profile_picture']; ?>" alt="" />
                                                        <div class="notification-content">
                                                            <small class="notification-timestamp pull-right"><?php echo $notification['logs_time']; ?></small>
                                                            <div class="notification-heading"><?php echo $notification['logs']; ?></div>
                                                            <div class="notification-text"><?php echo $notification['logs_date']; ?> <div class="notification-timestamp pull-right" id="unreadTORead"><?php echo $notification['status']; ?></div> </div>
                                                            
                                                        </div>
                                                    </a>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown dib">
                            <div class="header-icon" data-toggle="dropdown">
                                <i class="ti-email"></i>
                                <div class="drop-down dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-content-heading">
                                        <span class="text-left">2 New Messages</span>
                                        <a href="email.html">
                                            <i class="ti-pencil-alt pull-right"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-content-body">
                                        <ul>
                                            <li class="notification-unread">
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img"
                                                        src="images/avatar/1.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34
                                                            PM</small>
                                                        <div class="notification-heading">Michael Qin</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you
                                                            ...</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="notification-unread">
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img"
                                                        src="images/avatar/2.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34
                                                            PM</small>
                                                        <div class="notification-heading">Mr. John</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you
                                                            ...</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img"
                                                        src="images/avatar/3.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34
                                                            PM</small>
                                                        <div class="notification-heading">Michael Qin</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you
                                                            ...</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img"
                                                        src="images/avatar/2.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34
                                                            PM</small>
                                                        <div class="notification-heading">Mr. John</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you
                                                            ...</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="text-center">
                                                <a href="#" class="more-link">See All</a>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
    $(document).ready(function() {
        // Attach a click event handler to the bell icon
        $("#markASread").on("click", function() {
            // Send an AJAX request to mark notifications as read
            $.ajax({
                url: "mark_admin_notifications_as_read.php", // Replace with the correct URL
                type: "POST",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Update the notification count
                        notificationCount = 0;
                        notificationRead = 'Read';
                        $("#notification-badge").text(notificationCount);
                        $("#unreadTORead").text(notificationRead);

                        // Update the UI or reload notifications here
                        alert("Notifications marked as read");
                        // You can update the notifications without reloading the page here
                    } else {
                        alert("Failed to mark notifications as read");
                    }
                },
                error: function() {
                    alert("An error occurred while processing the request");
                }
            });
        });
    });
</script>
