<?php
include("../includes/login.inc.php");
function getStudPos($std_id, $ses, $ter, $cla){
    $log = new login();  $log2 = new login();
    //$std_id="SD20080001"; $ses="2012/2013"; $ter="Second Term"; $cla="SS TWO"; 
    //var to store stud_id and their score
    $stdlst = array(array());
    //var to monitor stud position
    $pos = 1; 
    //var to store stud score
    $scr = 0; 
	
    
    //get list of all student in same session, class and term
    $log->database();
    $log->set_sqlstr("SELECT DISTINCT(`student_id`) FROM result WHERE "
            ." (`session` = '" . $ses . "') AND    (`class` = '" . $cla . "') AND (`term` = '" . $ter . "') ORDER BY `student_id` DESC");
    $log->querydata();                        
    for($i=0; $i < $log->no_rec; $i++){  
        
        //gets score for each student
        $log2->database();
        $log2->set_sqlstr("SELECT SUM((`ca1` + `ca2` + `ca3` + `exam`)) AS score "
            ." FROM result WHERE (`student_id` = '".$log->data[0]."') AND (`session` = '" . $ses . "') AND (`term` = '" . $ter . "')"); 	
        $log2->querydata();
        //$stdlst[$log->data[0]] = $log2->data[0];  
        //echo $log->data[0].":".$stdlst[$log->data[0]] ."<br>";
        //store student id and its score in the array
        $stdlst[$i][0] = $log->data[0]; $stdlst[$i][1] = $log2->data[0];
        if($log->data[0] == $std_id){
            $scr = $stdlst[$i][1] ;  
        }
        //echo $stdlst[$i][0].":". $stdlst[$i][1] ."<br>";     
        
        //fetch next student's record
        $log->fetchdata();
    } 
       
    
    for ($index = 0; $index < count($stdlst); $index++) {
        //increase student position if there is another student that scores higher
        $pos += ( ($scr < $stdlst[$index][1] )  ? 1: 0 );    
    }
    
    //echo $pos;
    $pos .= (($pos==1)?"ST":
            (($pos==2)?"ND":
            (($pos==3)?"RD":"TH")));
    return $pos;
             
}

//(CA1 + CA2 + Exam) AS Score

function getCoursePos($std_id, $ses, $ter, $cla, $cou){
    $log = new login(); 
    //$std_id="SD20080001"; $ses="2012/2013"; $ter="Second Term"; $cla="SS TWO"; 
    //var to store stud_id and their score
    $stdlst = array(array());
    //var to monitor stud position
    $pos = 1; 
    //var to store stud score
    $scr = 0; 
    $ascr = 0; 
    //get list of all student and thier score in same session, class and term
    $log->database();
    $log->set_sqlstr("SELECT `student_id`, (ca1 + ca2 + ca3 + exam) AS Score FROM result WHERE "
            ." (`session` = '" . $ses . "') AND    (`class` = '" . $cla . "') AND (`term` = '" 
            . $ter . "') AND (`subject` = '" . $cou . "') ORDER BY `student_id` DESC");
    $log->querydata();                        
    for($i=0; $i < $log->no_rec; $i++){    
        //store student id and its score in the array
        $stdlst[$i][0] = $log->data[0]; $stdlst[$i][1] = $log->data[1];
        if($log->data[0] == $std_id){
            $scr = $stdlst[$i][1] ; 
				//$ascr = $scr;			
        }  
		$ascr += $log->data[1];	
		
        //fetch next student's record
        $log->fetchdata();
    } 
       
    
    for ($index = 0; $index < count($stdlst); $index++) {
        //increase student position if there is another student that scores higher
        $pos += ( ($scr < $stdlst[$index][1] )  ? 1: 0 );    
    }
    
    //echo $pos;
    $pos .= (($pos==1)?"ST":
            (($pos==2)?"ND":
            (($pos==3)?"RD":"TH")));
		
    return $pos;
             
}

function getCourseAve($std_id, $ses, $ter, $cla, $cou){
    $log = new login(); 
    //$std_id="SD20080001"; $ses="2012/2013"; $ter="Second Term"; $cla="SS TWO"; 
    //var to store stud_id and their score
    $stdlst = array(array());
    //var to monitor stud position
    $pos = 1; 
    //var to store stud score
    $scr = 0; 
    $ascr = 0; 
    //get list of all student and thier score in same session, class and term
    $log->database();
    $log->set_sqlstr("SELECT `student_id`, (ca1 + ca2 + ca3 + exam) AS Score FROM result WHERE "
            ." (`session` = '" . $ses . "') AND    (`class` = '" . $cla . "') AND (`term` = '" 
            . $ter . "') AND (`subject` = '" . $cou . "') ORDER BY `student_id` DESC");
    $log->querydata();                        
    for($i=0; $i < $log->no_rec; $i++){    
        //store student id and its score in the array
        $stdlst[$i][0] = $log->data[0]; $stdlst[$i][1] = $log->data[1];
        if($log->data[0] == $std_id){
            $scr = $stdlst[$i][1] ; 
				//$ascr = $scr;			
        }  
		$ascr += $log->data[1];	
		$ascr1 = $ascr/$log->no_rec;	
        //fetch next student's record
        $log->fetchdata();
    }      
		
    return $ascr1;
             
}
function fres($ses, $u, $cou){
     $log = new login(); 
    $log->database();
    $log->set_sqlstr("SELECT (ca1 + ca2 + ca3  + exam) AS Score FROM result WHERE "
            ." (`session` = '" . $ses . "') AND (`term` = 1) AND (`student_id` = '".$u."') AND (`subject` = '" . $cou . "')");
    $log->querydata();
    
    return $log->data[0];
}
function totper($ses, $u, $term){
     $log = new login(); 
    $log->database();
	$ascr = 0;
    $log->set_sqlstr("SELECT (ca1 + ca2 + ca3  + exam) AS Score FROM result WHERE "
            ." (`session` = '" . $ses . "') AND (`term` = '".$term."') AND (`student_id` = '".$u."')");
    $log->querydata();
     for($i=0; $i < $log->no_rec; $i++){    
        
		$ascr += $log->data[0];	
		$ascr1 = $ascr/$log->no_rec;	
        //fetch next student's record
        $log->fetchdata();
    }
    return ceil($ascr1)."%";
}
function sres($ses, $u, $cou){
     $log = new login(); 
    $log->database();
    $log->set_sqlstr("SELECT (ca1 + ca2 + ca3  + exam) AS Score FROM result WHERE "
            ." (`session` = '" . $ses . "') AND (`term` = 2) AND (`student_id` = '".$u."') AND (`subject` = '" . $cou . "')");
    $log->querydata();
    
    return $log->data[0];
}
?>