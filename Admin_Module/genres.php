
     <?php
        include("../bin/getpos.php");
        function Grade($g){
                        return (($g >= 70)?"A":
                                (($g < 70 && $g >= 60)?"B":
                                (($g < 60 && $g >= 50)?"C":
                                (($g < 50 && $g >= 45)?"D":
                                (($g < 45 && $g >= 40?"E":"F"))))));
                    }
					function getSub($id){
					$log = new login();
					$log->database();
					$log->set_sqlstr("SELECT Name FROM subject WHERE id='".$id."'");
					$log->querydata();
					return $log->data[0];					
				}
				
				function getCla($po){
					$log = new login;	
					$log->database();
					$log->set_sqlstr("SELECT name FROM class WHERE id ='". $po."'"); 
					$log->querydata();
					return $log->data[0];
				}
				 function getTerm($po){
					$log = new login;	
					$log->database();
					$log->set_sqlstr("SELECT name FROM term WHERE id ='". $po."'"); 
					$log->querydata();
					return $log->data[0];
				}
				 function getSe($po){
					$log = new login;	
					$log->database();
					$log->set_sqlstr("SELECT name FROM session WHERE id ='". $po."'"); 
					$log->querydata();
					return $log->data[0];
				}
				 function getUser($po){
					$log = new login;	
					$log->database();
					$log->set_sqlstr("SELECT username FROM authentication WHERE id ='". $po."'"); 
					$log->querydata();
					return $log->data[0];
				}
				 function getAge($po){
					$po = explode("-", $po);
					$age = $po[2];
					$dy = date("Y");
					$age = $dy - $age;
					return $age;
				}
                    
        $log = new login();
        
        $log1 = new login();
        
        $ab = new login();
        
        $cl = new login();
        
        $rs = new login(); 

        
        $log->database();
        $log->set_sqlstr("SELECT DISTINCT session FROM result WHERE student_id='".$_REQUEST['id']."' ORDER BY session ASC");
        $log->querydata();
        for($stv = 0; $stv < $log->no_rec; $stv++){
            
            $ab->database();
            $ab->set_sqlstr("SELECT DISTINCT term FROM result WHERE session='".$log->data[0]."' AND student_id='".$_REQUEST['id']."' ORDER BY term ASC");
            $ab->querydata();
            for($st = 0; $st < $ab->no_rec; $st++){ 
    ?>
    <!doctype html> 
    <html>
    <head>
        <title>Result Page</title>
        <link rel="stylesheet" media="all" href="../css/style2.css"/>
        <link rel="stylesheet" media="all" href="../css/style.css"/>
        <link rel="stylesheet" media="all" href="../css/widgets.css"/>
    </head>
    <body id="resultpage">
        <div id="mainp">
        <header>
            <div id="logo_res">
                <a href="index.html"><img  src="../img/banner.png" alt="Simpler"></a>
            </div>
            <div id="row1">
                <div><h2>Report Sheet</h2></div>
                <div><h3><?php echo getTerm($ab->data[0])." Of ". getSe($log->data[0]) ; ?></h3></div>
                <div><h3>PART A</h3></div>
            </div>
        </header>
        
            <?php   
                
                $log1->database();
                $log1->set_sqlstr("SELECT * FROM student_data WHERE id='".$_REQUEST['id']."'");
                $log1->querydata();
                
                $cl->database();
                $cl->set_sqlstr("SELECT Class FROM result WHERE student_id='".$_REQUEST['id']."' AND Term='".$ab->data[0]."' AND Session='".$log->data[0]."'");
                $cl->querydata();
            ?>
            <table width="100%" cellpadding="5" cellspacing="0">
                <tr>
                    <td>Name: <?php echo $log1->data[1].", ".$log1->data[2]." ".$log1->data[3]; ?></td>
                    <td>Student ID: <?php echo getUser($log1->data[0]); ?></td>
                    <td>Gender:  <?php echo ($log1->data['gender'] != 1)?"Female":"Male"; ?></td>
                </tr>
                <tr>
                    <td>Class: <?php echo getCla($cl->data[0]); ?></td>
                    <td>Position: <?php echo getStudPos($_REQUEST['id'], $log->data[0], $ab->data[0], $cl->data[0]); ?></td>
                    <td>Age: <?php echo getAge($log1->data[4]); ?> YEARS</td>
                </tr>
				<tr>
                    <td>Total Percentage: <?php echo $tp = totper($log->data[0], $_REQUEST['id'], $ab->data[0]) ?></td>
					<?php 
					$log->set_sqlstr("SELECT count(*) as tot FROM student_data WHERE class='".$cl->data[0]."'");
					$log->querydata();	
					$numofstd = $log->data[0];
				?>
                    <td>
					<td colspan="2">Number of Student in Class: <?php echo $numofstd; ?></td>
				</tr>
            </table>
            <table width="100%" cellpadding="5" cellspacing="0" id="s">
                <tr>
                    <th>Subject</th>
					<th>CA1</th>
					<th>CA2</th>
					<th>CA3</th>
					<th>CA</th><th>Exam</th><th>Total Score</th><th>Grade</th>
                    <th>Position</th><th>Remark</th>
                </tr>
                <?php
                    
                    $rs->database();                     
                    $rs->set_sqlstr("SELECT * FROM result WHERE student_id='".$_REQUEST['id']."' AND Term='".$ab->data[0]."' AND Session='".$log->data[0]."' ORDER BY subject ASC");
                    $rs->querydata();
                    
                    for($i = 0; $i < $rs->no_rec; $i++){
                ?>
                    <tr align="center">
                        <td><?php echo getSub($rs->data['subject']); ?></td>
						<td><?php echo $rs->data['ca1']; ?></td>
                        <td><?php echo $rs->data['ca2']; ?></td>
						<td><?php echo $rs->data['ca3']; ?></td>
						<td><?php echo $ca = ($rs->data['ca1']+$rs->data['ca2']+$rs->data['ca3']); ?></td>
                        <td><?php echo $rs->data['exam']; ?></td>
						<td><?php echo $t = ($ca + $rs->data['exam']); ?></td>
                        <td><?php echo Grade($t); ?></td>
                        <td><?php echo getCoursePos($_REQUEST['id'], $log->data[0], $ab->data[0], $cl->data[0], $rs->data['subject']); ?></td><td></td>
                    </tr>
                <?php 
                    $rs->fetchdata();
                    }
                ?>
            </table>
            <div id="row1">
                <div><h3>PART B</h3></div>
            </div>
            <div id="row2">
                <div id="act">
                 <?php
                    
                    $log1->database();
					$log1->set_sqlstr("SELECT * FROM behaviouralattitude WHERE student_id='".$_REQUEST['id']."' AND term='".$ab->data[0].
					"' AND session='".$log->data[0]."' AND class='".$cl->data[0]."'");
                    $log1->querydata();
                ?>
                    <table width="100%" cellpadding="3" cellspacing="0" id="s">
                    <tr>
                        <th>Behavior and Activity</th><th>Rating</th>
                    </tr>
                    <tr>
                        <td>Punctuality</td><td><?php echo $log1->data[2]; ?></td>
                    </tr>
                    <tr>
                        <td>Attendance</td><td><?php echo $log1->data[3]; ?></td>
                    </tr>
                    <tr>
                        <td>Attentiveness</td><td><?php echo $log1->data[1]; ?></td>
                    </tr>
                    <tr>
                        <td>Politeness</td><td><?php echo $log1->data[5]; ?></td>
                    </tr>
                    <tr>
                        <td>Neatness</td><td><?php echo $log1->data[6]; ?></td>
                    </tr>
                    <tr>
                        <td>Carrying Out Of Assignment</td><td><?php echo $log1->data[4]; ?></td>
                    </tr>
                    <tr>
                        <td>Relationship with Staff</td><td><?php echo $log1->data[7]; ?></td>
                    </tr>
                    <tr>
                        <td>Relationship with Student</td><td><?php echo $log1->data[8]; ?></td>
                    </tr>
                    <tr>
                        <td>Initiative</td><td><?php echo $log1->data[9]; ?></td>
                    </tr>
                    <tr>
                        <td>Club & Societies</td><td><?php echo $log1->data[14]; ?></td>
                    </tr>
                    <tr>
                        <td>Manual Skill</td><td><?php echo $log1->data[13]; ?></td>
                    </tr>
                    <tr>
                        <td>Attitude to Study</td><td><?php echo $log1->data[11]; ?></td>
                    </tr>
                    <tr>
                        <td>Attitude to School</td><td><?php echo $log1->data[12]; ?></td>
                    </tr>
                    <tr>
                        <td>Emotional Stability</td><td><?php echo $log1->data[10]; ?></td>
                    </tr>
                </table>
                </div>
                 <?php
                    
                    //$log1->database();
                    //$log1->set_sqlstr("SELECT NextTerm FROM school_calendar");
                    //$log1->querydata();
                    $date = date("d-m-Y");
                ?>
                <div id="comment">
                    <p id="res">Form master's comment: ..........................................................................</p>
                    <p id="res">House Master's comment: ........................................................................</p>
                    <p id="res">Class Teacher's comment: ........................................................................</p>
                    <p id="res">Principal's comment: .................................................................................</p>
                    <p id="res">Principal's signature: .............................................. Date: <?php echo $date; ?></p>
                </div>
            </div> 
       
        <footer>
            SMS Version 2.0 &copy; <?php echo date("Y"); ?>
        </footer> </div>
    </body></html>
          <?php  
        $ab->fetchdata(); 
} ?>
      <?php  
        $log->fetchdata(); 
} ?>
