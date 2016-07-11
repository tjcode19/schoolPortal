<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();
        $d = $_POST['id'];
        $log->set_sqlstr("UPDATE admission_details SET PresentClass='" . $_POST['cl'] . "',YearOfAdmission='" . $_POST['yamd'] . "',YearOfGraduation='" . $_POST['yog'] . 
                "',ExtraActivity='" . $_POST['ex'] . "',PositionInClass='" . $_POST['po'] . "' WHERE Username = '" . $_POST['id'] . "'");
        $log->ex_scalar();
        
        $ad = htmlspecialchars($_POST['address'], ENT_QUOTES);
        
        $log->set_sqlstr("UPDATE student_data SET Surname='" . $_POST['sname'] . "', Firstname='" . $_POST['fname'] . "', Other='" . $_POST['oname'] . "', Age='" . $_POST['age'] . 
                "', ParentPhone='" . $_POST['ph'] . "', Address='" . $ad . "', BloodG='" . $_POST['bg'] . "', Class='" . $_POST['cl'] . 
                "' , Email='" . $_POST['email'] . "', Height='" . $_POST['ht'] . "', ParentName='" . $_POST['pn'] . "' WHERE Username = '" . $_POST['id'] . "'");
        $log->ex_scalar();
        
        echo $d;
?>