<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$log->set_sqlstr("select * from publications WHERE Type='Jokes' AND Status=1 order by ID ASC limit $start,20");
$log->querydata(); 
//$rsd = mysql_query($sql);
if($log->no_rec == 0){    $m = "
    <div id=\"r\"><div style=\"text-align:center; font-size:20px; \">Joke Log is empty</div></div>
    "; 
}
else{
    $m = "
                    
<div id=\"container\"> 
    <div id=\"rowth\">
        <div class=\"leftth\">S/N</div>
        <div class=\"middleth\">Title</div>
        <div class=\"middleth\">Content</div>
        <div class=\"rightth\"></div>
    </div> 
    ";
}
?>

<?php
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{?>
     <div class="row" id="jokes">
        <div class="left"><?php echo ($i+1); ?></div>
        <div class="middle"><?php echo $log->data['Title']; ?></div>
        <div class="middle"><?php echo substr($log->data['Content'], 0, 80); ?>...</div>
        <div class="right">
            <a href="../bin/article_view.php?page=1&n=<?php echo $log->data['ID']; ?>" class="link-button" title="Read Joke">Read</a>
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
        
         $('#container #jokes .right a').click(function(e){
             //showLoader();
             var link = this.href;
             $("#show").load(link);
             $('#mwindow').show();              
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