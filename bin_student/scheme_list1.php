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
$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;
/*
$se = isset($_REQUEST['sid']) ? htmlspecialchars($_REQUEST['sid'],ENT_QUOTES) : "";
        $str_sql = ($se!="") ? "SELECT * FROM auth_tab INNER JOIN student_data ON auth_tab.Username=student_data.Username".
                                " WHERE student_data.Firstname LIKE '%".$se."%' OR student_data.Class LIKE '%".$se.
                                "%' OR student_data.Other LIKE '%".$se."%' OR student_data.Username LIKE '%".$se."%' OR student_data.Surname LIKE '%".$se."%'" :
                                "select * from schemeofwork WHERE Class='".."' AND Subject='".."' AND Term='".."' order by ID DESC limit $start,20";*/
$c = isset($_REQUEST['c']) ? $_REQUEST['c'] : "";
$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : "";
$t = isset($_REQUEST['t']) ? $_REQUEST['t'] : "";
$log->set_sqlstr("select * from schemeofwork WHERE Class='". $c ."' AND Subject='". $s ."' AND Term='". $t ."' order by Week ASC");
$log->querydata(); 
//$rsd = mysql_query($sql);
if($log->no_rec == 0)    $m = "<div class=\"r\"><div style=\"text-align:center; width:100% \">No Record Found</div></div>"; 
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
        <div class="middle"><?php echo ($log->data['Status'] != 0)?"Done":"Pending"; ?></div>
        <div class="right"></div>
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