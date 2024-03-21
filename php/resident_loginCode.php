<?php 
	

include '../connection/config.php';
$db = new Database();

session_start();
error_reporting(0);
		
		if(isset($_POST['LogIn']))
		{
            
            
			$email = $_POST['residentEmail'];
			$password = md5($_POST['residentPword']);
			
			$stmt = $db->residentLogin($email, $password);
			        
				
		}

?>
