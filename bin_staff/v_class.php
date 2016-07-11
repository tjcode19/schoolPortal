<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();

/* Resets Password to default */
if(isset($_REQUEST['a'])){
$log->set_sqlstr("SELECT priority FROM authentication WHERE id ='". $_REQUEST['n'] ."'"); 
    $log->querydata();
    
    if($log->data[0] == 1){
      $pass = md5('student');
        $log->set_sqlstr("UPDATE authentication SET Password='" . $pass . "' WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();  
    }
}
/* Resets Password to default End */

/* Deactivate User */
if(isset($_REQUEST['a']) && $_REQUEST['a']=='deactivate'){
        $log->set_sqlstr("UPDATE auth_tab SET Status='Inactive' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("UPDATE admission_details SET AdmissionStatus='Inactive' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("UPDATE status SET Status='Inactive' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
}
/* Deactivate User End */

/* Deactivate User */
if(isset($_REQUEST['a']) && $_REQUEST['a']=='activate'){
        $log->set_sqlstr("UPDATE auth_tab SET Status='Active' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        $log->set_sqlstr("UPDATE admission_details SET AdmissionStatus='Active' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        $log->set_sqlstr("UPDATE status SET Status='Active' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
}
/* Deactivate User End */

 $log->set_sqlstr("SELECT * FROM student_data WHERE id ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        $name = $log->data['last_name']." ".$log->data['first_name']." ".$log->data['other_name'];
        $age = $log->data['date_of_birth'];
        $address = $log->data['residential_address'];
        $phone = $log->data['parent_phone'];
        $bg= $log->data['blood_group'];
        $ht= $log->data['height'];
        $email= $log->data['parent_email'];
        $pp= $log->data['passport'];
		$class = $log->data['class'];
        $pn = $log->data['parent_name'];
		$status = 2;
		
	function getUser($id){
		$log = new login();
		$log->database();
		$log->set_sqlstr("select username FROM authentication WHERE id='".$id."'");
		$log->querydata();
		return $log->data[0];
	}
	function getCl($id){
		$log = new login();
		$log->database();
		$log->set_sqlstr("select name FROM class WHERE id='".$id."'");
		$log->querydata();
		return $log->data[0];
	}
       
?>
    <table width="100%" cellpadding="10" cellspacing="0" id="det">
         <tr>
            <td colspan="3">
                <a href="../bin_staff/class_list1.php?page=1&sid=<?php echo $class; ?>" id="back">Back to List</a>
                <a href="../bin_staff/v_class.php?a=reset&n=<?php echo $log->data['id']; ?>" id="reset">Reset Password</a>
            </td>
        </tr>
        <tr>
            <th colspan="2"><?php echo $name; ?></th><th>View Profile</th>
        </tr>
        <tr>
            <td rowspan="6" width="30%">
                      <?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     $log->database();
  
        $log->set_sqlstr("SELECT * FROM school_profile"); 
        $log->querydata();
		$t = $log->data[1];
		$s = $log->data[2];
		
		$log->set_sqlstr("SELECT * FROM calender WHERE term ='".$t."' AND session='".$s."'"); 
        $log->querydata();
		
		function getSes($ss){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM session WHERE id ='". $ss."'"); 
			$log->querydata();
			return $log->data[0];
		}
		function getTerm($t){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM term WHERE id ='". $t."'"); 
			$log->querydata();
			return $log->data[0];
		}
		function getEvent($t){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM event WHERE id ='". $t."'"); 
			$log->querydata();
			return $log->data[0];
		}
?>
<table width="100%" cellpadding="10" cellspacing="0" id="mai">
	<tr>
		<th><h4>Session:</h4></th>
		<th><?php echo getSes($s); ?></th>
		<th ><h4>Term:</h4></th>
		<th><?php echo getTerm($t); ?></th>
	</tr>
</table>
<table width="100%" cellpadding="10" cellspacing="0" id="mai">
	<tr>
		<th width="2%">ID</th>
		<th width="18%">Event</th>
		<th width="20%">Description</th>
		<th width="20%">Start Date</th>
		<th width="20%">End Date</th>
		<th width="20%">Time</th>
	</tr>
	<?php  for($i=0; $i < $log->no_rec; $i++){ ?>                            
							
	<tr>
		<td><?php echo ($i+1); ?></td>
		<td><?php echo getEvent($log->data[1]); ?></td>
		<td><?php echo $log->data[2]; ?></td>
		<td><?php echo $log->data[3]; ?></td>
		<td><?php echo $log->data[5]; ?></td>
		<td><?php echo $log->data[4]; ?> - <?php echo $log->data[6]; ?></td>
	</tr>
	<?php $log->fetchdata(); } ?>
</table>
            </td>
            <td align="right">Student ID:</td><td><?php echo getUser($log->data['id']); ?></td>
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
            <td></td><td align="right">Class:</td><td><?php echo getCl($class); ?></td>
        </tr>
        <tr>
            <td></td><td align="right">Admission Status:</td><td> <?php echo ($status == 1)?"Inactive":"Active"; ?> </td>
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
               $("#show").load("../bin_staff/uploadpic_stu.php?user=" + us +"&name=" + us);
               $("#mwindow").show();
               $("#paging_button").show();
               //hideLoader();
	};
</script>