<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

if(isset($_REQUEST['a']) && ($_REQUEST['a']=="del")){
        $log->set_sqlstr("DELETE FROM question_tab WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("DELETE FROM option_tab WHERE Question_ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("DELETE FROM quiz_tab WHERE Question_ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
    }
else if(isset($_REQUEST['a']) && ($_REQUEST['a']=="show")){
       
        $log->set_sqlstr("UPDATE question_tab SET Status='Used' WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("SELECT Session FROM school_calendar");
        $log->querydata();
        $sess = $log->data[0];
                
        $log->set_sqlstr("SELECT Week FROM quiz_tab WHERE Status='Active'");
        $log->querydata();
        $l_week = $log->data[0];
        $t_week = $l_week + 1;
        
        $log->set_sqlstr("UPDATE quiz_tab SET Status='', Type='Answered' WHERE Status = 'Active' AND Session='".$sess."'");
        $log->ex_scalar();
        
        $log->set_sqlstr("INSERT INTO quiz_tab(Question_ID, Week, Status, Session) VALUES('".$_REQUEST['n']."','" . $t_week. "','Active','" .$sess. "')");
        $log->ex_scalar();
    }
else if(isset($_REQUEST['a']) && ($_REQUEST['a']=="reset")){
       
        $log->set_sqlstr("UPDATE question_tab SET Status='' WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("DELETE FROM quiz_tab WHERE Question_ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
    }



$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$se = isset($_REQUEST['sid']) ? htmlspecialchars($_REQUEST['sid'],ENT_QUOTES) : "";
        $str_sql = ($se!="") ? "SELECT * FROM question_tab WHERE ID LIKE '%".$se."%' OR Question LIKE '%".$se."%' " :
                                "SELECT * FROM question_tab order by ID DESC limit $start,20";
$log->set_sqlstr($str_sql);
$log->querydata();
//$rsd = mysql_query($sql);
if($log->no_rec == 0)    $m = "<tr>
                                <td colspan=\"6\" align=\"center\">No Record Found</td>
                            </tr>"; 
?>
             <table width="100%" cellpadding="10" cellspacing="0" id="payrec">
                            
                            <tr>
                                <th>S/N</th><th>ID</th><th>Question</th><th>Answer</th><th></th>
                            </tr>
<?php
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{?>
            	
           <tr align="center">
                <td>
                    <?php echo ($i +1); ?>
                </td>
                <td><?php echo $log->data[0]; ?></td>
                <td><?php echo substr($log->data['Question'], 0, 50); ?></td>
                <td><?php echo $log->data['Answer']; ?></td>
                <td>
                    <a href="../bin_cpanel/qow_edit.php?n=<?php echo $log->data[0]; ?>" class="link-button green" title='Read'>R</a>
                    <?php  if($log->data['Status'] != "Used"){ ?>
                        <a href="../bin_cpanel/qow_list.php?page=1&a=show&n=<?php echo $log->data[0]; ?>" class="link-button" title='Set Active'>S</a>
                    <?php }else{ ?>
                        <a href="../bin_cpanel/qow_list.php?page=1&a=reset&n=<?php echo $log->data[0]; ?>" class="link-button red" title='Reset'>R</a>
                    <?php } ?>
                    <a href="../bin_cpanel/qow_list.php?page=1&a=del&n=<?php echo $log->data[0]; ?>" class="link-button" title='Delete'>D</a>
                </td>
            </tr>
         
	
	
<?php $log->fetchdata();
} ?>
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
        
         $('#payrec tr td a').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());
               $("#paging_button").hide();               
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