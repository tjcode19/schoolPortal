<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();

 $log->set_sqlstr("SELECT * FROM student_data WHERE id ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        $name = $log->data['last_name']." ".$log->data['first_name']." ".$log->data['other_name'];
        $class = $log->data['class'];
        $log->set_sqlstr("SELECT * FROM calender "); 
        $log->querydata();
       
       
?>
     <div id="mai" style="margin-bottom: 10px;">
         <form action="" method="post" id="paylog">
            <input type="hidden" name="class" id="class" value="<?php echo $class; ?>" /> 
            <input type="hidden" name="user" id="user" value="<?php echo $_REQUEST['n']; ?>" /> 

            <table width="100%" cellpadding="10" cellspacing="0" id="det">
                 <tr>
                    <td colspan="2">
                        <a href="../bin_bursar/paylog.php?page=1&sid=<?php echo $class; ?>" id="back">Back to List</a>
                    </td>
                </tr>
                <tr>
                    <th>Name:</th>
                    <th><?php echo $name; ?></th>
                </tr> 
				<tr>

                    <td align="right">Term:</td>
                    <td>
                        <select name="term" id="term">
                            <option value="">Select Term</option>
                            <option value="1">First Term</option>
                            <option value="2">Second Term</option>
                            <option value="3">Third Term</option>
                        </select>
						 <select name="session" id="session">
                            <option value="">Select Session</option>
							<?php 
							$log->set_sqlstr("SELECT * FROM session"); 
							$log->querydata();                        
							for($i=0; $i < $log->no_rec; $i++){
							   echo "<option value=\"".$log->data[0]."\">".$log->data[1]."</option>"; 
							   $log->fetchdata();
							}
							?>
                        </select>
                    </td>
                </tr>
                <tr>

                    <td align="right">Amount:</td><td><input type="text" name="amt" id="amt" value="" /></td>
                </tr>
                <tr>

                    <td align="right">Being payment for:</td>
                    <td>
                        <select name="purpose" id="purpose">
                            <option value="">Select Payment Purpose</option>
                            <?php 
							$log->set_sqlstr("SELECT * FROM schoolfeetype"); 
							$log->querydata();                        
							for($i=0; $i < $log->no_rec; $i++){
							   echo "<option value=\"".$log->data[0]."\">".$log->data[1]."</option>"; 
							   $log->fetchdata();
							}
							?>
							<option value="">Others</option>
                        </select>
                    </td>
                </tr>
                <tr>

                    <td align="right">Mode Of Payment:</td>
                    <td>
                        <select name="mot" id="mot">
                            <option value="">Select Payment Mode</option>
                            <option value="1">Bank Deposit</option>
                            <option value="2">Online Payment</option>
							<option value="3">Cash Deposit</option>
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
            url : "../bin_bursar/paylogen.php",
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