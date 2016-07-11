<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

if(isset($_REQUEST['st']) && ($_REQUEST['st'] == "pd")){
    $log->set_sqlstr("UPDATE schemeofwork SET Status='Pending' WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}
elseif(isset($_REQUEST['st']) && ($_REQUEST['st'] == "done")){
    $log->set_sqlstr("UPDATE schemeofwork SET Status='Done' WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}
$c = isset($_REQUEST['c']) ? $_REQUEST['c'] : "";
$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : "";
$t = isset($_REQUEST['t']) ? $_REQUEST['t'] : "";
$log->set_sqlstr("select * from schemeofwork WHERE Class='". $c ."' AND Subject='". $s ."' AND Term='". $t ."' order by Week ASC");
$log->querydata(); 
if($c == "") {   
    $m = "
    <div id=\"rowth\">
        <div class=\"left\"></div>
        <div class=\"middle\">Please Select Class, Subject and Terms</div>
        <div class=\"middle\"></div>
    </div>";
}
else if($log->no_rec < 1) {   
    $m = "
    <div id=\"rowth\">
        <div class=\"left\"></div>
        <div class=\"middle\">No Record Found</div>
        <div class=\"middle\"></div>
    </div>";
}
?>
             
                 
<div id="container">
    <div id="rowth">
        <div class="leftth">Week</div>
        <div class="middleth">Topic</div>
        <div class="middleth">Status</div>
        <div class="rightth"></div>
    </div> 
<?php
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{?>
     <div class="row">
        <div class="left"><?php echo $log->data['Week']; ?></div>
        <div class="middle"><?php echo $log->data['Topic']; ?></div>
        <div class="middle"><?php echo $log->data['Status']; ?></div>
        <div class="right">
            <?php echo (($log->data['Status'] == "Pending")?"<a href=\"../bin_admin/scheme_list.php?page=1&st=done&n=". $log->data['ID'] ."&c=".$_REQUEST['c']."&s=".$_REQUEST['s']."&t=".$_REQUEST['t']."\" class=\"link-button\">Set as Done</a>" :
                    "<a href=\"../bin_admin/scheme_list.php?page=1&st=pd&n=". $log->data['ID'] ."&c=".$_REQUEST['c']."&s=".$_REQUEST['s']."&t=".$_REQUEST['t']."\" class=\"link-button\">Set as Pending</a>"); ?></div>
    </div>
           
<?php $log->fetchdata();
} ?>
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
        
         $('#container .row a').click(function(e){
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