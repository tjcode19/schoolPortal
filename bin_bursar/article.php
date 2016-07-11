<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

if(isset($_REQUEST['act']) && ($_REQUEST['act'] == "del")){
    $log->set_sqlstr("DELETE FROM publications WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}
if(isset($_REQUEST['act']) && ($_REQUEST['act'] == "hide")){
    $log->set_sqlstr("UPDATE publications SET Status=0 WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}
if(isset($_REQUEST['act']) && ($_REQUEST['act'] == "show")){
 $log->set_sqlstr("UPDATE publications SET Status=1, Username='".$_SESSION['s_portal_id']."' WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}
$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$log->set_sqlstr("select * from publications WHERE Type='Article' order by ID DESC limit $start,20");
$log->querydata(); 
//$rsd = mysql_query($sql);
if($log->no_rec == 0){    $m = "
    <div id=\"r\"><div style=\"text-align:center; font-size:20px; \">Article Log is empty</div></div>
    "; 
}
else{
    $m = "
                    
<div id=\"container\"> 
    <div id=\"rowth\">
        <div class=\"leftth\">S/N</div>
        <div class=\"middleth\">Title</div>
        <div class=\"middleth\">Content</div>
        <div class=\"middleth\">Status</div>
        <div class=\"rightth\"></div>
    </div> 
    ";
}
?>

<?php
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{?>
     <div class="row" id="article">
        <div class="left"><?php echo ($i+1); ?></div>
        <div class="middle"><?php echo $log->data['Title']; ?></div>
        <div class="middle"><?php echo substr($log->data['Content'], 0, 50); ?>...</div>
        <div class="middle"><?php echo (($log->data['Status']==1)?"Shown":"Hidden"); ?></div>
        <div class="right">
            <a href="../bin/article_view.php?page=1&n=<?php echo $log->data['ID']; ?>" class="link-button" title="Read Article">R</a>
            <a href="../bin_admin/article.php?page=1&act=del&n=<?php echo $log->data['ID']; ?>" class="link-button" title="Delete Article">D</a>
            <?php 
                if($log->data['Status'] == 1){
            ?>
            <a href="../bin_admin/article.php?page=1&act=hide&n=<?php echo $log->data['ID']; ?>" class="link-button red" title="Hide Article">H</a>
            <?php 
                }else{
            ?>
             <a href="../bin_admin/article.php?page=1&act=show&n=<?php echo $log->data['ID']; ?>" class="link-button green" title="Show Article">S</a>
            <?php } ?>
            
        </div>
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
        
         $('#container #article .right a:last-child').click(function(e){
             //showLoader();
             var link = this.href;
               $("#content").load(link);             
               e.preventDefault();
	});
         $('#container #article .right a:first-child').click(function(e){
             //showLoader();
             var link = this.href;
             $("#show").load(link);
             $('#mwindow').show();              
               e.preventDefault();
	});
        $('#container #article .right a:nth-child(2)').click(function(e){
             //showLoader();
            var r=confirm("Are you sure you want to delete?");
            if (r==true)
            { 
             var link = this.href;
             $("#content").load(link);
            }
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