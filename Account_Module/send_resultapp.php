     <?php
        include("../bin/getpos.php");
        function Grade($g){
                        return (($g >= 70)?"A":
                                (($g < 70 && $g >= 60)?"B":
                                (($g < 60 && $g >= 50)?"C":
                                (($g < 50 && $g >= 45)?"D":
                                (($g < 45 && $g >= 40?"E":"F"))))));
                    } 
                    
        function sendSMS($pn, $msg){
            // Query database to get Parents Phone Number
            $log = new login();
            $log->database(); 
            $log->set_sqlstr("SELECT sms_units FROM school_calendar");
            $log->querydata(); $cre = $log->data[0];
            
            $len = strlen($msg);
            if($len <= 160) $used_units = 1;
            elseif($len > 160 & $len <= 320) $used_units = 2;
            elseif($len > 320 & $len <= 480) $used_units = 3;

            $tot_rec = 1;
            $used_units *= $tot_rec ;

            if($used_units <= $cre){
                //select parent phone number and if its not empty
                if($pn != ""){
                   if($msg != ""){
                    require_once ("../bin/sms_api.php");
                    $log->set_sqlstr("SELECT * FROM gateway WHERE Status='1'");
                    $log->querydata();  

                    $usern = trim($log->data['Username']);
                    $pass = trim($log->data['Password']);
                    $url = trim($log->data['URL']);
                    $s_id = "ColonySchl";

                    $mysms = new sms($usern, $pass, $url);
                    $done = $mysms->send($pn, $s_id, $msg);

                    echo $done ."<br/>Results {".$msg."} Has been sent to Parents Mobile Number:".$pn."<br/>".$used_units."Unit(s) Used <br><br>";
                    $new_u = $cre - $used_units;

                    $log->set_sqlstr("UPDATE school_calendar SET sms_units = '".$new_u."'");
                    $log->ex_scalar();
                }
            }
            }
        }
                    
        $log = new login();  
        $rs = new login();  
        if($_REQUEST['t'] == "Third Term"){
        $log->database(); 
        $log->set_sqlstr("SELECT DISTINCT Username FROM result WHERE Class='".$_REQUEST['c'].
                            "' AND Term='".$_REQUEST['t']."' AND Session='".$_REQUEST['se']."' ORDER BY Course ASC");
        $log->querydata();
        for($stv = 0; $stv < $log->no_rec; $stv++){   
            $rs->database();
            $rs->set_sqlstr("SELECT * FROM student_data WHERE Username='".$log->data[0]."'");
            $rs->querydata();
            $msg = ($rs->data[1]." ".$rs->data[2]."\n");
            $msg .= $_REQUEST['t']."' of '".$_REQUEST['se']."\n";
            $xpn = explode(",", $rs->data[8]);
            $pn = $xpn[0];
            //echo "<br/>Results {".$msg."} Has been sent to Parents Mobile Number:".$pn."<br/>--- <br><br>";
            $rs->set_sqlstr("SELECT * FROM result WHERE Username='".$log->data[0]."' AND Class='".$_REQUEST['c'].
                        "' AND Term='".$_REQUEST['t']."' AND Session='".$_REQUEST['se']."' ORDER BY Course ASC");
            $rs->querydata(); 
            
            
            for($i = 0; $i < $rs->no_rec; $i++){            
            	$fs = fres($_REQUEST['se'], $log->data[0], $rs->data['Course']); 
            	$ss = sres($_REQUEST['se'], $log->data[0], $rs->data['Course']); 
                $ca = ($rs->data['CA1']+$rs->data['CA2']);
                $t = ($ca + $rs->data['Exam']);  
                $ts = ceil(($t+$fs+$ss)/3);              
                $msg.= (substr($rs->data['Course'],0,4). ": ".Grade($ts)."\n"); 
                $rs->fetchdata();
            }  
           
            sendSMS($pn, $msg); 
            $log->fetchdata(); 
        } 
        }
        else{
        $log->database(); 
        $log->set_sqlstr("SELECT DISTINCT Username FROM result WHERE Class='".$_REQUEST['c'].
                            "' AND Term='".$_REQUEST['t']."' AND Session='".$_REQUEST['se']."' ORDER BY Course ASC");
        $log->querydata();
        for($stv = 0; $stv < $log->no_rec; $stv++){   
            $rs->database();
            $rs->set_sqlstr("SELECT * FROM student_data WHERE Username='".$log->data[0]."'");
            $rs->querydata();
            $msg = ($rs->data[1]." ".$rs->data[2]."\n");
            $msg .= $_REQUEST['t']."' of '".$_REQUEST['se']."\n";
            $xpn = explode(",", $rs->data[8]);
            $pn = $xpn[0];
            //echo "<br/>Results {".$msg."} Has been sent to Parents Mobile Number:".$pn."<br/>--- <br><br>";
            $rs->set_sqlstr("SELECT * FROM result WHERE Username='".$log->data[0]."' AND Class='".$_REQUEST['c'].
                        "' AND Term='".$_REQUEST['t']."' AND Session='".$_REQUEST['se']."' ORDER BY Course ASC");
            $rs->querydata(); 
            for($i = 0; $i < $rs->no_rec; $i++){
                $ca = ($rs->data['CA1']+$rs->data['CA2']);
                $t = ($ca + $rs->data['Exam']);
                $msg.= (substr($rs->data['Course'],0,4). ": ".Grade($t)."\n"); 
                $rs->fetchdata();
            }  
           
            sendSMS($pn, $msg); 
            $log->fetchdata(); 
        } 
        }
 
?>
