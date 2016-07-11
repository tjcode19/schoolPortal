<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();

/* Resets Password to default */
if(isset($_REQUEST['a']) && $_REQUEST['a']=='reset'){
$log->set_sqlstr("SELECT Priority FROM auth_tab WHERE Username ='". $_REQUEST['n'] ."'"); 
    $log->querydata();
    
    if($log->data[0] == 'student'){
      $pass = md5('staff');
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
        $sname = $log->data['Surname'];
        $fname = $log->data['Firstname'];
        $oname = $log->data['Other'];
        $age = $log->data['Age'];
        $address = $log->data['Address'];
        $phone = $log->data['ParentPhone'];
        $bg= $log->data['BloodG'];
        $ht= $log->data['Height'];
        $email= $log->data['Email'];
        $pp= $log->data['Passport'];
        $pn = $log->data['ParentName'];
       
        
        $log->set_sqlstr("SELECT * FROM admission_details WHERE Username ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        $ex = $log->data['ExtraActivity']; 
        $po = $log->data['PositionInClass'];
        $yamd = $log->data['YearOfAdmission'];
        $yog = $log->data['YearOfGraduation'];
        $class = $log->data['PresentClass'];        
        $status = $log->data['AdmissionStatus'];
?>
 <form id="m" action="" method="post">
    <table width="100%" cellpadding="10" cellspacing="0" id="det">       
         <tr>
            <td colspan="3">
                <a href="../bin_admin/student_list.php?page=1" id="back">Back to List</a>
                <a href="../bin_admin/v_st_det.php?n=<?php echo $log->data['Username']; ?>" id="edit">View</a>
                <?php echo (($status == 'Active')?
                        "<a href=\"../bin_admin/e_st_det.php?a=deactivate&n=". $log->data['Username'] ."\" id=\"deactivate\">Deactivate</a>":
                        "<a href=\"../bin_admin/e_st_det.php?a=activate&n=". $log->data['Username'] ."\" id=\"activate\">Activate</a>"); ?>
                <a href="../bin_admin/e_s_det.php?a=reset&n=<?php echo $log->data['Username']; ?>" id="reset">Reset Password</a>
            </td>
        </tr>
        <tr>
            <th colspan="2"><?php echo $sname." ".$fname." ".$oname; ?></th><th>Edit Profile</th>
        </tr>
        <tr>
            <td rowspan="6" width="30%">
                <img id="pp" src="<?php echo $pp; ?>" alt="<?php echo $_SESSION['s_portal_id']; ?>" />
            </td>
            <td align="right">Student ID:</td><td><?php echo $log->data['Username']; ?></td>
        </tr>
        <tr>
            <td align="right">Surname:</td><td>
                <input type="text" name="sname" value="<?php echo $sname; ?>" size="10" >
                <input type="hidden" name="id" value="<?php echo $log->data['Username']; ?>" >
            </td>
        </tr>
        <tr>
            <td align="right">Firstname:</td><td>
                <input type="text" name="fname" value="<?php echo $fname; ?>" size="10" >
            </td>
        </tr>
        <tr>
            <td align="right">Other name:</td><td>
                <input type="text" name="oname" value="<?php echo $oname; ?>" size="10" >
            </td>
        </tr>
        <tr>
            <td align="right">Age:</td><td>
                <select name="age">
                        <option value=""> Age</option>
                         <?php 
                        for($i=1; $i <= 30; $i++){
                           echo "<option value=\"".$i."\""; echo (($age==$i)?"selected":""); echo ">".$i."</option>";  
                        }
                        ?>
                    </select> YEARS
            </td>
        </tr>
        <tr>
            <td align="right">Address:</td><td><textarea name="address"><?php echo $address; ?></textarea></td>
        </tr>
        <tr>
            <td></td><td align="right">Parent Name:</td><td><input type="text" name="pn" value="<?php echo $pn; ?>" size="20" ></td>
        </tr>
        <tr>
            <td></td><td align="right">Phone Number:</td><td><input type="text" name="ph" value="<?php echo $phone; ?>" size="20" ></td>
        </tr>
        <tr>
            <td></td><td align="right">Email:</td><td><input type="text" name="email" value="<?php echo $email; ?>" size="20" ></td>
        </tr>
        <tr>
            <td></td><td align="right">Blood Group:</td><td><input type="text" name="bg" value="<?php echo $bg; ?>" size="20" ></td>
        </tr>
        <tr>
            <td></td><td align="right">Height:</td><td><input type="text" name="ht" value="<?php echo $ht; ?>" size="20" ></td>
        </tr>
        <tr>
            <th colspan="3">Other Details</th>
        </tr>
         <tr>
             <td></td><td align="right">Extra Curriculum Activity:</td><td><input type="text" name="ex" value="<?php echo $ex; ?>" size="20" ></td>
        </tr>
        <tr>
            <td></td><td align="right">Year Of Admission:</td><td>
                <select name="yamd">
                        <?php 
                        $presentYear = date('Y');
                        $sY = $presentYear-20;
                        for($i=$presentYear; $i >= $sY; $i--){
                           echo "<option value=\"".$i."\""; echo (($yamd==$i)?"selected":""); echo ">".$i."</option>";    
                        }
                        ?>
                    </select>
            </td>
        </tr>
        <tr>
            <td></td><td align="right">Year Of Graduation:</td><td>
                <select name="yog">
                        <?php 
                        $presentYr = date('Y');
                        $sYr = $presentYr+20;
                        for($i=$presentYr; $i <= $sYr; $i++){
                           echo "<option value=\"".$i."\""; echo (($yog==$i)?"selected":""); echo ">".$i."</option>";    
                        }
                        ?>
                    </select>
            </td>
        </tr>
        <tr>
            <td></td><td align="right">Class:</td><td>
                 <select name="cl">
                        <?php 
                        $log->set_sqlstr("SELECT Name FROM class"); 
                        $log->querydata();                        
                        for($i=0; $i < $log->no_rec; $i++){
                           echo "<option value=\"".$log->data[0]."\""; echo (($log->data[0]==$class)?"selected":""); echo ">".$log->data[0]."</option>"; 
                           $log->fetchdata();
                        }
                        ?>
                    </select>
            </td>
        </tr>
        <tr>
            <td></td><td align="right">Position In Class:</td><td><input type="text" name="po" value="<?php echo $po; ?>" size="20" ></td>
        </tr>
        <tr>
            <td></td><td align="right">Admission Status:</td><td> <?php echo $status; ?> </td>
        </tr>
        <tr align="center">
            <th colspan="3"><input type="submit" name="up" id="up" value="Update" ></th>
        </tr>
    </table> </form>
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
       $('input#up').val('Loading...');
    var postData = $(this).serializeArray();
    //var formURL = $(this).attr("action");
    $.ajax(
    {
        url : "../bin_admin/update_student.php",
        type: "POST",
        data : postData,
        dataType: 'html',
        success:function(d)
        {
            //data: return data from server
            //$('#succ').fadeIn(3000);
            alert('Data Updated');
            $('input#up').val('Data Updated!');
            $("#content").load("../bin_admin/v_st_det.php?n="+ d, hideLoader());
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