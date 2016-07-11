<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();

/* Resets Password to default */
if(isset($_REQUEST['a'])){
$log->set_sqlstr("SELECT priority FROM authentication WHERE id ='". $_REQUEST['n'] ."'"); 
    $log->querydata();
    
    if($log->data[0] == 1){
      $pass = md5('student');
        $log->set_sqlstr("UPDATE authentication SET password='" . $pass . "' WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();  
    }
}
/* Resets Password to default End */

/* Deactivate User */
if(isset($_REQUEST['a']) && $_REQUEST['a']=='deactivate'){
        $log->set_sqlstr("UPDATE authentication SET status=1 WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
}
/* Deactivate User End */

/* Deactivate User */
if(isset($_REQUEST['a']) && $_REQUEST['a']=='activate'){
        $log->set_sqlstr("UPDATE authentication SET status=2 WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
}
/* Deactivate User End */
		$log->set_sqlstr("SELECT * FROM authentication INNER JOIN student_data ON authentication.id=student_data.id WHERE student_data.id ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        $name = $log->data['last_name']." ".$log->data['first_name']." ".$log->data['other_name'];
        $age = $log->data['date_of_birth'];
        $address = $log->data['residential_address'];
        $phone = $log->data['parent_phone'];
        $bg= $log->data['blood_group'];
        $ht= $log->data['height'];
        $email= $log->data['parent_email'];
        $pp= $log->data['passport'];
        $pn = $log->data['parent_name'];
		$class = $log->data['class'];
		$status = $log->data['status'];
		
		function getStatus($st){
			if($st == 1){$status = "Inactive";}
			elseif($st == 2){$status = "Active";}
			elseif($st == 0){$status = "Raw";}
			elseif($st == 3){$status = "Locked";}
			return $status;
		}
		
		function getClass($cl){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM class WHERE id ='". $cl."'"); 
			$log->querydata();
			return $log->data[0];
		}
?>
    <table width="100%" cellpadding="10" cellspacing="0" id="det">
         <tr>
            <td colspan="3">
                <a href="../bin_admin/class_list.php?page=1&sid=<?php echo $class; ?>" id="back">Back to List</a>
                <a href="../bin_admin/v_class.php?a=reset&n=<?php echo $log->data['id']; ?>" id="reset">Reset Password</a>
            </td>
        </tr>
        <tr>
            <th colspan="2"><?php echo $name; ?></th><th>View Profile</th>
        </tr>
        <tr>
            <td rowspan="6" width="30%">
                      <?php echo (($pp != "")?
                            "<img id=\"pp\" src=\"". $pp ."\" alt=\"". $log->data['username'] ."\" />":
                            "<img id=\"pp\" src=\"../img/mono-icons/user32.png\" alt=\"". $log->data['username'] ."\" />") ?>
            </td>
            <td align="right">Student ID:</td><td><?php echo $log->data['username']; ?></td>
        </tr>
        <tr>
            <td align="right">Full Name:</td><td><?php echo $name; ?></td>
        </tr>
        <tr>
            <td align="right">Date of Birth:</td><td><?php echo $age; ?> </td>
        </tr>
        <tr>
            <td align="right">Address:</td><td><?php echo $address; ?></td>
        </tr>
        <tr>
            <td align="right">Parent Name:</td><td><?php echo $pn; ?></td>
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
        <tr>
            <td></td><td align="right">Class:</td><td><?php echo getClass($class); ?></td>
        </tr>
        <tr>
            <td></td><td align="right">Admission Status:</td><td> <?php echo getStatus($status); ?> </td>
        </tr>
    </table>

<script type="text/javascript">
$(document).ready(function(){
	function showLoader(){
	
		$('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
        hideLoader;
	var Timer  = '';
	var selecter = 0;
	var Main =0;
	
	bring(selecter);
        
         $('#det tr td a').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());              
               e.preventDefault();
	});
        
        
        
        $('#det tr td a#back').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());
               $("#paging_button").show();               
               e.preventDefault();
	});
	
});
function editpix(us){
             //showLoader();
             //var link = this.href; 
               $("#show").load("../bin_admin/uploadpic_stu.php?user=" + us +"&name=" + us);
               $("#mwindow").show();
               $("#paging_button").show();
               //hideLoader();
	};
</script>