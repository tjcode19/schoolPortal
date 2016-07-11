<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     
    $log->verify_login();
    if ($log->logsuccess !=4){
        header("Location:".Homepage);
    }
    if(isset($_REQUEST['action'])){
	    if($_REQUEST['action']=='out' && $log->logsuccess != 0) 
		   {$log->logout(); header("Location:".Homepage);}
	}
        
        $log->set_sqlstr("SELECT * FROM school_calendar"); 
        $log->querydata();
        $term = $log->data[0];
        $sess = $log->data[1];
        $event = $log->data[2];
        $date = $log->data[3];
        $dura = $log->data[4];
        $id = $log->data['ID'];
        $mid = $log->data[7];
        $ftest = $log->data[8];
        $stest = $log->data[9];
        $eday = $log->data[10];
        $ass= $log->data[11];
        $t_test= $log->data[12];
        $vday= $log->data[13];
        $nterm= $log->data[15];
        $lupdate= $log->data[16];
?>
<form action="" method="post" id="sid">
    <table width="100%" cellpadding="10" cellspacing="0" id="m">
        <tr>
            <td rowspan="5" width="30%">
                <textarea cols="20" rows="2" name="event" id="event"><?php echo $event; ?></textarea>
            </td>
            <td align="right">Term:</td><td>
                <select name="term" id="term">
                    <?php 
                    $log->set_sqlstr("SELECT Name FROM term"); 
                    $log->querydata();                        
                    for($i=0; $i < $log->no_rec; $i++){
                       echo "<option value=\"".$log->data[0]."\" ".(($term==$log->data[0])?"selected":"").">".$log->data[0]."</option>"; 
                       $log->fetchdata();
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">Session:</td><td>
                 <select name="sess" id="sess" >
                    <?php                        
                    for($i=-2; $i <= 2; $i++){
                        $dat = explode("/",$sess);
                       echo "<option value=\"".($dat[0]+$i)."/".($dat[1]+$i)."\" ".(($sess==$i)?"selected":"").">".($dat[0]+$i)."/".($dat[1]+$i)."</option>"; 
                       $log->fetchdata();
                    }
                    ?>
                </select>
            <input type="hidden" value="<?php echo $id; ?>" name="id" id="id" /></td>
        </tr>
        <tr>
            <td align="right">Term Duration:</td><td> 
                <select name="dura" id="dura" >
                    <?php                        
                    for($i=1; $i <= 14; $i++){
                       echo "<option value=\"".$log->data[0]."\" ".(($dura==$i)?"selected":"").">".$i."</option>"; 
                       $log->fetchdata();
                    }
                    ?>
                </select> Weeks</td>
        </tr>
         <tr>
            <td align="right">First Term Started:</td><td><input type="text" value="<?php echo $date; ?>" name="date" id="date" /></td>
        </tr>
        <tr>
            <td align="right">Submission Of Assignment:</td><td><input type="text" value="<?php echo $ass; ?>" name="ass" id="ass" /></td>
        </tr>
        <tr>
            <td></td><td align="right">First CA Test:</td><td><input type="text" value="<?php echo $ftest; ?>" name="ftest" id="ftest" /></td>
        </tr>
        <tr>
            <td></td><td align="right">Second CA Test:</td><td><input type="text" value="<?php echo $stest; ?>" name="stest" id="stest" /></td>
        </tr>
        <tr>
            <td></td><td align="right">Mid-Term Break:</td><td><input type="text" value="<?php echo $mid; ?>" name="mid" id="mid" /></td>
        </tr>
        <tr>
            <td></td><td align="right">Third CA Test:</td><td><input type="text" value="<?php echo $t_test; ?> " name="t_test" id="t_test" /></td>
        </tr>
        <tr>
            <td></td><td align="right">Examination Starts:</td><td><input type="text" value="<?php echo $eday; ?>" name="eday" id="eday" /> </td>
        </tr>
        <tr>
            <td></td><td align="right">Vacation Date:</td><td> <input type="text" value="<?php echo $vday; ?>" name="vday" id="vday" /></td>
        </tr>
        <tr>
            <td></td><td align="right">Next Term Begins:</td><td><input type="text" value="<?php echo $nterm; ?>" name="nterm" id="nterm" /></td>
        </tr>
        <tr>
            <td></td><td align="right">Last Update:</td><td><?php echo $lupdate; ?></td>
        </tr>
        <tr>
            <th colspan="3"><input type="submit" value="Update Calendar" name="up" id="up" /></th>
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
            
                
        $( 'input[type=text]' ).datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'DD, d MM, yy'
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