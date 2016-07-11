<?php


include("../includes/login.inc.php");
$log = new login();
$log->database();

if($_POST['type']!=""){
    $sql = "INSERT INTO schoolfeetype(Name) VALUES ('" . $_POST['type'] . "')";
    $log->set_sqlstr($sql);
        $log->ex_scalar();
        $d = 1;
    }

echo $d;

?>