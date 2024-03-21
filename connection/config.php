<?php 

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Database {
  private $servername = "localhost";
  private $username = "root";
  private $password = "";
  private $database = "barangay_incident";
  private $conn;

  public function __construct() {
      try {
          $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      } catch(PDOException $e) {
          // Handle the exception here if needed
      }
  }

  public function getConnection() {
      return $this->conn;
  }

  //------------------------------------------------------------ADMIN PAGE CODE----------------------------------------------//


   //--------------------------------------------------------------------------------ADMIN REGISTER
  public function admin_register_select_email($email) {
    $connection = $this->getConnection();

    $stmt = $connection->prepare("SELECT * FROM admin_account WHERE admin_email = ?");
    $stmt->execute([$email]);
    $result = $stmt->fetch(); # get user data

    return $result;
}

public function admin_register_select_phoneNumber($PhoneNumber) {
  $connection = $this->getConnection();

  $stmt = $connection->prepare("SELECT * FROM admin_account WHERE phone_number = ?");
  $stmt->execute([$PhoneNumber]);
  $result = $stmt->fetch(); # get user data

  return $result;
}

public function admin_register_INSERT_Info($uniqueId, $first_name, $middle_name, $last_name, $CompleteAddress, $PhoneNumber, $email, $pword, $imagePath, $verification_code, $longitude, $latitude) {
  $connection = $this->getConnection();

  $sql = $connection->prepare("INSERT INTO admin_account(uniqueID, first_name, middle_name, last_name, complete_address, phone_number, admin_email, admin_password, admin_profile_picture, verification_code, longitude, latitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $sql->execute([$uniqueId, $first_name, $middle_name, $last_name, $CompleteAddress, $PhoneNumber, $email, $pword, $imagePath, $verification_code, $longitude, $latitude]);

}

public function admin_update_verify_status($verified, $adminID) {
  $connection = $this->getConnection();

  $stmt = $connection->prepare("UPDATE admin_account SET verify_status=? WHERE id=?");
  $stmt->execute([$verified, $adminID]);

}


  //------------------------------------------------------------------------------------------------------ADMIN LOGIN
  public function adminLogin($email, $password) {
    $connection = $this->getConnection();

    $stmt = $connection->prepare("SELECT * FROM admin_account WHERE admin_email=? AND admin_password=? ");
    $stmt->execute([$email, $password]);

    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $admin_id = $data['id'];
        $admin_UNIQUEid = $data['uniqueID'];
        $pword = $data['admin_password'];
        $longitude = $data['longitude'];
        $latitude = $data['latitude'];
        $verifystatus = $data['verify_status'];
        $email = $data['admin_email'];
    }

    if ($pword == $password) {
        if ($verifystatus == 'Not Verified') {
            // Handle account verification if needed
            $_SESSION['alert'] = "Account Verification";
            $_SESSION['status'] = "Verify your Account";
            $_SESSION['status-code'] = "info";
            header("location: ../adminsystem/admin_verify_account.php?id=$admin_id");
        } else {
            // Handle successful login
            date_default_timezone_set('Asia/Manila');
            $date = date('F / d l / Y');
            $time = date('g:i A');
            $logs = 'You successfully logged in to your account.';
            $online_offline_status = 'Online';

            $sql = $connection->prepare("INSERT INTO admin_systemnotification(admin_id, logs, logs_date, logs_time) VALUES (?, ?, ?, ?)");
            $sql->execute([$admin_id, $logs, $date, $time]);

            $sql2 = $connection->prepare("UPDATE admin_account SET online_offlineStatus = ? WHERE id = ?");
            $sql2->execute([$online_offline_status, $admin_id]);

            $_SESSION['auth'] = true;
            $_SESSION['auth_user'] = [
                'admin_id' => $admin_id,
                'admin_uniqueID' => $admin_UNIQUEid,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'email' => $email,
            ];

            $_SESSION['alert'] = "Success";
            $_SESSION['status'] = "Log In Success";
            $_SESSION['status-code'] = "success";
            header("location: ../adminsystem/dashboard.php");
        }
    } else {
        // Handle incorrect login details
        $_SESSION['alert'] = "Oppss...";
        $_SESSION['status'] = "Incorrect Log In Details";
        $_SESSION['status-code'] = "info";
        header("location: ../adminsystem/index.php");
    }
}

//------------------------------------------------------------------------------------------------------ADMIN LOGOUT_UPDATE TO OFFLINE
public function updateADMIN_OFFLINE($online_offline_status, $admin_id) {
  $connection = $this->getConnection();

  $sql2 = $connection->prepare("UPDATE admin_account SET online_offlineStatus = ? WHERE id = ?");
  $sql2->execute([$online_offline_status, $admin_id]);

}


//NOTIFICATION COUNT
public function adminsystemNOTIFICATION_COUNT($adminID, $unread) {
  $connection = $this->getConnection();

  $stmt = $connection->prepare("SELECT COUNT(*) AS total_unread FROM admin_systemnotification WHERE admin_id = ? AND status = ?");
    $stmt->execute([$adminID, $unread]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalUnread = $result['total_unread'];

    echo $totalUnread;

}


//ALL READ, UNREAD NOTIFICATIONS
public function adminsystemNOTIFICATION_Read_Unread($coordinatorID) {
  $connection = $this->getConnection();

      $stmt = $connection->prepare("SELECT * FROM admin_systemnotification LEFT JOIN admin_account ON admin_account.id = admin_systemnotification.admin_id WHERE admin_systemnotification.admin_id = ? ORDER BY admin_systemnotification.id DESC");
        $stmt->execute([$coordinatorID]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $notifications; // Add this line to return the notifications

}

//MARK ALL NOTIFICATIONS AS READ
public function adminsystemNOTIFICATION_MarkASRead($read, $admin_id) {
  $connection = $this->getConnection();

  $stmt = $connection->prepare("UPDATE admin_systemnotification SET status = ? WHERE admin_id = ?");
  $stmt->execute([$read, $admin_id]);

}

//INSERT ADMIN NOTIFICATIONS QUERIES
public function adminsystem_INSERT_NOTIFICATION($ID, $logs, $date, $time) {
  $connection = $this->getConnection();

  $sql = $connection->prepare("INSERT INTO admin_systemnotification(admin_id, logs, logs_date, logs_time) VALUES (?, ?, ?, ?)");
  $sql->execute([$ID, $logs, $date, $time]);

}

public function adminsystem_INSERT_NOTIFICATION_2($admin_id, $logs, $date, $time) {
  $connection = $this->getConnection();

  $sql2 = $connection->prepare("INSERT INTO admin_systemnotification(admin_id, logs, logs_date, logs_time) VALUES (?, ?, ?, ?)");
  $sql2->execute([$admin_id, $logs, $date, $time]);

}

public function adminsystem_INSERT_NOTIFICATION_3($adminID, $logs, $date, $time) {
  $connection = $this->getConnection();

  $sql2 = $connection->prepare("INSERT INTO admin_systemnotification(admin_id, logs, logs_date, logs_time) VALUES (?, ?, ?, ?)");
  $sql2->execute([$adminID, $logs, $date, $time]);

}
//END INSERT ADMIN NOTIFICATIONS QUERIES



public function adminsystemBARANGAY_MAP($id) {
  $connection = $this->getConnection();

  $sql = $connection->prepare("SELECT * FROM admin_account WHERE id = ?");
  $sql->execute([$id]);
  $row = $sql->fetch(PDO::FETCH_ASSOC);

  return $row;

}


public function adminsystem_UPDATE_BARANGAY_MAP($LONGITUDE, $LATITUDE, $ID) {
  $connection = $this->getConnection();

  $sql = $connection->prepare("UPDATE admin_account SET longitude = ?, latitude = ? WHERE id = ?");
  $sql->execute([$LONGITUDE, $LATITUDE, $ID]);

}


public function admin_profile($adminID) {
  $connection = $this->getConnection();

  $stmt = $connection->prepare("SELECT * FROM admin_account WHERE id = ? ");
	$stmt->execute([$adminID]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  return $result;

}

public function SELECT_admin_profile($admin_id) {
  $connection = $this->getConnection();

  $sql = $connection->prepare("SELECT admin_profile_picture FROM admin_account WHERE id = ? ");
  $sql->execute([$admin_id]);
  $row = $sql->fetch(PDO::FETCH_ASSOC);
  $result = $row['admin_profile_picture'];

  return $result;

}

public function UPDATE_admin_profile($imagePath, $admin_id) {
  $connection = $this->getConnection();

  $sql = $connection->prepare("UPDATE admin_account SET admin_profile_picture = ? WHERE id = ?");
  $result = $sql->execute([$imagePath, $admin_id]);

  return $result;

}


public function UPDATE_admin_info_onSETTINGS($fname, $mname, $lname, $c_address, $cp_number, $adminID) {
  $connection = $this->getConnection();

  $stmt = $connection->prepare("UPDATE admin_account SET first_name=?, middle_name=?, last_name=?, complete_address=?, phone_number=? WHERE id=?");
  $result = $stmt->execute([$fname, $mname, $lname, $c_address, $cp_number, $adminID]);

  return $result;

}


public function UPDATE_admin_password($npword, $adminID) {
  $connection = $this->getConnection();

  $stmt = $connection->prepare("UPDATE admin_account SET admin_password = ? WHERE id=?");
  $result = $stmt->execute([$npword, $adminID]);

  return $result;

}



public function SELECT_ALL_INCIDENT_REPORT($report_status='Pending'){
  $connection = $this->getConnection();
  $stmt = $connection->prepare("SELECT *, residents_data.id AS residentID, incident_reports.id AS reportID 
  FROM incident_reports 
  LEFT JOIN residents_data
  ON residents_data.id = incident_reports.resident_id
  WHERE (incident_reports.report_status = ?)

  order by incident_reports.timeOfSubmit DESC
  
  ");
  $stmt->execute([$report_status]);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $result;
}

public function VIEW_RESIDENT_INCIDENT_REPORT($residentID){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM incident_reports LEFT JOIN residents_data ON residents_data.id = incident_reports.resident_id WHERE residents_data.id = ?");
  $stmt->execute([$residentID]);
  $data = $stmt->fetch(PDO::FETCH_ASSOC);

  return $data;
}

public function VIEW_RESIDENT_INCIDENT_REPORT_2($reportID){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM incident_reports WHERE id = ? ");
  $stmt->execute([$reportID]);
  $data = $stmt->fetch(PDO::FETCH_ASSOC);

  return $data;
}

public function COUNT_REPORTS($resident_id){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT COUNT(*) FROM incident_reports WHERE resident_id = ? ");
  $stmt->execute([$resident_id]);
  $data = $stmt->fetchColumn();

  return $data;
}

public function COUNT_ALL_REPORTS(){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT COUNT(*) FROM incident_reports ");
  $stmt->execute();
  $data = $stmt->fetchColumn();

  return $data;
}

public function COUNT_ALL_REPORTS_WHERE_PENDING(){
  $connection = $this->getConnection();
  $status = 'Pending';
  $stmt = $connection->prepare("SELECT COUNT(*) FROM incident_reports WHERE report_status = ? ");
  $stmt->execute([$status]);
  $data = $stmt->fetchColumn();

  return $data;
}

public function COUNT_REPORTS_APRROVED($resident_id){
  $connection = $this->getConnection();

  $status = 'Approved';
  
  $stmt = $connection->prepare("SELECT COUNT(*) FROM incident_reports WHERE resident_id = ? AND report_status = ? ");
  $stmt->execute([$resident_id, $status]);
  $data = $stmt->fetchColumn();

  return $data;
}

public function COUNT_REPORTS_REJECT($resident_id){
  $connection = $this->getConnection();

  $status = 'Rejected';
  
  $stmt = $connection->prepare("SELECT COUNT(*) FROM incident_reports WHERE resident_id = ? AND report_status = ? ");
  $stmt->execute([$resident_id, $status]);
  $data = $stmt->fetchColumn();

  return $data;
}

public function UPDATE_INCIDENT_REPORT($status, $reportID, $remarks = 'Done'){
  $connection = $this->getConnection();
  
  $sql = $connection->prepare("
  UPDATE incident_reports SET 
  report_status = ? , 
  remarks = ?
  WHERE id = ?");
  $sql->execute([$status, $remarks, $reportID]);
}


public function selectALL_CALAMITY_INCIDENT(){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM calamities");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $results;
}


public function selectALL_RESIDENTS_DATA(){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM residents_data");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $results;
}

public function count_NewMessages($receiverId, $status){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT COUNT(*) AS new_message_count FROM chat_system WHERE sender_id = ? AND status = ?");
  $stmt->execute([$receiverId, $status]);
  $results = $stmt->fetch(PDO::FETCH_ASSOC);

  return $results;
}

public function admin_messageLIVECHAT_selected_receiver($uniqueId_receiver){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM residents_data WHERE uniqueID = ?");
  $stmt->execute([$uniqueId_receiver]);
  $results = $stmt->fetch(PDO::FETCH_ASSOC);

  return $results;
}

public function admin_messageLIVECHAT_sender_receiver($senderId, $receiverId){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM chat_system
  LEFT JOIN admin_account ON admin_account.uniqueID = chat_system.sender_id
  LEFT JOIN residents_data ON residents_data.uniqueID = chat_system.sender_id
  WHERE (chat_system.sender_id = ? AND chat_system.receiver_id = ?) OR (chat_system.sender_id = ? AND chat_system.receiver_id = ?)
  ORDER BY chat_system.id ASC");

  $stmt->execute([$senderId, $receiverId, $receiverId, $senderId]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $results;
}

public function admin_message_markAS_seen($message_status, $receiverId){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("UPDATE chat_system SET status = ? WHERE sender_id = ?");
  $stmt->execute([$message_status, $receiverId]);
  $results = $stmt->fetch(PDO::FETCH_ASSOC);

  return $results;
}

public function adminSEND_message_toUSERchat($senderId, $receiverId, $message, $date, $time){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("INSERT INTO chat_system (sender_id, receiver_id, messages, date_only, time_only) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$senderId, $receiverId, $message, $date, $time]);
}




  //------------------------------------------------------------RESIDENT PAGE CODE----------------------------------------------//


  //-----------------------------------------------------------------RESIDENT DATA
  public function resident_data($residentID){
    $connection = $this->getConnection();

    $stmt = $connection->prepare("SELECT * FROM residents_data WHERE id= ?");
    $stmt->execute([$residentID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
  }

  public function SELECT_ALL_LOOP_resident_data($residentID){
    $connection = $this->getConnection();

    $stmt = $connection->prepare("SELECT * FROM residents_data WHERE id != ?");
    $stmt->execute([$residentID]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }



  public function resident_email($email){
    $connection = $this->getConnection();

    $stmt = $connection->prepare("SELECT * FROM residents_data WHERE resident_email = ?");
    $stmt->execute([$email]);
    $result = $stmt->fetch(); # get user data

    return $result;
  }

  public function resident_phoneNUMBER($PhoneNumber){
    $connection = $this->getConnection();

    $stmt = $connection->prepare("SELECT * FROM residents_data WHERE phone_number = ?");
    $stmt->execute([$PhoneNumber]);
    $result = $stmt->fetch(); # get user data

    return $result;
  }


  public function resident_REGISTER_INSERT($uniqueId, $first_name, $middle_name, $last_name, $bDay, $age, $gender, $CompleteAddress, $PhoneNumber, $email, $pword, $imagePath, $verification_code, $latitude, $longitude){
    $connection = $this->getConnection();

    $sql = $connection->prepare("INSERT INTO residents_data(uniqueID, first_name, middle_name, last_name, b_day, age, gender, complete_address, phone_number, resident_email, resident_password, profile_picture, verification_code, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->execute([$uniqueId, $first_name, $middle_name, $last_name, $bDay, $age, $gender, $CompleteAddress, $PhoneNumber, $email, $pword, $imagePath, $verification_code, $latitude, $longitude]);

  }

public function UPDATEresident_data_verify_status($verified, $residentID){
  $connection = $this->getConnection();

  $stmt = $connection->prepare("UPDATE residents_data SET verify_status=? WHERE id=?");
  $stmt->execute([$verified, $residentID]);

}

//------------------------------------------------------------------------------------------------------RESIDENT LOGIN
public function residentLogin($email, $password) {
  $connection = $this->getConnection();

  $stmt = $connection->prepare("SELECT * FROM residents_data WHERE resident_email=? AND resident_password=? ");
			$stmt->execute([$email, $password]);
			while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$resident_id = $data['id'];
						$resident_UNIQUEid = $data['uniqueID'];
                        $pword = $data['resident_password'];
						$verifystatus = $data['verify_status'];
            $email = $data['resident_email'];
					}

					$_SESSION['auth'] = true;
					$_SESSION['auth_user'] = [
             'email' => $email,
						'resident_id' => $resident_id,
						'resident_uniqueID' => $resident_UNIQUEid,
					];


			         if($pword == $password)
			         {

			         	if ($verifystatus == 'Not Verified') {

                            $_SESSION['alert'] = "Account Verification";
							$_SESSION['status'] = "Verify your Account";
							$_SESSION['status-code'] = "info";
							header("location: ../resident/resident_verify_account.php?id=$resident_id");
							}else{

							date_default_timezone_set('Asia/Manila');
							$date = date('F / d l / Y');
							$time = date('g:i A');
							$logs = 'You successfully logged in to your account.';
							$online_offline_status = 'Online';

							$sql = $connection->prepare("INSERT INTO system_notification(resident_id, logs, logs_date, logs_time) VALUES (?, ?, ?, ?)");
            				$sql->execute([$resident_id, $logs, $date, $time]);

							$sql2 = $connection->prepare("UPDATE residents_data SET online_offlineStatus = ? WHERE id = ?");
            	$sql2->execute([$online_offline_status, $resident_id]);


              $_SESSION['alert'] = "Success";
							$_SESSION['status'] = "Log In Success";
							$_SESSION['status-code'] = "success";
							header("location: ../resident/dashboard.php");
				        
				       
			        	 }
			         }else{           
                  $_SESSION['alert'] = "Oppss...";
	        				$_SESSION['status'] = "Incorrect Log In Details";
							    $_SESSION['status-code'] = "info";
		        			header("location: ../resident/index.php");
	        			}
}

public function resident_data_CountNotification($residentID, $unread){
  $connection = $this->getConnection();

    $stmt = $connection->prepare("SELECT COUNT(*) AS total_unread FROM system_notification WHERE resident_id = ? AND status = ?");
    $stmt->execute([$residentID, $unread]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;

}



public function resident_data_Notification($residentID){
  $connection = $this->getConnection();

  $stmt = $connection->prepare("SELECT * FROM system_notification LEFT JOIN residents_data ON residents_data.id = system_notification.resident_id WHERE system_notification.resident_id = ? ORDER BY system_notification.id DESC");
  $stmt->execute([$residentID]);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;

}

public function resident_data_Notification_markASread($read, $residentID){
  $connection = $this->getConnection();

  $stmt = $connection->prepare("UPDATE system_notification SET status = ? WHERE resident_id = ?");
  $stmt->execute([$read, $residentID]);

}

public function resident_data_InsertNotification($residentID, $logs, $date, $time){
  $connection = $this->getConnection();

  $sql = $connection->prepare("INSERT INTO system_notification(resident_id, logs, logs_date, logs_time) VALUES (?, ?, ?, ?)");
  $sql->execute([$residentID, $logs, $date, $time]);

}

public function UPDATE_resident_data_Online_Offline($online_offline_status, $residentID){
  $connection = $this->getConnection();

  $sql2 = $connection->prepare("UPDATE residents_data SET online_offlineStatus = ? WHERE id = ?");
  $sql2->execute([$online_offline_status, $residentID]);

}

public function UPDATE_resident_data_Profile($imagePath, $residentID){
  $connection = $this->getConnection();

  $sql = $connection->prepare("UPDATE residents_data SET profile_picture = ? WHERE id = ?");
  $result = $sql->execute([$imagePath, $residentID]);

  return $result;
}


public function UPDATE_resident_data_Information($fname, $mname, $lname, $c_address, $cp_number, $residentID){
  $connection = $this->getConnection();

  $stmt = $connection->prepare("UPDATE residents_data SET first_name=?, middle_name=?, last_name=?, complete_address=?, phone_number=? WHERE id=?");
  $result = $stmt->execute([$fname, $mname, $lname, $c_address, $cp_number, $residentID]);

  return $result;
}

public function UPDATE_resident_data_password($npword, $residentID){
  $connection = $this->getConnection();

  $stmt = $connection->prepare("UPDATE residents_data SET resident_password = ? WHERE id=?");
  $result = $stmt->execute([$npword, $residentID]);

  return $result;
}

public function COUNT_ALL_RESIDENTS(){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT COUNT(*) FROM residents_data ");
  $stmt->execute();
  $data = $stmt->fetchColumn();

  return $data;
}

public function GET_UPDATE_resident_data_location_ONreport_incident($LONGITUDE, $LATITUDE, $residentID){
  $connection = $this->getConnection();

  $sql = $connection->prepare("UPDATE residents_data SET longitude = ?, latitude = ? WHERE id = ?");
  $sql->execute([$LONGITUDE, $LATITUDE, $residentID]);

}


public function submit_report_resident_data($residentID, $date, $time, $month, $calamity_incident, $DESCRIPTION, $imagePath, $longitude, $latitude,$status,$reason , $analysisHelp){
  $connection = $this->getConnection();

  $sql2 = $connection->prepare("INSERT INTO 
  incident_reports(resident_id, dateOFSubmit, timeOFSubmit, monthOfSubmit, calamities_incident, 
  description, incident_picture, longitude, latitude,  
  report_status,
  approval_remarks,
  reason,
  analysisHelp
  ) 
  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $result = $sql2->execute([$residentID, $date, 
  $time, $month, $calamity_incident, $DESCRIPTION,
   $imagePath, $longitude, $latitude, $status , $reason,   $reason, $analysisHelp]);

  return $result;
}

public function SELECT_ALL_incidentREPORTS_resident_data($residentID){
  $connection = $this->getConnection();

  $stmt = $connection->prepare("SELECT * FROM incident_reports WHERE resident_id = ?");
  $stmt->execute([$residentID]);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  

  return $result;
}

public function incidentREPORTS_graph() {
  $connection = $this->getConnection();
  $sql = $connection->prepare("SELECT monthOfSubmit, calamities_incident, COUNT(calamities_incident) AS Incident_Calamity FROM incident_reports GROUP BY monthOfSubmit ORDER BY id asc");
  $sql->execute();
  $result = $sql->fetchAll(PDO::FETCH_ASSOC);

  return $result;
}

public function incidentREPORTS_graph_2() {
  $connection = $this->getConnection();
  $sql = $connection->prepare("SELECT calamities_incident, dateOFSubmit, COUNT(calamities_incident) AS Incident_Calamity
  FROM incident_reports GROUP BY calamities_incident ORDER BY id asc;");
  $sql->execute();
  $result = $sql->fetchAll(PDO::FETCH_ASSOC);

  return $result;
}


public function SELECT_ALL_incidentREPORTS_Trending(){
  $connection = $this->getConnection();

  $stmt = $connection->prepare("SELECT calamities_incident, COUNT(calamities_incident) AS count_calamities_incident FROM incident_reports GROUP BY calamities_incident ORDER BY COUNT(calamities_incident) DESC LIMIT 1");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  

  return $result;
}

public function count_new_messages_residents_data($receiverId, $status){
  $connection = $this->getConnection();

  $stmt = $connection->prepare("SELECT COUNT(*) AS new_message_count FROM chat_system WHERE sender_id = ? AND status = ?");
  $stmt->execute([$receiverId, $status]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  

  return $result;
}

public function resident_messageLIVECHAT_selected_receiver($uniqueId_receiver){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM residents_data WHERE uniqueID = ?");
  $stmt->execute([$uniqueId_receiver]);
  $results = $stmt->fetch(PDO::FETCH_ASSOC);

  return $results;
}

public function show_messages($senderId, $receiverId){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM chat_system LEFT JOIN residents_data ON residents_data.uniqueID = chat_system.sender_id WHERE (chat_system.sender_id = ? AND chat_system.receiver_id = ?) OR (chat_system.sender_id = ? AND chat_system.receiver_id = ?) ORDER BY chat_system.id ASC");
  $stmt->execute([$senderId, $receiverId, $receiverId, $senderId]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $results;
}

public function resident_message_markAS_seen($message_status, $receiverId){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("UPDATE chat_system SET status = ? WHERE sender_id = ?");
  $stmt->execute([$message_status, $receiverId]);
  $results = $stmt->fetch(PDO::FETCH_ASSOC);

  return $results;
}

public function residentSEND_message_toUSERchat($senderId, $receiverId, $message, $date, $time){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("INSERT INTO chat_system (sender_id, receiver_id, messages, date_only, time_only) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$senderId, $receiverId, $message, $date, $time]);
}


public function SelectAll_Admin(){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM admin_account");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $results;
}


public function Select_Admin_OnChat($uniqueId_receiver){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM admin_account WHERE uniqueID = ?");
  $stmt->execute([$uniqueId_receiver]);
  $results = $stmt->fetch(PDO::FETCH_ASSOC);

  return $results;
}

public function showMessages_Admin_OnChat($senderId, $receiverId){
  $connection = $this->getConnection();
  
  $stmt = $connection->prepare("SELECT * FROM chat_system
  LEFT JOIN residents_data ON residents_data.uniqueID = chat_system.sender_id
  LEFT JOIN admin_account ON admin_account.uniqueID = chat_system.sender_id
  WHERE (chat_system.sender_id = ? AND chat_system.receiver_id = ?) OR (chat_system.sender_id = ? AND chat_system.receiver_id = ?)
  ORDER BY chat_system.id ASC");
  $stmt->execute([$senderId, $receiverId, $receiverId, $senderId]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $results;
}



}

?>