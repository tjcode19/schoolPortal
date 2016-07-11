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
         
		$log->set_sqlstr("SELECT * FROM school_profile"); 
        $log->querydata();
		$t = $log->data[1];
		$s = $log->data[2];
        
        $log->set_sqlstr("SELECT * FROM behaviouralattitude WHERE student_id ='". $_REQUEST['n'] ."' AND term='".$t."' AND session='".$s."'"); 
        $log->querydata();
        
        function Grade($e){
            return (($e == 1)?"Excellent":
                (($e == 2)?"Very Good":
                    (($e == 3)?"Good":
                        (($e == 4)?"Fair":
                            (($e == 5)?"Poor":"Very Poor")))));
        }
?>
 <form action="#" method="post" id="m">   
<table width="100%" cellpadding="10" cellspacing="0" id="det">
<tr>
    <td colspan="2">
        <a href="../bin_staff/student_s_list.php?page=1" id="back">Back to List</a>
        <a href="../bin_staff/status_v.php?n=<?php echo $_REQUEST['n']; ?>&c=<?php echo  $_REQUEST['c'] ; ?>" id="edit">View</a>
    </td>
</tr>
<tr>
    <th colspan="2">Status & Eligibility for <?php echo $name; ?></th>
</tr>
<tr>
    <td align="right">Student Name:</td><td><?php echo $name; ?>
    <input type="hidden" name="sid" id="sid" value="<?php echo $_REQUEST['n']; ?>">
	<input type="hidden" name="cl" id="cl" value="<?php echo $_REQUEST['c']; ?>"></td>
</tr>
<tr>
    <td align="right">Admission Status:</td><td> <?php echo $status; ?> </td>
</tr>
 <tr>
    <td align="right">Term/Session</td>
	<td>
        <select name="term" id="term">
		<option value="0">Select Term</option>
		<?php 
			$log->set_sqlstr("SELECT * FROM term"); 
			$log->querydata();
			
			for($i = 0; $i < $log->no_rec; $i++){
		
		?>
            <option value="<?php echo $log->data[0]; ?>"><?php echo $log->data[1]; ?></option>
			
		<?php $log->fetchdata(); } ?>	
        </select>
		<select name="sess" id="sess">
		<option value="0">Select Session</option>
		<?php 
			$log->set_sqlstr("SELECT * FROM session"); 
			$log->querydata();
			
			for($i = 0; $i < $log->no_rec; $i++){
		
		?>
            <option value="<?php echo $log->data[0]; ?>"><?php echo $log->data[1]; ?></option>
			
		<?php $log->fetchdata(); } ?>	
        </select>
	</td>
</tr>
<tr>
    <td align="right">Puctuality:</td><td>
        <select name="col2" id="col2">
            <option value="1" <?php echo (($log->data[6] == 1)?"selected":""); ?>>Excellent</option>
            <option value="2" <?php echo (($log->data[6] == 2)?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[6] == 3)?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[6] == 4)?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[6] == 5)?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[6] == 6)?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Neatness:</td><td>
        <select name="col3" id="col3">
            <option value="1" <?php echo (($log->data[7] == 1)?"selected":""); ?>>Excellent</option>
            <option value="2" <?php echo (($log->data[7] == 2)?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[7] == 3)?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[7] == 4)?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[7] == 5)?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[7] == 6)?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Relationship with student:</td><td>
        <select name="col4" id="col4">
			<option value="1" <?php echo (($log->data[8] == 1)?"selected":""); ?>>Excellent</option>
            <option value="2" <?php echo (($log->data[8] == 2)?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[8] == 3)?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[8] == 4)?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[8] == 5)?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[8] == 6)?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Relationship with staff:</td><td> 
        <select name="col5" id="col5">
            <option value="1" <?php echo (($log->data[9] == 1)?"selected":""); ?>>Excellent</option>
            <option value="2" <?php echo (($log->data[9] == 2)?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[9] == 3)?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[9] == 4)?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[9] == 5)?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[9] == 6)?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Initiative:</td><td>
        <select name="col6" id="col6">
            <option value="1" <?php echo (($log->data[10] == 1)?"selected":""); ?>>Excellent</option>
            <option value="2" <?php echo (($log->data[10] == 2)?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[10] == 3)?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[10] == 4)?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[10] == 5)?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[10] == 6)?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Emotional Stability:</td><td>
        <select name="col7" id="col7">
            <option value="1" <?php echo (($log->data[11] == "1")?"selected":""); ?>>Excellent</option>
            <option value="1" <?php echo (($log->data[11] == "1")?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[11] == "3")?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[11] == "4")?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[11] == "5")?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[11] == "6")?"selected":""); ?>>Very Poor</option>
        </select> </td>
