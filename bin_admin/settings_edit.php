<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();


 $log->set_sqlstr("SELECT * FROM schoolfees"); 
        $log->querydata();
        
?>
<div class="entry-content cf">
	<a class="link-button" href="" style="margin-bottom: 10px;" id="adds">View Fee</a>
	<img src="../img/loader.gif" id="loading-img" style="display:none;width:45px;height:45px;" alt="Please Wait"/> <hr/>
</div> 
<div id="message" style="color:red; font-size:14px"></div>
<form action="" method="post" id="m">
    <table width="100%" cellpadding="5" cellspacing="0" id="mai">
		<tr>
            <td></td><td align="right">Term:</td>
			<td>
				<select name="term" id="term" required>
					<option value="">Select Term</option>
					<?php 
					$log->set_sqlstr("SELECT * FROM term"); 
					$log->querydata();                        
					for($i=0; $i < $log->no_rec; $i++){
					   echo "<option value=\"".$log->data[0]."\">".$log->data[1]."</option>"; 
					   $log->fetchdata();
					}
					?>
				</select>
				<select name="session" id="session" required>
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
            <td></td><td align="right">Fee Type:</td>
			<td>
				<select name="class" id="class" required>
					<option value="">Select Class</option>
					<?php 
					$log->set_sqlstr("SELECT * FROM class"); 
					$log->querydata();                        
					for($i=0; $i < $log->no_rec; $i++){
					   echo "<option value=\"".$log->data[0]."\">".$log->data[1]."</option>"; 
					   $log->fetchdata();
					}
					?>
				</select>
				<select name="typ" id="typ" required>
					<option value="">Select Type</option>
					<?php 
					$log->set_sqlstr("SELECT * FROM schoolfeetype"); 
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
            <td></td><td align="right">Amount:</td>
			<td><input name="amount" id="amount" type="text" size="20" required></td>
        </tr>
        <tr>
            <th colspan="3"><input type="submit" value="Add Fee" name="addfee" id="addfee" /></th>
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
        
         $('#view').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());              
               e.preventDefault();
	});
	
	 $('#adds').click(function(e){
		$('#loading-img').css('display','inline');
		$("#content").load("../bin_admin/settings_show.php"); 
		e.preventDefault();
	});
        
        //callback handler for select change of option for state
       $('#m').submit(function(e) {
		$('#loading-img').css('display','inline');
		$('#addfee').html('Please wait..');
        var postData = $(this).serializeArray();
        $.ajax(
        {
            url : "../bin_admin/update_fee.php",
            type: "POST",
            data : postData,
            dataType: 'html',
            success:function(data)
            {
                //data: return data from server  
				if(data == 1){
					
                alert("Data Updated Successfully");
                $("#content").load("../bin_admin/settings_show.php?page=1"); 
				}
				else{
					alert("Sorry, this fee already exist");
					$('#message').html("Sorry, this fee already exist. Change fee type or click view to edit existing fee")
				}
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
