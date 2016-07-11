<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();

/* Resets Password to default */
if(isset($_REQUEST['a']) && $_REQUEST['a']=='reset'){
$log->set_sqlstr("SELECT priority FROM authentication WHERE id ='". $_REQUEST['n'] ."'"); 
    $log->querydata();
    
    if($log->data[0] == 'staff'){
      $pass = md5('staff');
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
        $log->set_sqlstr("UPDATE authentication SET Status=2 WHERE id= '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
}
/* Deactivate User End */

 $log->set_sqlstr("SELECT * FROM authentication INNER JOIN staff_data ON authentication.id=staff_data.id WHERE staff_data.id ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
		$tit = $log->data['title'];
        $fname = $log->data['first_name'];
		$lname = $log->data['last_name'];
		$oname = $log->data['other_name'];
        $age = $log->data['date_of_birth'];
        $address = $log->data['residential_address'];
        $phone = $log->data['phone'];
        $bg= $log->data['blood_group'];
        $ht= $log->data['height'];
        $email= $log->data['email'];
		$status= $log->data['status'];
        $pp= $log->data['passport'];
        $po = $log->data['position'];
		$class = $log->data['class_in_charge'];
		
		function getStatus($st){
			if($st == 1){$status = "Inactive";}
			elseif($st == 2){$status = "Active";}
			elseif($st == 0){$status = "Raw";}
			elseif($st == 3){$status = "Locked";}
			return $status;
		}
?>
 <form id="m" action="" method="post">
    <table width="100%" cellpadding="5" cellspacing="0" id="det">       
         <tr>
            <td colspan="3">
                <a href="../bin_admin/staff_list.php?page=1" id="back">Back to List</a>
                <a href="../bin_admin/v_s_det.php?n=<?php echo $log->data['id']; ?>" id="edit">View</a>
                <?php echo (($status == 2)?
                        "<a href=\"../bin_admin/v_s_det.php?a=deactivate&n=". $log->data['id'] ."\" id=\"deactivate\">Deactivate</a>":
                        "<a href=\"../bin_admin/v_s_det.php?a=activate&n=". $log->data['id'] ."\" id=\"activate\">Activate</a>"); ?>
                <a href="../bin_admin/e_s_det.php?a=reset&n=<?php echo $log->data['id']; ?>" id="reset">Reset Password</a>
				<img src="../img/loader.gif" id="loading-img" style="display:none;width:25px;height:25px;" alt="Please Wait"/>
            </td>
        </tr>
        <tr>
            <th colspan="2"><?php echo $fname; ?></th><th>Edit Profile</th>
        </tr>
        <tr>
            <td rowspan="6" width="25%">
                <img id="pp" src="<?php echo $pp; ?>" alt="<?php echo $log->data['username']; ?>" />
            </td>
            <td align="right">Staff ID:</td><td><?php echo $log->data['username']; ?></td>
        </tr>
        <tr>
            <td align="right">First Name:</td><td>
                 <select name="tit">
                        <option value="Dr." <?php echo (($tit == 'Dr.')?"Selected":""); ?>>Dr.</option>
                        <option value="Mr." <?php echo (($tit == 'Mr.')?"Selected":""); ?>>Mr.</option>
                        <option value="Mrs." <?php echo (($tit == 'Mrs.')?"Selected":""); ?>>Mrs.</option>
                        <option value="Miss" <?php echo (($tit == 'Miss')?"Selected":""); ?>>Miss</option>
                    </select>
                <input type="text" name="fname" value="<?php echo $fname; ?>" size="20" >
                <input type="hidden" name="id" value="<?php echo $log->data['id']; ?>" >
            </td>
        </tr>
		 <tr>
            <td align="right">Surname Name:</td><td>
                <input type="text" name="lname" value="<?php echo $lname; ?>" size="20" >
            </td>
        </tr>
		<tr>
            <td align="right">Other Name:</td><td>
                <input type="text" name="oname" value="<?php echo $oname; ?>" size="20" >
            </td>
        </tr>
        <tr>
            <td align="right">Date of Birth:</td><td>
                <input name="dob" id="dob" type="text" size="20" value="<?php echo $age; ?>">
            </td>
        </tr>
        <tr>
            <td align="right">Address:</td><td><textarea name="address"><?php echo $address; ?></textarea></td>
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
            <td></td><td align="right">Class:</td><td>
                 <select name="cl">
                        <?php 
                        $log->set_sqlstr("SELECT * FROM class"); 
                        $log->querydata();                        
                        for($i=0; $i < $log->no_rec; $i++){
                           echo "<option value=\"".$log->data[0]."\""; echo (($log->data[0]==$class)?"selected":""); echo ">".$log->data[1]."</option>"; 
                           $log->fetchdata();
                        }
                        ?>
                    </select>
            </td>
        </tr>
        <tr>
            <td></td><td align="right">Post:</td><td>
			 <select name="po">
				<?php 
				$log->set_sqlstr("SELECT * FROM position"); 
				$log->querydata();                        
				for($i=0; $i < $log->no_rec; $i++){
				   echo "<option value=\"".$log->data[0]."\""; echo (($log->data[0]==$po)?"selected":""); echo ">".$log->data[1]."</option>"; 
				   $log->fetchdata();
				}
				?>
			</select>
			</td>
        </tr>
        <tr>
            <td></td><td align="right">Employment Status:</td><td> <?php echo getStatus($status); ?> </td>
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
            $('#loading-img').css('display','inline');
             var link = this.href; 
               $("#content").load(link);            
               e.preventDefault();
	});
        
          $('#det tr td a#back').click(function(e){
             $('#loading-img').css('display','inline');
             var link = this.href; 
               $("#content").load(link);
               $("#paging_button").show();               
               e.preventDefault();
	});
	
	 $('#dob').datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'd-m-yy'
      });
        
   //callback handler for select change of option for state
   $('#m').submit(function(e) {
		$('#loading-img').css('display','inline');
       $('input#up').val('Loading...');
    var postData = $(this).serializeArray();
    //var formURL = $(this).attr("action");
    $.ajax(
    {
        url : "../bin_admin/update_staff.php",
        type: "POST",
        data : postData,
        dataType: 'html',
        success:function(d)
        {
            //data: return data from server
            //$('#succ').fadeIn(3000);
            alert('Data Updated');
            $('input#up').val('Data Updated!');
            $("#content").load("../bin_admin/v_s_det.php?n="+ d);
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