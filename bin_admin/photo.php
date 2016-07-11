<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();


if(isset($_REQUEST['a']) && $_REQUEST['a']=="del" ){
        $log->set_sqlstr("DELETE FROM photo_tab WHERE Name = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
         
        $uploaddir = '../photo/Big/';
		$uploaddir1 = '../photo/Small/';
        unlink($uploaddir.$_REQUEST['n']."");
        unlink($uploaddir1.$_REQUEST['n']."");
    }

$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$log->set_sqlstr("select * from photo_tab order by ID DESC limit $start,20");
$log->querydata(); 
if($log->no_rec == 0)    $m = "<div class=\"row\"><div style=\"text-align:center; width:100% \">No Photo Found</div></div>"; 
?>

<div class="feature-image">
<ul >
<?php
echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{
    ?>
		<li style="display:inline;">
        <a href="<?php echo $log->data['Path_B'] ?>" data-rel="prettyPhoto" rel="prettyPhoto" >
            <img src="<?php echo $log->data['Path_S'] ?>" alt="Alt text" width="170" height="170" id="small"/>
        </a>
		<a href="../bin_admin/photo.php?page=1&a=del&n=<?php echo $log->data['Name']; ?>" id="del">
			<img alt="Reset" title="Delete Picture" src="../img/mono-icons/stop32.png" width="15" height="15" />
		</a>
		</li>
  
<?php $log->fetchdata();
} ?>
</ul>
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
        
         $('.feature-image ul li a:first-child').click(function(e){
             showLoader();
             var link = this.href;
           $("#show").html('<img src="'+link+'" id="big" />');
               $("#mwindow").show();
               hideLoader();
               e.preventDefault();
	});
	
	$('a#del').click(function(e){
		var link = this.href;
		$("#content").load(link);
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