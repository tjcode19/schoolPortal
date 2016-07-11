<?php


include("../includes/login.inc.php");
$log = new login();
$log->database();

$log->set_sqlstr("SELECT * FROM schoolfees WHERE type='".$_POST['typ']."' AND class='".$_POST['class']."' AND session='".$_POST['session']."' AND term='".$_POST['term']."'"); 
	$log->querydata();
	
	if($log->no_rec > 0){
		$msg = 0;
	}
	
	else{
		$log->set_sqlstr("INSERT INTO schoolfees(type, amount, class, session, term) VALUES('".$_POST['typ'] ."','".$_POST['amount'] ."','".
		$_POST['class'] ."','".$_POST['session'] ."','".$_POST['term'] ."')");
		$log->ex_scalar();
		$msg = 1;
	}
	
	echo $msg;

?>