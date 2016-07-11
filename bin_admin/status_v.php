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

 $log->set_sqlstr("SELECT * FROM student_data WHERE Username ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        $name = $log->data['Surname']." ".$log->data['Firstname']." ".$log->data['Other'];
             
        
        $log->set_sqlstr("SELECT * FROM status WHERE Username ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        
        function Grade($e){
            return (($e == "A")?"Excellent":
                (($e == "B")?"Very Good":
                    (($e == "C")?"Good":
                        (($e == "D")?"Fair":
                            (($e == "E")?"Poor":"Very Poor")))));
        }
?>
    
<table width="100%" cellpadding="10" cellspacing="0" id="det">
<tr>
    <td colspan="2">
        <a href="../bin_admin/student_s_list.php?page=1" id="back">Back to List</a>
        <a href="../bin_admin/status_u.php?n=<?php echo $log->data['Username']; ?>" id="edit">Edit</a>
    </td>
</tr>
<tr>
    <th colspan="2">Status & Eligibility for <?php echo $name; ?></th>
</tr>
<tr>
    <td align="right">Student Name:</td><td><?php echo $name; ?></td>
</tr>
<tr>
    <td align="right">Admission Status:</td><td> <?php echo $log->data[16]; ?> </td>
</tr>
 <tr>
    <td align="right">Punctuality:</td><td><?php echo Grade($log->data[2]); ?></td>
</tr>
<tr>
    <td align="right">Class Attendance:</td><td><?php echo Grade($log->data[3]); ?></td>
</tr>
<tr>
    <td align="right">Carry Out Of Assignment:</td><td><?php echo Grade($log->data[4]); ?></td>
</tr>
<tr>
    <td align="right">Neatness:</td><td><?php echo Grade($log->data[6]); ?></td>
</tr>
<tr>
    <td align="right">Politeness:</td><td> <?php echo Grade($log->data[5]); ?> </td>
</tr>
<tr>
    <td align="right">Relationship With Staff:</td><td> <?php echo Grade($log->data[7]); ?> </td>
</tr>
<tr>
    <td align="right">Relationship With Student:</td><td> <?php echo Grade($log->data[8]); ?> </td>
</tr>
<tr>
    <td align="right">Attentiveness In Class:</td><td><?php echo Grade($log->data[1]); ?></td>
</tr>
<tr>
    <td align="right">Initiative:</td><td><?php echo Grade($log->data[9]); ?></td>
</tr>
<tr>
    <td align="right">Emotional Stability:</td><td> <?php echo Grade($log->data[10]); ?> </td>
</tr>
<tr>
    <td align="right">Attitude to Study:</td><td><?php echo Grade($log->data[11]); ?></td>
</tr>
<tr>
    <td align="right">Attitude to School:</td><td><?php echo Grade($log->data[12]); ?></td>
</tr>
<tr>
    <td align="right">Manual Skill:</td><td> <?php echo Grade($log->data[13]); ?> </td>
</tr>
<tr>
    <td align="right">Club & Societies:</td><td><?php echo Grade($log->data[14]); ?></td>
</tr>
<tr>
    <td align="right">Class Teacher's remark:</td><td><?php echo $log->data[15]; ?></td>
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
