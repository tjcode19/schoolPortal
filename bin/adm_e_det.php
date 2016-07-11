<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();

/* Resets Password to default */
if(isset($_REQUEST['a']) && $_REQUEST['a']=='reset'){
$log->set_sqlstr("SELECT Priority FROM auth_tab WHERE Username ='". $_REQUEST['n'] ."'"); 
    $log->querydata();
    
    if($log->data[0] == 'admin'){
      $pass = md5('admin');
        $log->set_sqlstr("UPDATE auth_tab SET Password='" . $pass . "' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();  
    }
}
/* Resets Password to default End */

/* Deactivate User */
if(isset($_REQUEST['a']) && $_REQUEST['a']=='deactivate'){
        $log->set_sqlstr("UPDATE auth_tab SET Status='Inactive' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("UPDATE emp_details SET EmpStatus='Inactive' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
}
/* Deactivate User End */

/* Deactivate User */
if(isset($_REQUEST['a']) && $_REQUEST['a']=='activate'){
        $log->set_sqlstr("UPDATE auth_tab SET Status='Active' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        $log->set_sqlstr("UPDATE emp_details SET EmpStatus='Active' WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
}
/* Deactivate User End */

 $log->set_sqlstr("SELECT * FROM admin_data WHERE Username ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        $tit = $log->data['Title'];
        $name = $log->data['Fullname'];
        $name1 = $log->data['Title']." ".$log->data['Fullname'];
        $age = $log->data['Age'];
        $address = $log->data['Address'];
        $phone = $log->data['Phone'];
        $bg= $log->data['BloodG'];
        $ht= $log->data['Height'];
        $email= $log->data['Email'];
        $pp= $log->data['Passport'];
        $sb = $log->data['Subjects'];
        $po = $log->data['Position'];
        
        $log->set_sqlstr("SELECT * FROM emp_details WHERE Username ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        $ql = $log->data['Qualification'];
        $yemp = $log->data['YearOfEmp'];
        $yexp = $log->data['YearOfExp'];
        $class = $log->data['ClassInCharge'];
        $status = $log->data['EmpStatus'];
?>
 <form id="m" action="" method="post">
    <table width="100%" cellpadding="10" cellspacing="0" id="det">       
         <tr>
            <td colspan="3">
                <a href="../bin/admin_list.php?page=1" id="back">Back to List</a>
                <a href="../bin/adm_v_det.php?n=<?php echo $log->data['Username']; ?>" id="edit">View</a>
                <?php echo (($status == 'Active')?
                        "<a href=\"../bin/adm_e_det.php?a=deactivate&n=". $log->data['Username'] ."\" id=\"deactivate\">Deactivate</a>":
                        "<a href=\"../bin/adm_e_det.php?a=activate&n=". $log->data['Username'] ."\" id=\"activate\">Activate</a>"); ?>
                <a href="../bin/adm_e_det.php?a=reset&n=<?php echo $log->data['Username']; ?>" id="reset">Reset Password</a>
            </td>
        </tr>
        <tr>
            <th colspan="2"><?php echo $name1; ?></th><th>Edit Profile</th>
        </tr>
        <tr>
            <td rowspan="6" width="30%">
                <a href="<?php echo $pp; ?>" class="thumb" data-rel="prettyPhoto">
                    <img id="pp" src="<?php echo $pp; ?>" alt="<?php echo $_SESSION['s_portal_id']; ?>" />
                </a>
            </td>
            <td align="right">Admin ID:</td><td><?php echo $log->data['Username']; ?></td>
        </tr>
        <tr>
            <td align="right">Full Name:</td><td>
                 <select name="tit">
                        <option value="Dr." <?php echo (($tit == 'Dr.')?"Selected":""); ?>>Dr.</option>
                        <option value="Mr." <?php echo (($tit == 'Mr.')?"Selected":""); ?>>Mr.</option>
                        <option value="Mrs." <?php echo (($tit == 'Mrs.')?"Selected":""); ?>>Mrs.</option>
                        <option value="Miss" <?php echo (($tit == 'Miss')?"Selected":""); ?>>Miss</option>
                    </select>
                <input type="text" name="fname" value="<?php echo $name; ?>" size="10" >
                <input type="hidden" name="id" value="<?php echo $log->data['Username']; ?>" >
            </td>
        </tr>
        <tr>
            <td align="right">Age:</td><td>
                <select name="age">
                        <option value=""> Age</option>
                         <?php 
                        for($i=15; $i <= 60; $i++){
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
            <td align="right">Phone Number:</td><td><input type="text" name="ph" value="<?php echo $phone; ?>" size="20" ></td>
        </tr>
        <tr>
            <td align="right">Email:</td><td><input type="text" name="email" value="<?php echo $email; ?>" size="20" ></td>
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
             <td></td><td align="right">Qualification:</td><td><input type="text" name="ql" value="<?php echo $ql; ?>" size="20" ></td>
        </tr>
        <tr>
            <td></td><td align="right">Year Of Employment:</td><td>
                <select name="yemp">
                        <?php 
                        $presentYear = date('Y');
                        $sY = $presentYear-20;
                        for($i=$presentYear; $i >= $sY; $i--){
                           echo "<option value=\"".$i."\""; echo (($yemp==$i)?"selected":""); echo ">".$i."</option>";    
                        }
                        ?>
                    </select>
            </td>
        </tr>
        <tr>
            <td></td><td align="right">Years of Experience:</td><td>
                <select name="yexp" id="yexp">
                         <?php 
                        for($i=1; $i <= 60; $i++){
                           echo "<option value=\"".$i."\""; echo (($yexp==$i)?"selected":""); echo ">".$i."</option>";  
                        }
                        ?>
                    </select>YEARS
            </td>
        </tr>
        <tr>
            <td></td><td align="right">Class:</td><td>
                 <select name="cl" id="cl">
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
            <td></td><td align="right">Subject:</td><td><input type="text" name="sb" value="<?php echo $sb; ?>" size="20" ></td>
        </tr>
        <tr>
            <td></td><td align="right">Post:</td>
            <td>Admin</td>
        </tr>
        <tr>
            <td></td><td align="right">Employment Status:</td><td> <?php echo $status; ?> </td>
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
        url : "../bin/update_staff.php",
        type: "POST",
        data : postData,
        dataType: 'html',
        success:function(d)
        {
            //data: return data from server
            //$('#succ').fadeIn(3000);
            alert('Data Updated');
            $('input#up').val('Data Updated!');
            $("#content").load("../bin/adm_v_det.php?n="+ d, hideLoader());
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