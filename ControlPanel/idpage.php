<!doctype html> 
<html>
    <head>
        <title>ID Card Center</title>
        <link rel="stylesheet" media="all" href="../css/style2.css"/>
        <link rel="stylesheet" media="all" href="../css/style.css"/>
        <link rel="stylesheet" media="all" href="../css/widgets.css"/>
    </head>
    <body id="idpage"> 
        <div id="mainpid">      
            <?php
                //include("../includes/login.inc.php");
                include("../bin/getpos.php");
                $log = new login();
                $log->database();
                
                $log->set_sqlstr("SELECT * FROM student_data WHERE Username='".$_REQUEST['n']."'");
                $log->querydata();
            ?>
            <table width="100%" cellpadding="5" cellspacing="0">
                <tr>
                    <th colspan="3" width="50%">DEMO SCHOOL</th><th colspan="3">Back DEMO SCHOOL</th>
                </tr>
                <tr>
                    <td colspan="3" align="center">STUDENT IDENTITY CARD</td>
                    <td colspan="3">PARENT NAME: <span style="font-size: 12px; color: #cb5432"><?php echo $log->data[6]; ?> </span>, ADDRESS: <span style="font-size: 12px; color:#cb5432"><?php echo $log->data[7]; ?> </span></td>
                </tr>
                <tr>
                    <td rowspan="6"><img id="id" src="<?php echo $log->data['Passport']; ?>" alt="<?php echo $log->data['Username']; ?>" /></td>
                    <td>Name:</td><td><?php echo strtoupper($log->data[1].", ".$log->data[2]." ".$log->data[3]); ?></td>
                    <td rowspan="6" colspan="3">
                        <div id="idback">
                            <p style="font-size: 12px; text-align: center">
                                If this card is found, please return to: <br/><br/>
                                <span style="font-size: 17px;">Demo School</span><br/>
                                P. O. Box 140, <br/>
                                Ilorin, Kwara State.<br/>
                                Tel: 07036443808
                            </p>
                            <p style="font-size: 12px; text-align: center">
                                This is to certify that the person whose photograph appears on this card is a bonafide Student of this School. 
                                This card is not transferable.
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Student ID:</td><td><?php echo $_REQUEST['n']; ?></td>                  
                </tr>
                <tr>
                    <td>Gender:</td><td><?php echo $log->data[4]; ?></td>                   
                </tr>
                <tr>
                    <td>Class:</td><td><?php echo $log->data[12]; ?></td>                   
                </tr>
                <tr>
                    <td>Blood Group:</td><td><?php echo $log->data[10]; ?></td>                  
                </tr>
                <tr>
                    <td>Contact Number:</td><td><?php echo $log->data[8]; ?></td>                  
                </tr>
            </table>
        </div>
    </body>
</html>