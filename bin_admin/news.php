<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

if(isset($_REQUEST['act']) && ($_REQUEST['act'] == "del")){
    $log->set_sqlstr("DELETE FROM publications WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}
if(isset($_REQUEST['act']) && ($_REQUEST['act'] == "hide")){
    $log->set_sqlstr("UPDATE publications SET status=0 WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}
if(isset($_REQUEST['act']) && ($_REQUEST['act'] == "show")){
 $log->set_sqlstr("UPDATE publications SET status=1, user_id='".$_SESSION['s_portal_id']."' WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}
$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$log->set_sqlstr("select * from publications WHERE type=1 order by id DESC limit $start,20");
$log->querydata(); 
//$rsd = mysql_query($sql);
if($log->no_rec == 0){    $m = "
    <div id=\"r\"><div style=\"text-align:center; font-size:20px; \">News Log is empty</div></div>
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
     <div class="row" id="news">
        <div class="left"><?php echo ($i+1); ?></div>
        <div class="middle"><?php echo $log->data['title']; ?></div>
        <div class="middle"><?php echo substr($log->data['content'], 0, 50); ?></div>
        <div class="middle"><?php echo (($log->data['status']==1)?"Shown":"Hidden"); ?></div>
        <div class="right">
            <a href="../bin/article_view.php?page=1&n=<?php echo $log->data['id']; ?>" class="link-button" title="Read News">R</a>
            <a href="../bin_admin/news.php?page=1&act=del&n=<?php echo $log->data['id']; ?>" class="link-button" title="Delete News">D</a>
            <?php 
                if($log->data['status'] == 1){
            ?>
            <a href="../bin_admin/news.php?page=1&act=hide&n=<?php echo $log->data['id']; ?>" class="link-button red" title="Hide News">H</a>
            <?php 
                }else{
            ?>
             <a href="../bin_admin/news.php?page=1&act=show&n=<?php echo $log->data['id']; ?>" class="link-button green" title="Show News">S</a>
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
        
        
         $('#container #news .right a:last-child').click(function(e){
             //showLoader();
             var link = this.href;
               $("#content").load(link);
               //$("#paging_button").hide();               
               e.preventDefault();
	});
         $('#container #news .right a:first-child').click(function(e){
             //showLoader();
             var link = this.href;
             $("#show").load(link);
             $('#mwindow').show();
               //$("#article").load(link, hideLoader());
               //$("#paging_button").hide();               
               e.preventDefault();
	});
         $('#container #news .right a:nth-child(2)').click(function(e){
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