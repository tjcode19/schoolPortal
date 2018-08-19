<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

if(isset($_REQUEST['act']) && ($_REQUEST['act'] == "hide")){
    $log->set_sqlstr("UPDATE subject SET Status=0 WHERE Id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}
if(isset($_REQUEST['act']) && ($_REQUEST['act'] == "show")){
 $log->set_sqlstr("UPDATE subject SET Status=1 WHERE Id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}


	function getStatus($st){
			if($st == 1){$status = "ON";}
			elseif($st == 0){$status = "OFF";}
			return $status;
		}

$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$se = isset($_REQUEST['sid']) ? htmlspecialchars($_REQUEST['sid'],ENT_QUOTES) : "";
        $str_sql = ($se!="") ? "SELECT * FROM subject ".
                                " WHERE name LIKE '%".$se."%'" :
                                "select * from subject order by name ASC limit $start,20";
$log->set_sqlstr($str_sql);
$log->querydata();
//$rsd = mysql_query($sql);
if($log->no_rec == 0)    $m = "<tr>
                                <td colspan=\"6\" align=\"center\">No Record Found</td>
                            </tr>"; 
?>
             <table width="100%" cellpadding="5" cellspacing="0" id="payrec">
                            
                            <tr>
                                <th></th><th>Subject ID</th>
                                <th>Name</th>
                                <th>Status</th>
				<th width="20%">
                                    <img src="../img/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
                                </th>
                            </tr>
<?php
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{?>
            	
           <tr align="center">
                <td> </td>
                <td><?php echo ($start + $i+1); ?></td>
                <td><?php echo $log->data['Name']; ?> (<?= $log->data['Id']; ?>)</td>
                <td><?php echo getStatus($log->data['Status']); ?></td>
                <td>
                     <a href="../bin_admin/subject_list.php?page=1&n=<?php echo $log->data['id']; ?>" class="link-button" title="Edit Subject">Edit</a>
                    
                    <?php 
                        if($log->data['Status'] == 1){
                    ?>
                    <a href="../bin_admin/subject_list.php?page=1&act=hide&n=<?php echo $log->data['Id']; ?>" class="link-button red" title="Hide News">OFF</a>
                    <?php 
                        }else{
                    ?>
                     <a href="../bin_admin/subject_list.php?page=1&act=show&n=<?php echo $log->data['Id']; ?>" class="link-button green" title="Show News">ON</a>
                    <?php } ?>
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
        $('#payrec tr td a:first-child').click(function(e){
             //showLoader();
             var link = this.href;
            // $("#show").load(link);
             $('#mwindow').show();
               //$("#article").load(link, hideLoader());
               //$("#paging_button").hide();               
               e.preventDefault();
	});
	  $('#payrec tr td a:nth-child(2)').click(function(e){
             $('#loading-img').css('display','block');
             var link = this.href; 
               $("#content").load(link);
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