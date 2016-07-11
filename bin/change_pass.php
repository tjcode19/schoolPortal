<?php

require_once ('../includes/login.inc.php');
//echo 1;

$log = new login;
$log->database();

$log->set_sqlstr("SELECT password FROM authentication WHERE id = '".$_SESSION['s_portal_id']."'");
$log->querydata();
    if($log->data[0] == md5($_POST['cp']) ){
        if($_POST['np'] == $_POST['cnp']){
            $log->set_sqlstr("UPDATE authentication SET password='".md5($_POST['np'])."' WHERE id = '".$_SESSION['s_portal_id']."'");
            $log->ex_scalar(); 
            $d = 1;
            }
            else $d = 0;
    } 
    else $d = 2;

echo $d;

?> 