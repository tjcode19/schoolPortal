<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();
        $d = $_POST['id'];
        $log->set_sqlstr("UPDATE emp_details SET ClassInCharge='" . $_POST['cl'] . "',YearOfEmp='" . $_POST['yemp'] . "',YearOfExp='" . $_POST['yexp'] . 
                "',Qualification='" . $_POST['ql'] . "' WHERE Username = '" . $_POST['id'] . "'");
        $log->ex_scalar();
        
        $ad = htmlspecialchars($_POST['address'], ENT_QUOTES);
        
        $log->set_sqlstr("UPDATE staff_data SET Fullname='" . $_POST['fname'] . "', Title='" . $_POST['tit'] . "', Age='" . $_POST['age'] . 
                "', Phone='" . $_POST['ph'] . "', Address='" . $ad . "'" .",Subjects='" . $_POST['sb'] . "', Position='" . $_POST['po'] . 
                "', BloodG='" . $_POST['bg'] . "', ClassInCharge='" . $_POST['cl'] . "' , Email='" . $_POST['email'] . 
                "', Height='" . $_POST['ht'] . "' WHERE Username = '" . $_POST['id'] . "'");
        $log->ex_scalar();
        
        echo $d;
?>