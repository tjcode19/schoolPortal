<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

$sid = (isset($_REQUEST['sid']) && $_REQUEST['sid'] != "") ? strtoupper($_REQUEST['sid']): "";
$str_sql = "SELECT DISTINCT Term, Session, Class FROM result WHERE Username='".$sid."' ORDER BY Session, Term ASC";

$log->set_sqlstr($str_sql);
$log->querydata(); 

if($log->no_rec == 0 && ($sid == "")){    $m = "
    <div id=\"r\"><div style=\"text-align:center; font-size:20px; \">Please Enter the student ID</div></div>
    "; 
}
else{
    $m = "               
<div id=\"container\"> 
    <div id=\"rowth\">
        <div class=\"leftth\"></div>
        <div class=\"middleth\">Student ID</div>
        <div class=\"middleth\">Term</div>
        <div class=\"middleth\">Session</div>
        <div class=\"middleth\">Class</div>
        <div class=\"rightth\"><a target=\"_blank\" href=\"../Admin_Module/genres.php?&id=".$sid."\" class=\"link-button\">Print All Result</a></div>
    </div> 
    ";
}
?>

<?php
function Grade($g){
    return (($g >= 70)?"A":
            (($g < 70 && $g >= 60)?"B":
            (($g < 60 && $g >= 50)?"C":
            (($g < 50 && $g >= 45)?"D":
            (($g < 45 && $g >= 40?"E":"F"))))));
}
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{
    ?>
    <div class="row">
           <div class="left"></div>
           <div class="middle"><?php echo $sid; ?></div>
           <div class="middle"><?php echo $log->data[0]; ?></div>
           <div class="middle"><?php echo $log->data[1]; ?></div>
           <div class="middle"><?php echo $log->data[2]; ?></div>
           <div class="right"><a target="_blank" href="../Admin_Module/resultpage.php?id=<?php echo $sid; ?>&c=<?php echo $log->data[2]; ?>&se=<?php echo $log->data[1]; ?>&t=<?php echo $log->data[0] ?>" class="link-button">Print Preview</a></div>
        </div>
           
        <?php 
        $log->fetchdata();
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