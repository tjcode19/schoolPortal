<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();
        $d = $_POST['id'];
        
        $ad = htmlspecialchars($_POST['address'], ENT_QUOTES);
        
        $log->set_sqlstr("UPDATE student_data SET last_name='" . $_POST['sname'] . "', first_name='" . $_POST['fname'] . "', other_name='" . $_POST['oname'] . 
				"', date_of_birth='" . $_POST['dob'] ."', parent_phone='" . $_POST['ph'] . "', residential_address ='" . $ad . "', blood_group='" . $_POST['bg'] . "', class='" . 
				$_POST['cl'] ."' , parent_email ='" . $_POST['email'] . "', height='" . $_POST['ht'] . "', parent_name='" . $_POST['pn'] . 
				"' WHERE id = '" . $_POST['id'] . "'");
        $log->ex_scalar();
        
        echo $d;
?>