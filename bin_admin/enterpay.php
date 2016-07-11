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
        $class = $log->data['Class'];
        $log->set_sqlstr("SELECT * FROM school_calendar "); 
        $log->querydata();
       
       
?>
     <div id="mai" style="margin-bottom: 10px;">
         <form action="" method="post" id="paylog">
           <input type="hidden" name="term" id="term" value="<?php echo $log->data['Term']; ?>" />
           <input type="hidden" name="session" id="session" value="<?php echo $log->data['Session']; ?>" /> 
            <input type="hidden" name="class" id="class" value="<?php echo $class; ?>" /> 
            <input type="hidden" name="user" id="user" value="<?php echo $_REQUEST['n']; ?>" /> 

            <table width="100%" cellpadding="10" cellspacing="0" id="det">
                 <tr>
                    <td colspan="2">
                        <a href="../bin_admin/paylog.php?page=1&sid=<?php echo $class; ?>" id="back">Back to List</a>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $name; ?></th>
                    <th><?php echo $log->data['Term'].", ".$log->data['Session']; ?> </th>
                </tr>
                
                <tr>

                    <td align="right">Amount:</td><td><input type="text" name="amt" id="amt" value="" /></td>
                </tr>
                <tr>

                    <td align="right">Being payment for:</td>
                    <td>
                        <select name="purpose" id="purpose">
                            <option value="">Select Payment Purpose</option>
                            <option value="School Fees">School Fees</option>
                            <option value="Lesson Fees">Lesson Fee</option>
                            <option value="Other Fees">Other</option>
                        </select>
                    </td>
                </tr>
                <tr>

                    <td align="right">Payment Type:</td>
                    <td>
                        <select name="ptype" id="ptype">
                            <option value="">Select Payment Type</option>
                            <option value="Part-Payment">Part-Payment</option>
                            <option value="Full-Payment">Full-Payment</option>
                        </select>
                    </td>
                </tr>
                <tr>

                    <td align="right"><input type="checkbox" name="rec" id="rec" /></td>
                    <td>Print Receipt</td>
                </tr>
                <tr align="center">

                    <td colspan="2"> <input type="submit" value="Enter Payment"/></td>
                </tr>

            </table>   
       </form>
 </div>
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
      $('#paylog').submit(function(e) {
      showLoader();
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin_admin/paylogen.php",
            type: "POST",
            data : postData,
            dataType: 'html',
            success:function(d)
            {
                var resp = d;
                var res = resp.split("/");
                //data: return data from server
                if(res[0] == 0){
                    alert("Please enter amount"); 
                    $('.success').html("Please enter amount").show();
                    hideLoader();
                }
                else if(res[0] == 2){
                    alert("Select Payment Type and Payment Purpose");
                    $('.success').html("Select Payment Type and Payment Purpose").show();
                    hideLoader();
                }
                else if(res[0] == 4){
                    
                    window.open('receipt.php?user='+res[1]+'&time='+res[2],'_blank');
                      hideLoader();
                }
                else{
                    alert("Payment Record Inserted"); 
                    $('.success').html("Payment Record Inserted").show();
                    $( '#paylog' ).each(function(){
                        this.reset();
                    });
                    hideLoader();
                }               
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails  
                alert(textStatus);
            }
        });
       //$("#sid").hide();
        e.preventDefault(); //STOP default action
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