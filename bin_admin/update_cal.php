<?php
include("../includes/login.inc.php");
$log = new login();
$log->database();

	$log->set_sqlstr("SELECT * FROM calender WHERE event='".$_POST['event']."' AND session='".$_POST['session']."' AND term='".$_POST['term']."'"); 
	$log->querydata();
	
	if($log->no_rec > 0){
		$msg = 0;
	}
	else{
		$log->set_sqlstr("INSERT INTO calender(event, description, start_date, start_time, end_date, end_time,".
		" session, term) VALUES('".$_POST['event'] ."','".$_POST['det'] ."','".$_POST['stDate'] ."','".$_POST['stime'] ."','".$_POST['enDate'] .
		"','".$_POST['etime'] ."','".$_POST['session'] ."','".$_POST['term'] ."')");
		$log->ex_scalar();
		$msg = 1;
	}
    
?>