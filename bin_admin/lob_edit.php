<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

$c = ((isset($_REQUEST['c']) )? $_REQUEST['c'] : ( isset($_REQUEST['c1'])? $_REQUEST['c1'] :""));
$s = ((isset($_REQUEST['s']) )? $_REQUEST['s'] : (isset($_REQUEST['s1'])? $_REQUEST['s1'] :""));
$t = ((isset($_REQUEST['t']) )? $_REQUEST['t'] : (isset($_REQUEST['t1'])? $_REQUEST['t1'] :""));
$log->set_sqlstr("select * from listofbooks WHERE class='". $c ."' AND subject='". $s ."' AND Term='". $t ."' order by Week ASC");
$log->querydata(); 
//$rsd = mysql_query($sql);
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
        <div class="leftth">Week
        <input type="hidden" name="cl" id="cl" value="<?php echo $c; ?>"/>
        <input type="hidden" name="sub" id="sub" value="<?php echo $s; ?>"/>
        <input type="hidden" name="term" id="term" value="<?php echo $t; ?>"/></div>
        <div class="middleth">Topic</div>
        <div class="middleth">Status</div>
    </div> 
<?php
 echo ((isset($m))? $m :"");
 $nowk = 13;
for($i = 0; $i < $nowk; $i++)
{  
    if($log->data['Week'] == ($i+1) ){
?>
     <div class="row">
        <div class="left"><input type="text" name="wk[]" id="wk[]" value="<?php echo $log->data['Week']; ?>" size="1"/></div>
        <div class="middle"><input type="text" name="topic[]" id="topic[]" value="<?php echo $log->data['Topic']; ?>" size="40"/>
        <input type="hidden" name="id[]" id="id[]" value="<?php echo $log->data[0]; ?>"/></div>
        <div class="middle"><?php echo $log->data['Status']; ?></div>         
    </div>
           
<?php 
        $log->fetchdata();  
    }
elseif((!isset($_REQUEST['c'])) && (!isset($_REQUEST['s'])) && (!isset($_REQUEST['t']))){}
else{?>
    <div class="row">
        <div class="left"><input type="text" name="wk[]" id="wk[]" value="<?php echo ($i+1) ?>" size="1"/></div>
        <div class="middle"><input type="text" name="topic[]" id="topic[]" value="" size="40"/>
        <input type="hidden" name="id[]" id="id[]" value="ins" /></div>
        <div class="middle"></div>         
    </div>
    
    
<?php }

} 
if((isset($_REQUEST['c'])) && (isset($_REQUEST['s'])) && (isset($_REQUEST['t'])) ) {?>
     <div id="rowth">
        <div class="leftth"></div>
        <div class="middleth"><input type="submit" name="update" id="update" value="Update Scheme"/></div>
        <div class="middleth"></div>
    </div> 
<?php } ?>
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

</script>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            