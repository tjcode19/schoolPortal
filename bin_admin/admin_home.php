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
		$log->set_sqlstr("SELECT COUNT(*) as recor FROM authentication WHERE priority=1 and status =2"); 
        $log->querydata();
		$rec = $log->data['recor'];
        
        $log->set_sqlstr("SELECT * FROM staff_data WHERE id ='". $_SESSION['s_portal_id'] ."'"); 
        $log->querydata();
        $name = $log->data['title']." ".$log->data['last_name']." ".$log->data['first_name']." ".$log->data['other_name'];
        $age = $log->data['date_of_birth'];
        $address = $log->data['residential_address'];
        $phone = $log->data['phone'];
        $bg= $log->data['blood_group'];
        $ht= $log->data['height'];
        $email= $log->data['email'];
        $pp= $log->data['passport'];
?>
<div class="col-md-12">Total Students: <?php echo $rec; ?></div>
<table width="100%" cellpadding="10" cellspacing="0">
    <tr>
        <td rowspan="6" width="30%">
            <a href="<?php echo $pp; ?>" class="thumb" data-rel="prettyPhoto">
                <img id="pp" src="<?php echo $pp; ?>" alt="<?php echo $_SESSION['user_id']; ?>" />
            </a>
            <?php echo "<input type=\"button\" value=\"Change Piture\" onClick=\"editpix('".$log->data['id']."');\">"; ?>
        </td>
        <td align="right">Admin ID:</td><td><?php echo $_SESSION['user_id']; ?></td>
		
    </tr>
    <tr>
        <td align="right">Full Name:</td><td><?php echo $name; ?></td>
    </tr>
    <tr>
        <td align="right">Age:</td><td><?php echo $age; ?> YEARS</td>
    </tr>
    <tr>
        <td align="right">Address:</td><td><?php echo $address; ?></td>
    </tr>
    <tr>
        <td align="right">Phone Number:</td><td><?php echo $phone; ?></td>
    </tr>
    <tr>
        <td align="right">Email:</td><td><?php echo $email; ?></td>
    </tr>
    <tr>
        <td></td><td align="right">Blood Group:</td><td><?php echo $bg; ?></td>
    </tr>
    <tr>
        <td></td><td align="right">Height:</td><td><?php echo $ht; ?></td>
    </tr>
</table>
