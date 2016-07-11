<?php

include("../includes/login.inc.php");

$log = new login();
$log->database();
    if($_REQUEST['promote'] != "SS THREE"){
        $log->set_sqlstr("SELECT Id FROM class WHERE Name = '". $_REQUEST['promote'] ."'");
        $log->querydata();
        $nc = $log->data[0] + 1;
        $log->set_sqlstr("SELECT Name FROM class WHERE Id = '". $nc."'");
        $log->querydata();
        $cl = $log->data[0];
        $log->set_sqlstr("SELECT * FROM student_data WHERE Class = '". $_REQUEST['promote'] ."'");
        $log->querydata();        
        for($i = 0; $i < $log->no_rec; $i++){
            $log->set_sqlstr("UPDATE student_data SET Class='".$cl."' WHERE Class = '" . $_REQUEST['promote'] . "'");
            $log->ex_scalar();
        }
    }
    else{
        $cl = "ALUMNI";
        $log->set_sqlstr("SELECT * FROM student_data WHERE Class = '". $_REQUEST['promote'] ."'");
        $log->querydata();        
        for($i = 0; $i < $log->no_rec; $i++){
            $log->set_sqlstr("UPDATE student_data SET Class='".$cl."' WHERE Class = '" . $_REQUEST['promote'] . "'");
            $log->ex_scalar();
        }
    }

?>