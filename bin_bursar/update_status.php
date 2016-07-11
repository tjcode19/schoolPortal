<?php
include("../includes/login.inc.php");
$log = new login();
$log->database();
        $d = $_POST['sid'];        
        $ad = htmlspecialchars($_POST['col15'], ENT_QUOTES);
        $log->set_sqlstr("UPDATE status SET AttInClass ='" . $_POST['col'] . "', Punct='" . $_POST['col2'] . "', ClassAtt='" . $_POST['col3'] . 
                "', COA='" . $_POST['col4'] . "',Polite='" . $_POST['col5'] . "', Neatness='" . $_POST['col6'] . "', RelWStaff='" . $_POST['col7'] . 
                "', RelWstudent='" . $_POST['col8'] . "', Initiative='" . $_POST['col9'] . "', EmoStab='" . $_POST['col10'] . 
                "', AttToStu='" . $_POST['col11'] . "', AttToSch='" . $_POST['col12'] . "', ManSkill='" . $_POST['col13'] . 
                "', ClubSoc='" . $_POST['col14'] . "', TeacherRem='" . $ad . "' WHERE Username = '" . $_POST['sid'] . "'");
        $log->ex_scalar();
               
        echo $d;
?>