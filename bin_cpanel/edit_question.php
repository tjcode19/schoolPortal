<?php
  include '../includes/login.inc.php';

$log = new login();
$log->database();
        
        $log->set_sqlstr("UPDATE question_tab SET Question='".$_POST['Question']."', Answer='".$_POST['ans']."' WHERE ID='".$_POST['id']."'");
        $log->ex_scalar();
        $log->set_sqlstr("UPDATE option_tab SET Option1='".$_POST['A1'] ."', Option2='".$_POST['A2']."', Option3='".$_POST['A3'].
                "', Option4='".$_POST['A4']."' WHERE Question_ID='".$_POST['id']."'");
        $log->ex_scalar();
        
?>