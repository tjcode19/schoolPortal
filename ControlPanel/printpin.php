<!doctype html> 
<html>
    <head>
        <title>PIN Center</title>
        <link rel="stylesheet" media="all" href="../css/style2.css"/>
        <link rel="stylesheet" media="all" href="../css/style.css"/>
        <link rel="stylesheet" media="all" href="../css/widgets.css"/>
    </head>
    <body id="idpage"> 
        <?php
                require_once ('../includes/login.inc.php');
                
                $log = new login;
                $log->database();                
                $log->set_sqlstr("SELECT * FROM pin_log WHERE Status='Activated'");
                $log->querydata();
                for ($k = 0; $k < $log->no_rec; $k++) {
                    $log->set_sqlstr("UPDATE pin_log SET Status='Printed' WHERE Status = 'Activated'");
                    $log->ex_scalar();
            ?>
        <div id="mainpid"> 
            <table width="100%" cellpadding="5" cellspacing="0">
                <tr>
                    <th colspan="2" width="40%">DEMO SCHOOL</th>
                    <th colspan="2">HOW TO USE</th>
                </tr>
                <tr>
                    <td colspan="2" align="center">ACTIVATION PIN</td>
                     <td rowspan="5" colspan="2">
                        <div id="idback">
                            <ul style="font-size: 12px; text-align: center; list-style: circle">
                                <li>visit www.demoschool.com</li>
                                <li>Click on School Portal from navigation bar</li>
                                <li>Enter your Username and Password, then click login</li>
                                <li>Enter Activation PIN</li>
                            </ul> 
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right">PIN:</td><td><?php echo $log->data[1]; ?></td>
                </tr>
                <tr>
                    <td align="right">Serial Number:</td><td><?php echo $log->data[2]; ?></td>                  
                </tr>
                 <tr>
                    <td align="right">Printed On:</td><td><?php echo date("d-m-Y"). " at ". date("H:i:s"); ?></td>                  
                </tr>
                 <tr>
                    <td align="right">Number Code :</td><td><?php echo $log->data[0]." of ". $log->no_rec; ?></td>                  
                </tr>
            </table> </div>
                <?php $log->fetchdata(); } ?>
       
    </body>
</html>