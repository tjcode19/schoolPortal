<?php

include("../../includes/login.inc.php");
$log = new login();
$log->database();


    $log->set_sqlstr("UPDATE authentication SET status='".$_POST['status']."' WHERE id =".$_POST['user']." AND status != 5");
    $log->ex_scalar(); 

    echo "success";
        
?>