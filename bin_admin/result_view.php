<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;
//$class = "";
$sub = "";
$term = "";
    /* Query Subject, Term, Session From database*/
        $log->set_sqlstr("SELECT * FROM subject"); 
        $log->querydata();                        
        for($i=0; $i < $log->no_rec; $i++){
           $sub .= "<option value=\"".$log->data[0]."\" ".((isset($_REQUEST['s']) && $_REQUEST['s']==$log->data[0])?"selected":"").
                                   ">".$log->data[1]."</option>"; 
           $log->fetchdata();
        }
        
        $log->set_sqlstr("SELECT * FROM term"); 
        $log->querydata();                        
        for($i=0; $i < $log->no_rec; $i++){
           $term .= "<option value=\"".$log->data[0]."\" ".((isset($_REQUEST['t']) && $_REQUEST['t']==$log->data[0])?"selected":"").
                                   ">".$log->data[1]."</option>"; 
           $log->fetchdata();
        }
    
        $session = "<select name=\"sess\" id=\"sess\" >";
        $log->set_sqlstr("SELECT * FROM session"); 
        $log->querydata();
            for($i=0; $i < $log->no_rec; $i++){
               $session .= "<option value=\"".$log->data[0]."\" ".((isset($_REQUEST['se']) && $_REQUEST['se']==$log->data[0])?"selected":"").
                       ">".$log->data[1]."</option>"; 
               $log->fetchdata();
            } 
            $session .=" </select>";
            
$c = isset($_REQUEST['c']) ? $_REQUEST['c'] : 0;
$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : "";
$t = isset($_REQUEST['t']) ? $_REQUEST['t'] : "";
$se = isset($_REQUEST['se']) ? $_REQUEST['se'] : "";
$str_sql = "SELECT authentication.username, CONCAT( student_data.last_name, \", \", student_data.first_name, \" \", student_data.other_name ) ".
"AS rName, passport, authentication.id FROM authentication INNER JOIN student_data ON authentication.id = student_data.id WHERE student_data.class=" . $c . 
" AND authentication.priority=1 ORDER BY rName ASC";

$log->set_sqlstr($str_sql);
$log->querydata(); 
//$rsd = mysql_query($sql);
if($log->no_rec < 1 && $c != 0){    $m = "
    <div id=\"r\"><div style=\"text-align:center; font-size:20px; \">No record found for this class</div></div>
    "; 
}
else{
    $m = "               
<div id=\"container\"> 
    <div id=\"rowth\">
        <div class=\"leftth\"></div>
        <div class=\"middleth\">Student ID</div>
        <div class=\"middleth\">Name</div>
        <div class=\"rightth\"><a target=\"_blank\" href=\"../Admin_Module/resultpageall.php?&c=". 
            $c ."&se=". $se . "&t=". $t ."\" class=\"link-button\">View Result</a>
			<a target=\"_blank\" href=\"../Admin_Module/printslip.php?&c=". 
            $c ."\" class=\"link-button\">Print Slip</a></div>
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
           <div class="left">
			<?php echo (($log->data['passport'] != "")?
				"<img id=\"ss\" src=\"". $log->data['passport'] ."\" alt=\"". $log->data[2] ."\" />":
				"<img id=\"ss\" src=\"../img/mono-icons/user32.png\" alt=\"". $log->data[2] ."\" />") ?>
			</div>
           <div class="middle"><?php echo $log->data[0]; ?></div>
           <div class="middle"><?php echo $log->data[1]; ?></div>
           <div class="right"><a target="_blank" href="../Admin_Module/resultpage.php?&id=<?php echo $log->data[3]; ?>&c=<?php echo $c; ?>&se=<?php echo $se ?>&t=<?php echo $t; ?>" class="link-button">View Result</a>
		   <a target="_blank" href="../Admin_Module/resultpageEdit.php?&id=<?php echo $log->data[3]; ?>&c=<?php echo $c; ?>&se=<?php echo $se ?>&t=<?php echo $t; ?>" class="link-button">Delete Result</a></div>
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