<?php

require_once ('../includes/login.inc.php');
//echo 1;

 $log = new login;
 $log->database();
 
 if(isset($_POST['cp'])){
    $log->set_sqlstr("SELECT password FROM authentication WHERE id = '".$_SESSION['s_portal_id']."'");
    $log->querydata();
    if($log->data[0] == md5($_POST['cp'])){
        $d = 1;
    }
    else $d=0;
 }
echo $d;

?> 