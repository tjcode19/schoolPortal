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
//$class = "";
$sub = "";
$term = "";
    /* Query Subject, Term, Session From database*/
        $log->set_sqlstr("SELECT Name FROM subject"); 
        $log->querydata();                        
        for($i=0; $i < $log->no_rec; $i++){
           $sub .= "<option value=\"".$log->data[0]."\" ".((isset($_REQUEST['s']) && $_REQUEST['s']==$log->data[0])?"selected":"").
                                   ">".$log->data[0]."</option>"; 
           $log->fetchdata();
        }
        
        $log->set_sqlstr("SELECT Name FROM term"); 
        $log->querydata();                        
        for($i=0; $i < $log->no_rec; $i++){
           $term .= "<option value=\"".$log->data[0]."\" ".((isset($_REQUEST['t']) && $_REQUEST['t']==$log->data[0])?"selected":"").
                                   ">".$log->data[0]."</option>"; 
           $log->fetchdata();
        }
    
        $session = "<select name=\"sess\" id=\"sess\" >";
        $log->set_sqlstr("SELECT DISTINCT Session FROM result"); 
        $log->querydata();
            for($i=0; $i < $log->no_rec; $i++){
               $session .= "<option value=\"".$log->data[0]."\" ".((isset($_REQUEST['se']) && $_REQUEST['se']==$log->data[0])?"selected":"").
                       ">".$log->data[0]."</option>"; 
               $log->fetchdata();
            }
            $sess = date("Y")."/".(date("Y")+1);
            $session .= "<option value=\"".$sess."\"".((isset($_REQUEST['se']) && $_REQUEST['se']==$sess)?"selected":"").">".$sess."</option>"; 
            $session .=" </select>";
            
$c = isset($_REQUEST['c']) ? $_REQUEST['c'] : "";
$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : "";
$t = isset($_REQUEST['t']) ? $_REQUEST['t'] : "";
$se = isset($_REQUEST['se']) ? $_REQUEST['se'] : "";
$str_sql = "SELECT Username, CONCAT( Surname, \", \", Firstname, \" \", Other ) AS rName,  Passport1 FROM student_data  WHERE Class='" . $c . "' ORDER BY rName ASC";

$log->set_sqlstr($str_sql);
$log->querydata(); 
//$rsd = mysql_query($sql);
if($log->no_rec == 0 && ($c == "")){    $m = "
    <div id=\"r\"><div style=\"text-align:center; font-size:20px; \">Please Select Class</div></div>
    "; 
}
else{
    $m = "               
<div id=\"container\"> 
    <div id=\"rowth\">
        <div class=\"leftth\"></div>
        <div class=\"middleth\">Student ID</div>
        <div class=\"middleth\">Name</div>
        <div class=\"rightth\"><a target=\"_blank\" href=\"../ControlPanel/resultpageall.php?&c=". 
            $_REQUEST['c'] ."&se=". $_REQUEST['se'] . "&t=". $_REQUEST['t'] ."\" class=\"link-button\">View Result</a></div>
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
           <div class="left"><img src="<?php echo $log->data[2]; ?>" /></div>
           <div class="middle"><?php echo $log->data[0]; ?></div>
           <div class="middle"><?php echo $log->data[1]; ?></div>
           <div class="right"><a target="_blank" href="../ControlPanel/resultpage.php?&id=<?php echo $log->data[0]; ?>&c=<?php echo $_REQUEST['c']; ?>&se=<?php echo $_REQUEST['se'] ?>&t=<?php echo $_REQUEST['t']; ?>" class="link-button">View Result</a></div>
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