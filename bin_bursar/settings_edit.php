<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();


 $log->set_sqlstr("SELECT * FROM schoolfees"); 
        $log->querydata();
		
		function getClass($cl){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM class WHERE id='".$cl."'"); 
			$log->querydata();
			return $log->data[0];
		}
	 function getTerm($cl){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM term WHERE id='".$cl."'"); 
			$log->querydata();
			return $log->data[0];
		}
	 function getSe($cl){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM session WHERE id='".$cl."'"); 
			$log->querydata();
			return $log->data[0];
		}
        
?>
<div id="message" style="color:red; font-size:14px"></div>
<form action="" method="post" id="m">
    <table width="100%" cellpadding="5" cellspacing="0" id="mai">
		<tr>
            <td>Class: <?php echo getClass($_REQUEST['cl']); ?></td>
			<td align="center">Term: <?php echo getTerm($_REQUEST['tr']); ?></td>
			<td>Session: <?php echo getSe($_REQUEST['se']); ?></td>
        </tr>
		 <tr>
			<td colspan="3" align="center">Fee Type:
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
			<td colspan="3" align="center">
				Amount:<input name="amount" id="amount" type="text" size="20" required>
				<input type="hidden" value="<?php echo $_REQUEST['cl']; ?>" name="class" id="class" />
				<input type="hidden" value="<?php echo $_REQUEST['tr']; ?>" name="term" id="term" />
				<input type="hidden" value="<?php echo $_REQUEST['se']; ?>" name="session" id="session" />
			</td>
        </tr>
        <tr>
            <th colspan="3" align="center"><input type="submit" value="Add Fee" name="addfee" id="addfee" /></th>
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
            url : "../bin_bursar/update_fee.php",
            type: "POST",
            data : postData,
            dataType: 'html',
            success:function(data)
            {
                //data: return data from server  
				if(data == 1){
					
                alert("Data Updated Successfully");
                $("#content").load("../bin_bursar/settings_show.php?page=1"); 
				}
				else{
					alert("Sorry, this fee already exist");
					$('#message').html("Sorry, this fee already exist. Change fee type or click view to edit existing fee");
					$('#loading-img').css('display','inline');
				}
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails  
                alert(textStatus);
				$('#loading-img').css('display','inline');
            }
        });
        e.preventDefault(); //STOP default action
    });
	
});
</script>
