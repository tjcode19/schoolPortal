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
        
        $log->set_sqlstr("SELECT * FROM student_data WHERE id ='". $_SESSION['s_portal_id'] ."'"); 
        $log->querydata();
        $name = $log->data['last_name']." ".$log->data['first_name']." ".$log->data['other_name'];
        $age = $log->data['date_of_birth'];
        $address = $log->data['residential_address'];
        $phone = $log->data['parent_phone'];
        $bg= $log->data['blood_group'];
        $gender= $log->data['gender'];
        $ht= $log->data['height'];
        $email= $log->data['parent_email'];
        $pp= $log->data['passport'];
?>
<table width="100%" cellpadding="10" cellspacing="0">
    <tr>
        <td rowspan="6" width="30%">
            <a href="<?php echo $pp; ?>" class="thumb" data-rel="prettyPhoto">
                <img id="pp" src="<?php echo $pp; ?>" alt="<?php echo $_SESSION['s_portal_id']; ?>" />
            </a>
        </td>
        <td align="right">Student ID:</td><td><?php echo $_SESSION['user_id']; ?></td>
    </tr>
    <tr>
        <td align="right">Full Name:</td><td><?php echo $name; ?></td>
    </tr>
    <tr>
        <td align="right">Gender:</td><td><?php echo ($gender != 1)?"Female":"Male"; ?></td>
    </tr>
    <tr>
        <td align="right">Date of Birth:</td><td><?php echo $age; ?> </td>
    </tr>
    <tr>
        <td align="right">Address:</td><td><?php echo $address; ?></td>
    </tr>
    <tr>
        <td align="right">Phone Number:</td><td><?php echo $phone; ?></td>
    </tr>
    <tr>
        <td></td><td align="right">Email:</td><td><?php echo $email; ?></td>
    </tr>
    <tr>
        <td></td><td align="right">Blood Group:</td><td><?php echo $bg; ?></td>
    </tr>
    <tr>
        <td></td><td align="right">Height:</td><td><?php echo $ht; ?></td>
    </tr>
</table>

