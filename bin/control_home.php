<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     
    $log->verify_login();
    if ($log->logsuccess !=4){
        header("Location:".Homepage);
    }
    if(isset($_REQUEST['action'])){
	    if($_REQUEST['action']=='out' && $log->logsuccess != 0) 
		   {$log->logout(); header("Location:".Homepage);}
	}
        
        $log->set_sqlstr("SELECT * FROM admin_data WHERE Username ='". $_SESSION['s_portal_id'] ."'"); 
        $log->querydata();
        $name = $log->data['Title']." ".$log->data['Fullname'];
        $age = $log->data['Age'];
        $address = $log->data['Address'];
        $phone = $log->data['Phone'];
        $bg= $log->data['BloodG'];
        $ht= $log->data['Height'];
        $email= $log->data['Email'];
        $pp= $log->data['Passport'];
?>
<table width="100%" cellpadding="10" cellspacing="0">
    <tr>
        <td rowspan="6" width="30%">
            <a href="<?php echo $pp; ?>" class="thumb" data-rel="prettyPhoto">
                <img id="pp" src="<?php echo $pp; ?>" alt="<?php echo $_SESSION['s_portal_id']; ?>" />
            </a>
            <?php echo "<input type=\"button\" value=\"Edit\" onClick=\"editpix('".$log->data['Username']."');\">"; ?>
        </td>
        <td align="right">Admin ID:</td><td><?php echo $_SESSION['s_portal_id']; ?></td>
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
