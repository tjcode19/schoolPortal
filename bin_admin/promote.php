<?php

include("../includes/login.inc.php");

$log = new login();
$log->database();

    if($_REQUEST['promote'] != ""){
        
        $log->set_sqlstr("SELECT * FROM student_data WHERE Class = '". $_REQUEST['promote'] ."'");
        $log->querydata();    
		$new_class = $_REQUEST['promote'] -1;
        for($i = 0; $i < $log->no_rec; $i++){
            $log->set_sqlstr("UPDATE student_data SET class='".$new_class."' WHERE class = '" . $_REQUEST['promote'] . "'");
            $log->ex_scalar();
			$log->fetchdata();
        }
		$sta = 1;
    }
	else
	$sta = 0;
	
	echo $sta;
    
?>