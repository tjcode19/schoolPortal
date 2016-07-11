<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

//$se = ((isset($_REQUEST['act']) && ($_REQUEST['act']=="list"))?"list" : (isset($_REQUEST['act']) && ($_REQUEST['act']=="search"))?"search":"");

    $log->set_sqlstr($str_sql);
    $log->querydata();

if($log->no_rec == 0)    $m = "<tr>
                                <td colspan=\"6\" align=\"center\">No Record Found</td>
                            </tr>"; 
?>
 <div id="k" style="margin-bottom: 10px;"> 
     <a target="_blank" href="../ControlPanel/printpin.php" class="link-button green">Print All Slip</a>
 </div>
             <table width="100%" cellpadding="5" cellspacing="0" id="payrec">
                            
                            <tr>
                                <th><?php echo $log->no_rec; ?></th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th><a href="../bin/allpin_list.php?page=1&all=deactivate" class="link-button">Reset All</a></th>
                            </tr>
<?php
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{?>
            	
           <tr align="center">
                <td><?php echo ($i + 1); ?>.</td>
                <td><?php echo $log->data['Username']; ?></td>
                <td><?php echo $log->data['Password1']; ?></td>
                <td><?php echo $log->data['Status']; ?></td>
                <td>
                    <?php
                        if($log->data['Status'] == "Raw"){
                    ?>
                    <a target="_blank" href="../ControlPanel/printpinsingle.php?n=<?php echo $log->data['Username']; ?>" class="link-button green">Print</a>
                    <?php }else{ ?>
                     <a href="../bin/allpin_list.php?page=1&a=deactivate_s&n=<?php echo $log->data['Username']; ?>" class="link-button">Reset</a>
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
        
         $('#payrec tr td a:last-child').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());
               //$("#paging_button").hide();               
               e.preventDefault();
	});
        
         $('#payrec tr th a').click(function(e){
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