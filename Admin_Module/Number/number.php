<!doctype html> 
<?php
    include("../../includes/login.inc.php");
    include("../../includes/linker.php");
    $log = new login;	
    $log->database();
	
    $log->set_sqlstr("SELECT parent_phone FROM student_data"); 
    $log->querydata();
	$rec = "";
	for($i = 0; $i < $log->no_rec; $i++){
                $rec .= ($i == 0)? $log->data[0]:", ".$log->data[0];
				$log->fetchdata();
		}
			
			echo $rec;