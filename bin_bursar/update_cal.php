<?php
include("../includes/login.inc.php");
$log = new login();
$log->database();
$lu = date("l, dS \of F Y");
    $log->set_sqlstr("UPDATE school_calendar SET Term='".$_POST['term']."',Session='".$_POST['sess']."',Events='".$_POST['event']. 
            "',Date='".$_POST['date']."',MidTerm='".$_POST['mid']."',FirstTerm='".$_POST['ftest']."',SecondTerm='".$_POST['stest'].
            "',ExamDay='".$_POST['eday']."',Assignment='".$_POST['ass']."',Third_test='".$_POST['t_test']."',Vac_day='".$_POST['vday'].
            "',NextTerm='".$_POST['nterm']."',LastUpdate='".$lu."' WHERE ID = '" . $_POST['id']. "'");
    $log->ex_scalar();
    
?>