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
        
        $log->set_sqlstr("SELECT class FROM student_data WHERE id ='". $_SESSION['s_portal_id'] ."'"); 
        $log->querydata();
		
        $log->set_sqlstr("SELECT * FROM staff_data WHERE class_in_charge='". $log->data[0] ."'"); 
        $log->querydata();
        $name = $log->data['title']." ".$log->data['first_name']." ".$log->data['last_name'];
        $age = $log->data['date_of_birth'];
        $address = $log->data['residential_address'];
        $phone = $log->data['phone'];
        $bg= $log->data['blood_group'];
        $ht= $log->data['height'];
        $email= $log->data['email'];
        $pp= $log->data['passport'];
		
?>
<table width="100%" cellpadding="10" cellspacing="0">
    <tr>
        <td rowspan="4" width="30%">
            <a href="<?php echo $pp; ?>" class="thumb" data-rel="prettyPhoto">
                <img id="pp" src="<?php echo $pp; ?>" alt="<?php echo $log->data['first_name']; ?>" />
            </a>
        </td>
        <td align="right">Full Name:</td><td><?php echo $name; ?></td>
    </tr>
    <tr>
        <td align="right">Phone Number:</td><td><?php echo $phone; ?></td>
    </tr>
    <tr>
        <td align="right">Email:</td><td><?php echo $email; ?></td>
    </tr>
    <tr>
        <td align="center" colspan="2">Contact</td>
    </tr>
</table>

