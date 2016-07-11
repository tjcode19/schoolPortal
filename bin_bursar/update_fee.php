<?php


include("../includes/login.inc.php");
$log = new login();
$log->database();

$id = $_POST['id'];
$amt = $_POST['amt'];

for($i=0; $i < count($id); $i++){

    $log->set_sqlstr("UPDATE school_fees SET Amount='" . $amt[$i] . "' WHERE ID = '" . $id[$i]. "'");
    $log->ex_scalar();
	
}
  

?>