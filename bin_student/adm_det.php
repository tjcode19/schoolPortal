<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     
    $log->verify_login();
    if ($log->logsuccess !=1){
        header("Location:".Homepage);
    }
    if(isset($_REQUEST['action'])){
	    if($_REQUEST['action']=='out' && $log->logsuccess != 0) 
		   {$log->logout(); header("Location:".Homepage);}
	}
        $log->set_sqlstr("SELECT * FROM admission_details WHERE Username ='". $_SESSION['s_portal_id'] ."'"); 
        $log->querydata();
        $ex = $log->data['ExtraActivity'];
        $yadm = $log->data['YearOfAdmission'];
        $yog = $log->data['YearOfGraduation'];
        $class = $log->data['PresentClass'];
        $status = $log->data['AdmissionStatus'];
        
        $log->set_sqlstr("SELECT Fullname FROM staff_data WHERE ClassInCharge ='". $class ."'"); 
        $log->querydata();
        $ct = $log->data[0];
        
        $log->set_sqlstr("SELECT * FROM student_data WHERE Username ='". $_SESSION['s_portal_id'] ."'"); 
        $log->querydata();
        $name = $log->data['Surname']." ".$log->data['Firstname']." ".$log->data['Other'];
        $pp= $log->data['Passport'];
        
        
?>
<table width="100%" cellpadding="10" cellspacing="0">
    <tr>
        <td rowspan="6" width="30%">
            <a href="<?php echo $pp; ?>" class="thumb" data-rel="prettyPhoto">
                <img id="pp" src="<?php echo $pp; ?>" alt="<?php echo $_SESSION['s_portal_id']; ?>" />
            </a>
        </td>
        <td align="right">Student ID:</td><td><?php echo $log->data['Username']; ?></td>
    </tr>
    <tr>
        <td align="right">Full Name:</td><td><?php echo $name; ?></td>
    </tr>
    <tr>
        <td align="right">Extra Curriculum Activity:</td><td><?php echo $ex; ?></td>
    </tr>
    <tr>
        <td align="right">Year Of Admission:</td><td><?php echo $yadm; ?></td>
    </tr>
    <tr>
        <td align="right">Year of Graduation:</td><td><?php echo $yog; ?></td>
    </tr>
    <tr>
        <td align="right">Present Class:</td><td><?php echo $class; ?></td>
    </tr>
    <tr>
        <td></td><td align="right">Admission Status:</td><td><?php echo $status; ?> </td>
    </tr>
    <tr>
        <td></td><td align="right">Position In Class:</td><td></td>
    </tr>
    <tr>
        <td></td><td align="right">Class Teacher:</td><td><?php echo $ct; ?></td>
    </tr>
</table>