<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();
        $d = $_POST['id'];        
        $ad = htmlspecialchars($_POST['address'], ENT_QUOTES);
        
        $log->set_sqlstr("UPDATE staff_data SET first_name='" . $_POST['fname'] . "', title='" . $_POST['tit'] . "', date_of_birth='" . $_POST['dob'] . 
                "', phone='" . $_POST['ph'] . "', residential_address='" . $ad . "', position='" . $_POST['po'] . 
                "', blood_group='" . $_POST['bg'] . "', class_in_charge='" . $_POST['cl'] . "' , email='" . $_POST['email'] . 
                "', height='" . $_POST['ht'] . "', last_name='" . $_POST['lname'] . "', other_name='" . $_POST['oname'] . "' WHERE id = '" . $_POST['id'] . "'");
        $log->ex_scalar();
        
        echo $d;
?>