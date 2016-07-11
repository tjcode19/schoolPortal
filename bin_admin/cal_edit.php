<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     
    $log->verify_login();
    if ($log->logsuccess !=3){
        header("Location:".Homepage);
    }
    if(isset($_REQUEST['action'])){
	    if($_REQUEST['action']=='out' && $log->logsuccess != 0) 
		   {$log->logout(); header("Location:".Homepage);}
	}
        
        $log->set_sqlstr("SELECT * FROM calender"); 
        $log->querydata();
?>
<form action="" method="post" id="sid">
    <table width="100%" cellpadding="5" cellspacing="0" id="mai">
		<tr>
            <td></td><td align="right">Event Term:</td>
			<td>
				<select name="term" id="term">
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
			</td>
        </tr>
		<tr>
            <td></td><td align="right">Event Session:</td>
			<td>
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
            <td></td><td align="right">Event:</td>
			<td>
				<select name="event" id="event">
					<option value="">Select Event</option>
					<?php 
					$log->set_sqlstr("SELECT * FROM event"); 
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
            <td></td><td align="right">Description:</td>
			<td><textarea cols="20" rows="2" name="det" id="det"></textarea></td>
        </tr>
		<tr>
            <td></td><td align="right">Start Date:</td>
			<td><input name="stDate" id="stDate" type="text" size="20"></td>
        </tr>
		<tr>
            <td></td><td align="right">End Date:</td>
			<td><input name="enDate" id="enDate" type="text" size="20"></td>
        </tr>
		<tr>
            <td></td><td align="right">Start Time:</td>
			<td>
				<select name="stime" id="stime">
					<option value="">Start Time</option>
					<?php     
						//add leading zero
						function lZer($r){
							if($r < 10)$r = "0".$r;
							return $r;
						}
					for($i=0; $i < 24; $i++){
					   echo "<option value=\"".lZer($i).":00H\">".lZer($i).":00H</option>"; 
					}
					?>
				</select> TO 
				<select name="etime" id="etime">
					<option value="">End Time</option>
					<?php     
					for($i=0; $i < 24; $i++){
					   echo "<option value=\"".lZer($i).":00H\">".lZer($i).":00H</option>"; 
					}
					?>
				</select>
				
			</td>
        </tr>
        <tr>
            <th colspan="3"><input type="submit" value="Add event" name="up" id="up" /></th>
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
            
                
        $('#stDate').datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'DD, d MM yy'
      });
	  
	  $('#enDate').datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'DD, d MM yy'
      });
	
         //callback handler for select change of option for state
      $('#sid').submit(function(e) {
      showLoader();
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin_admin/update_cal.php",
            type: "POST",
            data : postData,
            dataType: 'html',
            success:function()
            {
                //data: return data from server
                $("#content").load("../bin_admin/cal_view.php", hideLoader()); 
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