<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();

/* Resets Password to default */
if(isset($_REQUEST['a'])){
$log->set_sqlstr("SELECT Priority FROM auth_tab WHERE Username ='". $_REQUEST['n'] ."'"); 
    $log->querydata();
    
    if($log->data[0] == 'staff'){
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

 $log->set_sqlstr("SELECT * FROM staff_data WHERE Username ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        $name = $log->data['Title']." ".$log->data['Fullname'];
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
    <table width="100%" cellpadding="10" cellspacing="0" id="det">
         <tr>
            <td colspan="3">
                <a href="../bin_admin/staff_list.php?page=1" id="back">Back to List</a>
                <a href="../bin_admin/e_s_det.php?n=<?php echo $log->data['Username']; ?>" id="edit">Edit</a>
                 <?php echo (($status == 'Active')?
                        "<a href=\"../bin_admin/v_s_det.php?a=deactivate&n=". $log->data['Username'] ."\" id=\"deactivate\">Deactivate</a>":
                        "<a href=\"../bin_admin/v_s_det.php?a=activate&n=". $log->data['Username'] ."\" id=\"activate\">Activate</a>"); ?>
                <a href="../bin_admin/v_s_det.php?a=reset&n=<?php echo $log->data['Username']; ?>" id="reset">Reset Password</a>
            </td>
        </tr>
        <tr>
            <th colspan="2"><?php echo $name; ?></th><th>View Profile</th>
        </tr>
        <tr>
            <td rowspan="6" width="30%">
                <a href="<?php echo $pp; ?>" class="thumb" data-rel="prettyPhoto">
                      <?php echo (($pp != "")?
                            "<img id=\"pp\" src=\"". $pp ."\" alt=\"". $log->data['Username'] ."\" />":
                            "<img id=\"pp\" src=\"../img/mono-icons/user32.png\" alt=\"". $log->data['Username'] ."\" />") ?>
                </a>
                <p><?php echo "<input type=\"button\" value=\"Change Picture\" onClick=\"editpix('".$log->data['Username']."');\">"; ?></p>
            </td>
            <td align="right">Staff ID:</td><td><?php echo $log->data['Username']; ?></td>
        </tr>
        <tr>
            <td align="right">Full Name:</td><td><?php echo $name; ?></td>
        </tr>
        <tr>
            <td align="right">Age:</td><td><?php echo $age; ?> YEARS</td>
        </tr>
        <tr>
            <td align="right">Address:</td><td><?php echo $address; ?></td>
        </tr>
        <tr>
            <td align="right">Phone Number:</td><td><?php echo $phone; ?></td>
        </tr>
        <tr>
            <td align="right">Email:</td><td><?php echo $email; ?></td>
        </tr>
        <tr>
            <td></td><td align="right">Blood Group:</td><td><?php echo $bg; ?></td>
        </tr>
        <tr>
            <td></td><td align="right">Height:</td><td><?php echo $ht; ?></td>
        </tr>
        <tr>
            <th colspan="3">Other Details</th>
        </tr>
         <tr>
             <td></td><td align="right">Qualification:</td><td><?php echo $ql; ?></td>
        </tr>
        <tr>
            <td></td><td align="right">Year Of Employment:</td><td><?php echo $yemp; ?></td>
        </tr>
        <tr>
            <td></td><td align="right">Years of Experience:</td><td><?php echo $yexp; ?> YEARS</td>
        </tr>
        <tr>
            <td></td><td align="right">Class:</td><td><?php echo $class; ?></td>
        </tr>
        
        <tr>
            <td></td><td align="right">Subject:</td><td><?php echo $sb; ?></td>
        </tr>
        <tr>
            <td></td><td align="right">Post:</td><td><?php echo $po; ?></td>
        </tr>
        <tr>
            <td></td><td align="right">Employment Status:</td><td> <?php echo $status; ?> </td>
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
               $("#show").load("../bin_admin/uploadpic.php?user=" + us +"&name=" + us);
               $("#mwindow").show();
               $("#paging_button").show();
               //hideLoader();
	};
</script>