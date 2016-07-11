<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();

/* Resets Password to default */
if(isset($_REQUEST['a'])){
$log->set_sqlstr("SELECT Priority FROM auth_tab WHERE Username ='". $_REQUEST['n'] ."'"); 
    $log->querydata();
    
    if($log->data[0] == 'student'){
      $pass = md5('student');
        $log->set_sqlstr("UPDATE auth_tab SET Password='" . $pass . "' WHERE Username = '" . $_REQUEST['n'] . "'");
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
		
		$log->set_sqlstr("SELECT status FROM authentication WHERE id ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
		$status = (($log->data[0] == 1)?"Inactive":"Active");
		
		$log->set_sqlstr("SELECT * FROM student_data WHERE id ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        $name = $log->data['last_name']." ".$log->data['first_name']." ".$log->data['other_name'];
             
        
        $log->set_sqlstr("SELECT * FROM behaviouralattitude WHERE student_id ='". $_REQUEST['n'] ."' "); 
        $log->querydata();
        
        function Grade($e){
            return (($e == 1)?"Excellent":
                (($e == 2)?"Very Good":
                    (($e == 3)?"Good":
                        (($e == 4)?"Fair":
                            (($e == 5)?"Poor":"Very Poor")))));
        }
?>
    
<table width="100%" cellpadding="10" cellspacing="0" id="det">
<tr>
    <td colspan="2">
        <a href="../bin_staff/student_s_list.php?page=1" id="back">Back to List</a>
        <a href="../bin_staff/status_u.php?n=<?php echo  $_REQUEST['n'] ; ?>&c=<?php echo  $_REQUEST['c'] ; ?>" id="edit">Edit</a>
    </td>
</tr>
<tr>
    <th colspan="2">Status & Eligibility for <?php echo $name; ?></th>
</tr>
<tr>
    <td align="right">Student Name:</td><td><?php echo $name; ?></td>
</tr>
<tr>
    <td align="right">Admission Status:</td><td> <?php echo $status; ?> </td>
</tr>
 <tr>
    <td align="right">Punctuality:</td><td><?php echo Grade($log->data[6]); ?></td>
</tr>
<tr>
    <td align="right">Neatness:</td><td><?php echo Grade($log->data[7]); ?></td>
</tr>
<tr>
    <td align="right">Relationship with student:</td><td><?php echo Grade($log->data[8]); ?></td>
</tr>
<tr>
    <td align="right">Relationship with staff:</td><td><?php echo Grade($log->data[9]); ?></td>
</tr>
<tr>
    <td align="right">Initiative:</td><td> <?php echo Grade($log->data[10]); ?> </td>
</tr>
<tr>
    <td align="right">Emotional Stability:</td><td> <?php echo Grade($log->data[11]); ?> </td>
</tr>
<tr>
    <td align="right">Sociality:</td><td> <?php echo Grade($log->data[12]); ?> </td>
</tr>
<tr>
    <td align="right">Attentiveness:</td><td><?php echo Grade($log->data[13]); ?></td>
</tr>
<tr>
    <td align="right">Attendance:</td><td><?php echo Grade($log->data[14]); ?></td>
</tr>
<tr>
    <td align="right">Politeness:</td><td> <?php echo Grade($log->data[5]); ?> </td>
</tr>
<tr>
    <td align="right">Others:</td><td><?php echo Grade($log->data[15]); ?></td>
</tr>
<tr>
    <td align="right">Class Teacher's remark:</td><td><?php echo $log->data[16]; ?></td>
</tr>
<tr>
    <td align="right">Head Teacher's remark:</td><td><?php echo $log->data[17]; ?></td>
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
</script>
