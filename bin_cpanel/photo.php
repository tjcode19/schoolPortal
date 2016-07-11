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

$log->set_sqlstr("select * from photo_tab order by ID DESC limit $start,20");
$log->querydata(); 
if($log->no_rec == 0)    $m = "<div class=\"row\"><div style=\"text-align:center; width:100% \">No Record Found</div></div>"; 
?>

<div class="feature-image">
<?php
echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{
    ?>

        <a href="<?php echo $log->data['Path_B'] ?>" data-rel="prettyPhoto" rel="prettyPhoto" >
            <img src="<?php echo $log->data['Path_S'] ?>" alt="Alt text" width="170" height="170" id="small"/>
        </a>
  
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
        
        
         $('.feature-image a').click(function(e){
             showLoader();
             var link = this.href;
           $("#show").html('<img src="'+link+'" id="big" />');
               $("#mwindow").show();             
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