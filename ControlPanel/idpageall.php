<!doctype html> 
<html>
    <head>
        <title>ID Card Center For <?php echo $_REQUEST['c']; ?> </title>
        <link rel="stylesheet" media="all" href="../css/style2.css"/>
        <link rel="stylesheet" media="all" href="../css/style.css"/>
        <link rel="stylesheet" media="all" href="../css/widgets.css"/>
    </head>
    <body id="idpage"> 
         <?php
                //include("../includes/login.inc.php");
                include("../bin/getpos.php");
                $rs = new login(); 
                $log = new login();
                $rs->database();
				
				 function getCla($po){
					$log = new login;	
					$log->database();
					$log->set_sqlstr("SELECT name FROM class WHERE id ='". $po."'"); 
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
	
                $rs->set_sqlstr("SELECT * FROM student_data WHERE Class='".$_REQUEST['c']."'");
                $rs->querydata();
                for ($i = 0; $i < $rs->no_rec; $i++) {
            ?>
        <div id="mainpid">      
            <?php
            
                $log->database();
                
                $log->set_sqlstr("SELECT * FROM student_data WHERE id='".$rs->data[0]."'");
                $log->querydata();
                for ($k = 0; $k < $log->no_rec; $k++) {
            ?>
            <table width="100%" cellpadding="5" cellspacing="0">
                <tr>
                    <th colspan="5"><img src="../img/banner.png" width="100%" alt=""/></th>
                </tr>
                <tr>
                    <td colspan="2" width="50%" align="center">Student Login Information</td>
                    <td colspan="2" align="center"><span style="font-size: 12px; color:#cb5432">You need help? </span></td>
                </tr>
                <tr>
                    <td>Name:</td><td><?php echo strtoupper($log->data[1].", ".$log->data[2]." ".$log->data[3]); ?></td>
                    <td rowspan="6" colspan="2">
					Help-lines:
					08029779386, 08065111103
                    </td>
                </tr>
                <tr>
                    <td>Student ID:</td><td><?php echo getUser($log->data[0]); ?></td>                  
                </tr>
                <tr>
                    <td>Password:</td><td>student</td>                   
                </tr>
            </table>
                <?php $log->fetchdata(); } ?>
        </div>
        <?php $rs->fetchdata(); } ?>
    </body>
</html>