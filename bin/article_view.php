<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

if(isset($_REQUEST['act']) && ($_REQUEST['act'] == "del")){
    $log->set_sqlstr("DELETE FROM publications WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}

$log->set_sqlstr("select * from publications WHERE id = '" . $_REQUEST['n'] . "'");
$log->querydata(); 

?>
<div id="container"> 
     <div class="roww"><div><h6><?php echo "Date: ".$log->data['date'] . ", Time: " .$log->data['time']. ", Posted By: " .$log->data['user_id'];; ?></h6></div></div>
     <div class="roww"><div><h5><?php echo "Title: ".$log->data['title']; ?></h5></div></div>
     <div class="roww"><div><?php echo "Author: ".$log->data['author']; ?></div></div>
     <div class="roww"><div>Content:<br/><br/><span id="cont"><?php echo $log->data['content']; ?></span></div></div>
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