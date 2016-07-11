<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

if(isset($_REQUEST['a']) && ($_REQUEST['a']=="del")){
        $log->set_sqlstr("DELETE FROM question_tab WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("DELETE FROM option_tab WHERE Question_ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
    }
else if(isset($_REQUEST['a']) && ($_REQUEST['a']=="show")){
       
        $log->set_sqlstr("UPDATE question_tab SET Status='Used' WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
                
        $log->set_sqlstr("SELECT Week FROM quiz_tab WHERE Status='Active'");
        $log->querydata();
        $l_week = $log->data[0];
        $t_week = $l_week + 1;
        
        $log->set_sqlstr("UPDATE quiz_tab SET Status='' WHERE Status = 'Active'");
        $log->ex_scalar();
        
        $log->set_sqlstr("INSERT INTO quiz_tab(Question_ID, Week, Status) VALUES('".$_REQUEST['n']."','" . $t_week. "','Active')");
        $log->ex_scalar();
    }


$log->set_sqlstr("SELECT * FROM question_tab INNER JOIN option_tab ON question_tab.ID=option_tab.Question_ID WHERE question_tab.ID='".$_REQUEST['n']."'");
$log->querydata();
 
?>
<a href="../bin_cpanel/qow_list.php?page=1" class="link-button" title='Read'>Back</a>
<table width="100%" cellpadding="10" cellspacing="0" id="payrec">

            	
           <tr align="center">
                <td>Question ID:</td>
                <td> <?php echo $log->data['ID']; ?></td>
           </tr>
           <tr>
                <td>Question:</td>
                <td><textarea cols="25" rows="4" name="Question"><?php echo $log->data['Question']; ?></textarea></td>
           </tr>
           <tr>
               <td>Option One:</td>
                <td><input required type="text" value="<?php echo $log->data['Option1']; ?>" name="A1" id="A1"/></td>
           </tr>
           <tr>
               <td>Option Two:</td>
                <td><input required type="text" value="<?php echo $log->data['Option2']; ?>" name="A2" id="A2"/></td>
           </tr>
           <tr>
               <td>Option Three:</td>
                <td><input required type="text" value="<?php echo $log->data['Option3']; ?>" name="A3" id="A3"/></td>
           </tr>
           <tr>
               <td>Option Four:</td>
                <td><input required type="text" value="<?php echo $log->data['Option4']; ?>" name="A4" id="A4"/>
                <input type="hidden" value="<?php echo $_REQUEST['n']; ?>" name="id" id="id"/></td>
           </tr>
            <tr>
               <td>Correct Option:</td>
                <td>
                <select name="ans" id="ans">
                    <option value="">Select Correct</option>
                    <option value="Option1" <?php echo (($log->data['Answer']=="Option1")?"selected":""); ?>>Option1</option>
                    <option value="Option2" <?php echo (($log->data['Answer']=="Option2")?"selected":""); ?>>Option2</option>
                    <option value="Option3" <?php echo (($log->data['Answer']=="Option3")?"selected":""); ?>>Option3</option>
                    <option value="Option4" <?php echo (($log->data['Answer']=="Option4")?"selected":""); ?>>Option4</option>
                </select>
                </td>
           </tr>
           <tr>
               <td colspan="2"><input type="submit" value="EditQuestion" name="submit" id="submit" /></td>
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
        
         $('a').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());
               //$("#paging_button").hide();               
               e.preventDefault();
	});
	
});

   
function bring ( selecter )
{	
	$('div.shopp:eq(' + selecter + ')').stop().animate({
		opacity  : '1.0',
		height: '60px'
		
	},300,function(){
		
		if(selecter < 6)
		{
			clearTimeout(Timer); 
		}
	});
	
	selecter++;
	var Func = function(){ bring(selecter); };
	Timer = setTimeout(Func, 20);
}

</script>