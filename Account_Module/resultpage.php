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
                //include("../includes/login.inc.php");
                include("../bin/getpos.php");
                $log = new login();
                $log->database();
                
                 $logg = new login();
                $logg->database();
                
                $sec = new login();
                $sec->database();
                
                $log->set_sqlstr("SELECT * FROM student_data WHERE Username='".$_REQUEST['id']."'");
                $log->querydata();
            ?>
            <table width="100%" cellpadding="10" cellspacing="0">
                <tr>
                    <td>Name: <?php echo $log->data[1].", ".$log->data[2]." ".$log->data[3]; ?></td>
                    <td>Student ID: <?php echo $_REQUEST['id']; ?></td>
                    <td>Gender: <?php echo $log->data['Gender']; ?></td>
                </tr>
                <tr>
                    <td>Class: <?php echo $_REQUEST['c']; ?></td>
                    <td>Position: <?php echo getStudPos($_REQUEST['id'], $_REQUEST['se'], $_REQUEST['t'], $_REQUEST['c']); ?></td>
                    <td>Age: <?php echo $log->data['Age']; ?> YEARS</td>
                </tr>
				
				<tr>
                    <td>Total Percentage: <?php echo $tp = totper($_REQUEST['se'], $_REQUEST['id'], $_REQUEST['t']) ?></td>
					<?php 
					$log->set_sqlstr("SELECT count(*) as tot FROM student_data WHERE Class='".$_REQUEST['c']."'");
					$log->querydata();	
					$numofstd = $log->data[0];
				?>
                    <td colspan="2">Number of Student in Class: <?php echo $numofstd; ?></td>
                </tr>
            </table>
            <?php if($_REQUEST['t'] == "Third Term"){ ?>
            <table width="100%" cellpadding="10" cellspacing="0" id="s">
                <tr>
                    <th>Subject</th>
                    <th>CA1</th><th>CA2</th>
                    <th>CA</th><th>Exam</th><th>Tot. Sc.</th><th>Ave. Sc.</th><th>F. T.</th><th>S. T.</th>
                    <th>A. S.</th><th>Grade</th><th>Position</th><th>Remark</th>
                </tr>
                <?php
                    $log->set_sqlstr("SELECT * FROM result WHERE Username='".$_REQUEST['id']."' AND Class='".$_REQUEST['c'].
                            "' AND Term='".$_REQUEST['t']."' AND Session='".$_REQUEST['se']."' ORDER BY Course ASC");
                    $log->querydata();
                    function Grade($g){
                        return (($g >= 70)?"A":
                                (($g < 70 && $g >= 60)?"B":
                                (($g < 60 && $g >= 50)?"C":
                                (($g < 50 && $g >= 45)?"D":
                                (($g < 45 && $g >= 40?"E":"<span style=\"color:red\">F</span>"))))));
                    }
                    for($i = 0; $i < $log->no_rec; $i++){
                ?>
                    <tr align="center">
                        <td><?php echo $log->data['Course']; ?></td><td><?php echo $log->data['CA1']; ?></td>
                        <td><?php echo $log->data['CA2']; ?></td><td><?php echo $ca = ($log->data['CA1']+$log->data['CA2']); ?></td>
                        <td><?php echo $log->data['Exam']; ?></td>
                        <td><?php $t = ($ca + $log->data['Exam']); echo ($t<40)?"<span style=\"color:red\">".$t."</span>":$t ?></td>
						<td><?php echo getCourseAve($_REQUEST['id'], $_REQUEST['se'], $_REQUEST['t'], $_REQUEST['c'], $log->data['Course']); ?></td>
                        <td><?php echo $fs = fres($_REQUEST['se'], $_REQUEST['id'], $log->data['Course']) ?></td>
                        <td><?php echo $ss = sres($_REQUEST['se'], $_REQUEST['id'], $log->data['Course']) ?></td>
                        <td><?php echo $ts = ceil(($t+$fs+$ss)/3); ?></td>
                        <td><?php echo Grade($ts); ?></td>
                        <td><?php echo getCoursePos($_REQUEST['id'], $_REQUEST['se'], $_REQUEST['t'], $_REQUEST['c'], $log->data['Course']); ?></td>
                        <td></td>
                    </tr>
                <?php 
                    $log->fetchdata();
                    }
                ?>
            </table>
            <?php }else{ ?>
            <table width="100%" cellpadding="10" cellspacing="0" id="s">
                <tr>
                    <th>Subject</th><th>CA1</th><th>CA2</th>
                    <th>CA</th><th>Exam</th><th>Total Score</th><th>Class Average</th>
                    <th>Grade</th><th>Position</th><th>Remark</th>
                </tr>
                <?php
                    $log->set_sqlstr("SELECT * FROM result WHERE Username='".$_REQUEST['id']."' AND Class='".$_REQUEST['c'].
                            "' AND Term='".$_REQUEST['t']."' AND Session='".$_REQUEST['se']."' ORDER BY Course ASC");
                    $log->querydata();
                    function Grade($g){
                        return (($g >= 70)?"A":
                                (($g < 70 && $g >= 60)?"B":
                                (($g < 60 && $g >= 50)?"C":
                                (($g < 50 && $g >= 45)?"D":
                                (($g < 45 && $g >= 40?"E":"<span style=\"color:red\">F</span>"))))));
                    }
                    for($i = 0; $i < $log->no_rec; $i++){
                ?>
                    <tr align="center">
                        <td><?php echo $log->data['Course']; ?></td><td><?php echo $log->data['CA1']; ?></td>
                        <td><?php echo $log->data['CA2']; ?></td><td><?php echo $ca = ($log->data['CA1']+$log->data['CA2']); ?></td>
                        <td><?php echo $log->data['Exam']; ?></td>
                        <td><?php $t = ($ca + $log->data['Exam']); echo ($t<40)?"<span style=\"color:red\">".$t."</span>":$t ?></td>
						<td><?php echo getCourseAve($_REQUEST['id'], $_REQUEST['se'], $_REQUEST['t'], $_REQUEST['c'], $log->data['Course']); ?></td>
                        <td><?php echo Grade($t); ?></td>
                        <td><?php echo getCoursePos($_REQUEST['id'], $_REQUEST['se'], $_REQUEST['t'], $_REQUEST['c'], $log->data['Course']); ?></td>
                        <td></td>
                    </tr>
                <?php 
                    $log->fetchdata();
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
                    $log->set_sqlstr("SELECT * FROM status WHERE Username='".$_REQUEST['id']."'");
                    $log->querydata();
                ?>
                    <table width="100%" cellpadding="3" cellspacing="0" id="s">
                    <tr>
                        <th>Behavior and Activity</th><th>Rating</th>
                    </tr>
                    <tr>
                        <td>Punctuality</td><td><?php echo $log->data[2]; ?></td>
                    </tr>
                    <tr>
                        <td>Attendance</td><td><?php echo $log->data[3]; ?></td>
                    </tr>
                    <tr>
                        <td>Attentiveness</td><td><?php echo $log->data[1]; ?></td>
                    </tr>
                    <tr>
                        <td>Politeness</td><td><?php echo $log->data[5]; ?></td>
                    </tr>
                    <tr>
                        <td>Neatness</td><td><?php echo $log->data[6]; ?></td>
                    </tr>
                    <tr>
                        <td>Carrying Out Of Assignment</td><td><?php echo $log->data[4]; ?></td>
                    </tr>
                    <tr>
                        <td>Relationship with Staff</td><td><?php echo $log->data[7]; ?></td>
                    </tr>
                    <tr>
                        <td>Relationship with Student</td><td><?php echo $log->data[8]; ?></td>
                    </tr>
                    <tr>
                        <td>Initiative</td><td><?php echo $log->data[9]; ?></td>
                    </tr>
                    <tr>
                        <td>Club & Societies</td><td><?php echo $log->data[14]; ?></td>
                    </tr>
                    <tr>
                        <td>Manual Skill</td><td><?php echo $log->data[13]; ?></td>
                    </tr>
                    <tr>
                        <td>Attitude to Study</td><td><?php echo $log->data[11]; ?></td>
                    </tr>
                    <tr>
                        <td>Attitude to School</td><td><?php echo $log->data[12]; ?></td>
                    </tr>
                    <tr>
                        <td>Emotional Stability</td><td><?php echo $log->data[10]; ?></td>
                    </tr>
                </table>
                </div>
                 <?php
                    $log->set_sqlstr("SELECT NextTerm FROM school_calendar");
                    $log->querydata();
                    $date = date("d-m-Y");
                ?>
                <div id="comment">
                    <p id="res">Form master's comment: ..........................................................................</p>
                    <p id="res">House Master's comment: ........................................................................</p>
                    <p id="res">Class Teacher's comment: ........................................................................</p>
                    <p id="res">Principal's comment: .................................................................................</p>
                    <p id="res">Principal's signature: .............................................. Date: <?php echo $date; ?></p>
                    <p id="res">Next term commence: <?php echo $log->data[0]; ?></p>
                </div>
            </div> 
        
        <footer>
           SMS Version 2.0 &copy; <?php echo date("Y"); ?>
        </footer></div>
    </body>
</html>