</tr>
<tr>
    <td align="right">Sociality:</td><td>
        <select name="col8" id="col8">
            <option value="1" <?php echo (($log->data[12] == "1")?"selected":""); ?>>Excellent</option>
            <option value="1" <?php echo (($log->data[12] == "1")?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[12] == "3")?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[12] == "4")?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[12] == "5")?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[12] == "6")?"selected":""); ?>>Very Poor</option>
        </select>
    </td>
</tr>
<tr>
    <td align="right">Attentiveness:</td><td>
        <select name="col9" id="col9">
            <option value="1" <?php echo (($log->data[13] == "1")?"selected":""); ?>>Excellent</option>
            <option value="1" <?php echo (($log->data[13] == "1")?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[13] == "3")?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[13] == "4")?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[13] == "5")?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[13] == "6")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Attendance:</td><td>
        <select name="col10" id="col10">
			<option value="1" <?php echo (($log->data[14] == "1")?"selected":""); ?>>Excellent</option>
            <option value="1" <?php echo (($log->data[14] == "1")?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[14] == "3")?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[14] == "4")?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[14] == "5")?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[14] == "6")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Politeness:</td>
	<td>
		<select name="col" id="col">
            <option value="1" <?php echo (($log->data[5] == "1")?"selected":""); ?>>Excellent</option>
            <option value="1" <?php echo (($log->data[5] == "1")?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[5] == "3")?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[5] == "4")?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[5] == "5")?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[5] == "6")?"selected":""); ?>>Very Poor</option>
        </select>
	</td>
</tr>
<tr>
    <td align="right">Others:</td><td>
        <select name="col11" id="col11">
            <option value="1" <?php echo (($log->data[15] == "1")?"selected":""); ?>>Excellent</option>
            <option value="1" <?php echo (($log->data[15] == "1")?"selected":""); ?>>Very Good</option>
            <option value="3" <?php echo (($log->data[15] == "3")?"selected":""); ?>>Good</option>
            <option value="4" <?php echo (($log->data[15] == "4")?"selected":""); ?>>Fair</option>
            <option value="5" <?php echo (($log->data[15] == "5")?"selected":""); ?>>Poor</option>
            <option value="6" <?php echo (($log->data[15] == "6")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Class Teacher's remark:</td><td>
        <textarea cols="30" rows="3" name="col12" id="col12" ><?php echo $log->data[16]; ?></textarea></td>
</tr>
<tr>
    <td align="right">Head Teacher's remark:</td><td>
        <textarea cols="30" rows="3" name="col13" id="col13" ><?php echo $log->data[17]; ?></textarea></td>
</tr>
<tr>
    <th colspan="2">
        <input type="submit" value="Update Status" id="u" ></th>
</tr>
</table>
 </form>

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
        
        //callback handler for select change of option for state
       $('#m').submit(function(e) {
      showLoader();
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin_staff/update_status.php",
            type: "POST",
            data : postData,
            dataType: 'html',
            success:function(data)
            {
                //data: return data from server  
				var d = data.split("##");
                alert(d[2]);
                $("#content").load("../bin_staff/status_v.php?n="+ d[1] +"&c="+d[0], hideLoader()); 
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails  
                alert(textStatus);
            }
        });
        e.preventDefault(); //STOP default action
    });
	
});
</script>
