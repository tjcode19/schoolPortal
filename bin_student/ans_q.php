<?php
  include '../includes/login.inc.php';

    $log = new login();
    $log->database();

    $log->set_sqlstr("SELECT Question, Answer FROM question_tab WHERE ID='".$_REQUEST['id']."'");
    $log->querydata();
    $ques = $log->data[0];
    
    $log->set_sqlstr("SELECT Week FROM quiz_tab WHERE Question_ID='".$_REQUEST['id']."'");
    $log->querydata();
    $week = $log->data[0];
    
    $log->set_sqlstr("SELECT Session FROM school_calendar");
    $log->querydata();
    $sess = $log->data[0];
    
    $d = date("d-m-Y");
    $t = date("H:i:s");
        
        $log->set_sqlstr("INSERT INTO answer_tab(Username, Question_ID, Answer, Week, Session, Date, Time) VALUES " .
                "('".$_REQUEST['user']."', '".$_REQUEST['id']."','".$_REQUEST['opt']."','".$week."', '".$sess."','".$d."', '".$t."')");
        $log->ex_scalar();
        
?>