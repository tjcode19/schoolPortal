<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     
    $log->verify_login();
    if ($log->logsuccess !=3){
        header("Location:".Homepage);
    }
    if(isset($_REQUEST['action'])){
	    if($_REQUEST['action']=='out' && $log->logsuccess != 0) 
		   {$log->logout(); header("Location:".Homepage);}
	}
        $log->set_sqlstr("SELECT * FROM emp_details WHERE Username ='". $_SESSION['s_portal_id'] ."'"); 
        $log->querydata();
        $ql = $log->data['Qualification'];
        $yemp = $log->data['YearOfEmp'];
        $yexp = $log->data['YearOfExp'];
        $class = $log->data['ClassInCharge'];
        $status = $log->data['EmpStatus'];
        
        $log->set_sqlstr("SELECT * FROM admin_data WHERE Username ='". $_SESSION['s_portal_id'] ."'"); 
        $log->querydata();
        $name = $log->data['Title']." ".$log->data['Fullname'];
        $pp= $log->data['Passport'];
?>
<table width="100%" cellpadding="10" cellspacing="0">
                            <tr>
                                <td rowspan="6" width="30%">
                                    <a href="<?php echo $pp; ?>" class="thumb" data-rel="prettyPhoto">
                                        <img id="pp" src="<?php echo $pp; ?>" alt="<?php echo $_SESSION['s_portal_id']; ?>" />
                                    </a>
                                    <?php echo "<input type=\"button\" value=\"Change Picture\" onClick=\"editpix('".$log->data['Username']."');\">"; ?>
                                </td>
                                <td align="right">Admin ID:</td><td><?php echo $_SESSION['s_portal_id']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Full Name:</td><td><?php echo $name; ?></td>
                            </tr>
                             <tr>
                                <td align="right">Qualification:</td><td><?php echo $ql; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Year Of Employment:</td><td><?php echo $yemp; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Years of Experience:</td><td><?php echo $yexp; ?> YEARS</td>
                            </tr>
                            <tr>
                                <td align="right">Class:</td><td><?php echo $class; ?></td>
                            </tr>
                            <tr>
                                <td></td><td align="right">Employment Status:</td><td> <?php echo $status; ?> </td>
                            </tr>
                        </table>