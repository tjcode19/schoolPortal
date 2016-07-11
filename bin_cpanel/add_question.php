<?php
  include '../includes/login.inc.php';

$log = new login();
$log->database();
        
        $RN  = "QUE";
        $RN .= rand(0, 999999); 
        $log->set_sqlstr("INSERT INTO question_tab(ID, Question, Answer) VALUES " .
                "('" . $RN . "', '" . $_POST['Question'] . "','".$_POST['ans']."')");
        $log->ex_scalar();
        $log->set_sqlstr("INSERT INTO option_tab(Question_ID, Option1, Option2, Option3, Option4 ) VALUES('" . $RN . "', '" . $_POST['A1'] . 
                "','".$_POST['A2']."','" . $_POST['A3']. "','" . $_POST['A4'] . "')");
        $log->ex_scalar();
        
?>