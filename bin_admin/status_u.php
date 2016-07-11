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
 <form action="#" method="post" id="m">   
<table width="100%" cellpadding="10" cellspacing="0" id="det">
<tr>
    <td colspan="2">
        <a href="../bin_admin/student_s_list.php?page=1" id="back">Back to List</a>
        <a href="../bin_admin/status_v.php?n=<?php echo $log->data['Username']; ?>" id="edit">View</a>
    </td>
</tr>
<tr>
    <th colspan="2">Status & Eligibility for <?php echo $name; ?></th>
</tr>
<tr>
    <td align="right">Student Name:</td><td><?php echo $name; ?>
    <input type="hidden" name="sid" id="sid" value="<?php echo $log->data['Username']; ?>"> </td>
</tr>
<tr>
    <td align="right">Admission Status:</td><td> <?php echo $log->data[16]; ?> </td>
</tr>
 <tr>
    <td align="right">Punctuality:</td><td>
        <select name="col2" id="col2">
            <option value="A" <?php echo (($log->data[2] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[2] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[2] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[2] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[2] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[2] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Class Attendance:</td><td>
        <select name="col3" id="col3">
            <option value="A" <?php echo (($log->data[3] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[3] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[3] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[3] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[3] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[3] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Carry Out Of Assignment:</td><td>
        <select name="col4" id="col4">
            <option value="A" <?php echo (($log->data[4] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[4] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[4] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[4] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[4] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[4] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Neatness:</td><td>
        <select name="col6" id="col6">
            <option value="A" <?php echo (($log->data[6] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[6] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[6] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[6] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[6] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[6] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Politeness:</td><td> 
        <select name="col5" id="col5">
            <option value="A" <?php echo (($log->data[5] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[5] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[5] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[5] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[5] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[5] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Relationship With Staff:</td><td>
        <select name="col7" id="col7">
            <option value="A" <?php echo (($log->data[7] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[7] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[7] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[7] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[7] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[7] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Relationship With Student:</td><td>
        <select name="col8" id="col8">
            <option value="A" <?php echo (($log->data[8] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[8] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[8] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[8] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[8] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[8] == "F")?"selected":""); ?>>Very Poor</option>
        </select> </td>
</tr>
<tr>
    <td align="right">Attentiveness In Class:</td><td>
        <select name="col" id="col">
            <option value="A" <?php echo (($log->data[1] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[1] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[1] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[1] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[1] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[1] == "F")?"selected":""); ?>>Very Poor</option>
        </select>
    </td>
</tr>
<tr>
    <td align="right">Initiative:</td><td>
        <select name="col9" id="col9">
            <option value="A" <?php echo (($log->data[9] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[9] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[9] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[9] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[9] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[9] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Emotional Stability:</td><td>
        <select name="col10" id="col10">
            <option value="A" <?php echo (($log->data[10] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[10] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[10] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[10] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[10] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[10] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Attitude to Study:</td><td>
        <select name="col11" id="col11">
            <option value="A" <?php echo (($log->data[11] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[11] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[11] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[11] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[11] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[11] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Attitude to School:</td><td>
        <select name="col12" id="col12">
            <option value="A" <?php echo (($log->data[12] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[12] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[12] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[12] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[12] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[12] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Manual Skill:</td><td> 
        <select name="col13" id="col13">
            <option value="A" <?php echo (($log->data[13] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[13] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[13] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[13] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[13] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[13] == "F")?"selected":""); ?>>Very Poor</option>
        </select> </td>
</tr>
<tr>
    <td align="right">Club & Societies:</td><td>
        <select name="col14" id="col14">
            <option value="A" <?php echo (($log->data[14] == "A")?"selected":""); ?>>Excellent</option>
            <option value="B" <?php echo (($log->data[14] == "B")?"selected":""); ?>>Very Good</option>
            <option value="C" <?php echo (($log->data[14] == "C")?"selected":""); ?>>Good</option>
            <option value="D" <?php echo (($log->data[14] == "D")?"selected":""); ?>>Fair</option>
            <option value="E" <?php echo (($log->data[14] == "E")?"selected":""); ?>>Poor</option>
            <option value="F" <?php echo (($log->data[14] == "F")?"selected":""); ?>>Very Poor</option>
        </select></td>
</tr>
<tr>
    <td align="right">Class Teacher's remark:</td><td>
        <textarea cols="30" rows="3" name="col15" id="col15" ><?php echo $log->data[15]; ?></textarea></td>
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
            url : "../bin_admin/update_status.php",
            type: "POST",
            data : postData,
            dataType: 'html',
            success:function(d)
            {
                //data: return data from server  
                alert("Data Updated Successfully");
                $("#content").load("../bin_admin/status_v.php?n="+ d, hideLoader()); 
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
