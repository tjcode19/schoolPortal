<?php
    
include("../includes/login.inc.php");
    
        /* Initialize object  */
        $log = new login;
        $log->database();
if(isset($_REQUEST['event']) && ($_REQUEST['event']=="add_u")){
        $log->set_sqlstr("SELECT sms_units FROM school_calendar");
        $log->querydata();  
        $cre = $log->data[0];
        
        $newCre = $cre + $_REQUEST['amt']; 
        $log->set_sqlstr("UPDATE school_calendar SET sms_units = '".$newCre."'");
        $log->ex_scalar();
        echo $newCre;
}
else if(isset($_REQUEST['event']) && ($_REQUEST['event']=="sub_u")){
        $log->set_sqlstr("SELECT sms_units FROM school_calendar");
        $log->querydata();  
        $cre = $log->data[0];
        
        $newCre = $cre - $_REQUEST['amt']; 
        $log->set_sqlstr("UPDATE school_calendar SET sms_units = '".$newCre."'");
        $log->ex_scalar();
        echo $newCre;
}
else{
        $rec = "";
        /* Query database to get Parents Phone Number*/
        if($_POST['target'] == "parent"){
            $log->set_sqlstr("SELECT ParentPhone FROM student_data");
            $log->querydata();
            for($i = 0; $i < $log->no_rec; $i++){
                $rec .= ($i == 0)? $log->data[0]:", ".$log->data[0];
            } 
            if($_POST['rec'] != "") $rec.=", ".$_POST['rec'];
        }
        /* Query database to get Staff Phone Number*/
        else if($_POST['target'] == "staff"){
            $log->set_sqlstr("SELECT Phone FROM staff_data");
            $log->querydata();
            for($i = 0; $i < $log->no_rec; $i++){
                $rec .= ($i == 0)? $log->data[0]:", ".$log->data[0];
            }
             if($_POST['rec'] != "") $rec.=", ".$_POST['rec'];
        }
        else if($_POST['target'] == "none"){
            $rec =$_POST['rec'];
        }
        $rec1 = explode(", ", $rec);
        $tot_rec = count($rec1);
        $msg = $_POST['msg'];
        $s_id = $_POST['s_id'];
        //$rec .= $_POST['rec'];
        
        /* Query database to get Parents Phone Number*/
        $log->set_sqlstr("SELECT sms_units FROM school_calendar");
        $log->querydata();  
        $cre = $log->data[0];
        $len = strlen($msg);
        if($len <= 160) $used_units = 1;
        elseif($len > 160 & $len <= 320) $used_units = 2;
        elseif($len > 320 & $len <= 480) $used_units = 3;

        $used_units *= $tot_rec ;
        
        if($used_units <= $cre){
            if($_POST['target'] != ""){
               if($msg != ""){
                require_once ("sms_api.php");
                $log->set_sqlstr("SELECT * FROM gateway WHERE Status='1'");
                $log->querydata(); 


                $usern = trim($log->data['Username']);
                $pass = trim($log->data['Password']);
                $url = trim($log->data['URL']);   

                $mysms = new sms($usern, $pass, $url);
                $done = $mysms->send($rec, $s_id, $msg);

                //echo $done;
                $new_u = $cre - $used_units;

                 $log->set_sqlstr("UPDATE school_calendar SET sms_units = '".$new_u."'");
                 $log->ex_scalar();
               // return $done;
                 $response = 1;
                 $arr = array('r'=>$response, 'n'=>$new_u, 'u'=>$used_units);
                }
               else{
                    $response = 3;
                    $arr = array('r'=>$response);
               }
           }
           else{
               $response = 2;
               $arr = array('r'=>$response);
           } 
        }
        else{
           $response = 0; 
            $arr = array('r'=>$response);
        }
        echo json_encode($arr,JSON_FORCE_OBJECT);
}
?>