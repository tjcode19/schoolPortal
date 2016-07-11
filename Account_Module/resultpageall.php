
     <?php
        include("../bin/getpos.php");
        function Grade($g){
                        return (($g >= 70)?"A":
                                (($g < 70 && $g >= 60)?"B":
                                (($g < 60 && $g >= 50)?"C":
                                (($g < 50 && $g >= 45)?"D":
                                (($g < 45 && $g >= 40?"E":"<span style=\"color:red\">F</span>"))))));
                    }
                    
        $log = new login();
        
        $log1 = new login();
        
        $rs = new login(); 

        
        $log->database();
        $log->set_sqlstr("SELECT DISTINCT Username FROM student_data WHERE Class='".$_REQUEST['c']."'");
        $log->querydata();
        for($stv = 0; $stv < $log->no_rec; $stv++){ 
    ?>
	
    <!doctype html> 
    <html>
    <head>
        <title>Result Page</title>
        <link rel="stylesheet" media="all" href="../css/style2.css"/>
        <link rel="stylesheet" media="all" href="../css/style.css"/>
        <link rel="stylesheet" media="all" href="../css/widgets.css"/>
		<style>
			#logo_res{
				background-image:url('../img/cms.jpg');
			}
		</style>
    </head>
    <body id="resultpage">
        <div id="mainp">
        <header>
            <div id="logo_res">
                <a href="index.html"><img  src="../img/banner.png" alt="Simpler"></a>
            </div>
            <div id="row1">
                <div><h2>Report Sheet</h2></div>
                <div><h3><?php echo $_REQUEST['t']." Of ". $_REQUEST['se'] ; ?></h3></div>
                <div><h3>PART A</h3></div>
            </div>
        </header>
        
            <?php   
                
                $log1->database();
                $log1->set_sqlstr("SELECT * FROM student_data WHERE Username='".$log->data[0]."'");
                $log1->querydata();
            ?>
			
            <table width="100%" cellpadding="5" cellspacing="0">
                <tr>
                    <td>Name: <?php echo $log1->data[1].", ".$log1->data[2]." ".$log1->data[3]; ?></td>
                    <td>Student ID: <?php echo $log1->data[0]; ?></td>
                    <td>Gender: <?php echo $log1->data['Gender']; ?></td>
                </tr>
                <tr>
                    <td>Class: <?php echo $_REQUEST['c']; ?></td>
                    <td>Position: <?php echo getStudPos($log->data[0], $_REQUEST['se'], $_REQUEST['t'], $_REQUEST['c']); ?></td>
                    <td>Age: <?php echo $log1->data['Age']; ?> YEARS</td>
                </tr>
				
				<tr>
                    <td>Total Percentage: <?php echo $tp = totper($_REQUEST['se'], $log->data[0], $_REQUEST['t']) ?></td>
                    <td colspan="2">Number of Student in Class: <?php echo $log->no_rec; ?></td>
                </tr>
            </table>
            <?php if($_REQUEST['t'] == "Third Term"){ ?>
            <table width="100%" cellpadding="10" cellspacing="0" id="s">
                <tr>
                    <th>Subject</th>
                    <th>CA1</th><th>CA2</th>
                    <th>CA</th><th>Exam</th><th>Total Score</th><th>F. T.</th><th>S. T.</th>
                    <th>A. S.</th><th>Grade</th><th>Position</th><th>Remark</th>
                </tr>
                <?php
                    
                    $rs->database();                     
                    $rs->set_sqlstr("SELECT * FROM result WHERE Username='".$log->data[0]."' AND Class='".$_REQUEST['c'].
                            "' AND Term='".$_REQUEST['t']."' AND Session='".$_REQUEST['se']."' ORDER BY Course ASC");
                    $rs->querydata();
                    
                    for($i = 0; $i < $rs->no_rec; $i++){
                ?>
                    <tr align="center">
                        <td><?php echo $rs->data['Course']; ?></td><td><?php echo $rs->data['CA1']; ?></td>
                        <td><?php echo $rs->data['CA2']; ?></td><td><?php echo $ca = ($rs->data['CA1']+$rs->data['CA2']); ?></td>
                        <td><?php echo $rs->data['Exam']; ?></td>
                        <td><?php $t = ($ca + $rs->data['Exam']); echo ($t<40)?"<span style=\"color:red\">".$t."</span>":$t ?></td>
                         <td><?php echo $fs = fres($_REQUEST['se'], $log->data[0], $rs->data['Course']) ?></td>
                        <td><?php echo $ss = sres($_REQUEST['se'], $log->data[0], $rs->data['Course']) ?></td>
                        <td><?php echo $ts = ceil(($t+$fs+$ss)/3); ?></td>
                        <td><?php echo Grade($ts); ?></td>
                        <td><?php echo getCoursePos($log->data[0], $_REQUEST['se'], $_REQUEST['t'], $_REQUEST['c'], $rs->data['Course']); ?></td><td></td>
                    </tr>
                <?php 
                    $rs->fetchdata();
                    }
                ?>
            </table>
            <?php }else{ ?>
            <table width="100%" cellpadding="10" cellspacing="0" id="s">
                <tr>
                    <th>Subject</th><th>CA1</th><th>CA2</th><th>CA</th><th>Exam</th><th>Total Score</th><th>Class Average</th><th>Grade</th>
                    <th>Position</th><th>Remark</th>
                </tr>
                <?php
                    
                    $rs->database();                     
                    $rs->set_sqlstr("SELECT * FROM result WHERE Username='".$log->data[0]."' AND Class='".$_REQUEST['c'].
                            "' AND Term='".$_REQUEST['t']."' AND Session='".$_REQUEST['se']."' ORDER BY Course ASC");
                    $rs->querydata();
                    
                    for($i = 0; $i < $rs->no_rec; $i++){
                ?>
                    <tr align="center">
                        <td><?php echo $rs->data['Course']; ?></td><td><?php echo $rs->data['CA1']; ?></td>
                        <td><?php echo $rs->data['CA2']; ?></td><td><?php echo $ca = ($rs->data['CA1']+$rs->data['CA2']); ?></td>
                        <td><?php echo $rs->data['Exam']; ?></td>
                        <td><?php $t = ($ca + $rs->data['Exam']); echo ($t<40)?"<span style=\"color:red\">".$t."</span>":$t ?></td>
						<td><?php echo getCourseAve($log->data[0], $_REQUEST['se'], $_REQUEST['t'], $_REQUEST['c'], $rs->data['Course']); ?></td>
                        <td><?php echo Grade($t); ?></td>
                        <td><?php echo getCoursePos($log->data[0], $_REQUEST['se'], $_REQUEST['t'], $_REQUEST['c'], $rs->data['Course']); ?></td><td></td>
                    </tr>
                <?php 
                    $rs->fetchdata();
                    }
                ?>
            </table>
            <?php } ?>
            <div id="row1">
                <div><h3>PART B</h3></div>
            </div>
            <div id="row2">
                <div id="act">
                 <?php
                    
                    $log1->database();
                    $log1->set_sqlstr("SELECT * FROM status WHERE Username='".$log->data[0]."'");
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
                    
                    $log1->database();
                    $log1->set_sqlstr("SELECT NextTerm FROM school_calendar");
                    $log1->querydata();
                    $date = date("d-m-Y");
                ?>
                <div id="comment">
                    <p id="res">Form master's comment: ..........................................................................</p>
                    <p id="res">House Master's comment: ........................................................................</p>
                    <p id="res">Class Teacher's comment: ........................................................................</p>
                    <p id="res">Principal's comment: .................................................................................</p>
                    <p id="res">Principal's signature: .............................................. Date: <?php echo $date; ?></p>
                    <p id="res">Next term commence: <?php echo $log1->data[0]; ?></p>
                </div>
            </div> 
       
        <footer>
            SMS Version 2.0 &copy; <?php echo date("Y"); ?>
        </footer> </div>
    </body></html>
      <?php  
        $log->fetchdata(); 
} ?>
