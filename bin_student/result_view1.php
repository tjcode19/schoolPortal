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
        $log->set_sqlstr("SELECT * FROM Session"); 
        $log->querydata();
            for($i=0; $i < $log->no_rec; $i++){
               $session .= "<option value=\"".$log->data[0]."\" ".((isset($_REQUEST['se']) && $_REQUEST['se']==$log->data[0])?"selected":"").
                       ">".$log->data[1]."</option>"; 
               $log->fetchdata();
            }
            $session .=" </select>";
            
$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : "";
$t = isset($_REQUEST['t']) ? $_REQUEST['t'] : "";
$se = isset($_REQUEST['se']) ? $_REQUEST['se'] : "";
$log->set_sqlstr("SELECT * FROM result WHERE student_id='".$_SESSION['s_portal_id']."' AND term='".$_REQUEST['t'].
        "' AND session='".$_REQUEST['se']."' ORDER BY subject ASC");
                    $log->querydata();
$log->querydata(); 
//$rsd = mysql_query($sql);
if($log->no_rec == 0){    $m = "
    <div id=\"r\"><div style=\"text-align:center; font-size:20px; \">No Record found for this selection</div></div>
    "; 
}
else{
    $m = " 
        <a target=\"_blank\" href=\"../Student_Module/resultpage.php?&id=".strtoupper($_SESSION['s_portal_id'])."&se=". $_REQUEST['se']."&t=". $_REQUEST['t']."\" class=\"link-button\">Print Preview</a>
<div id=\"container\"> 
    <div id=\"rowth\">
        <div class=\"leftth\">Course</div>
        <div class=\"middleth\">CA1</div>
        <div class=\"middleth\">CA2</div>
		<div class=\"middleth\">CA3</div>
        <div class=\"middleth\">CA</div>
        <div class=\"middleth\">Exam</div>
        <div class=\"middleth\">Total</div>
        <div class=\"rightth\">Grade</div>
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
            (($g < 45 && $g >= 40?"E":"<span style=\"color:red\">F</span>"))))));
}

function getSub($id){
	$log = new login();
	$log->database();
	$log->set_sqlstr("SELECT Name FROM subject WHERE id='".$id."'");
	$log->querydata();
	return $log->data[0];					
}
	
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{
    ?>
    <div class="row">
           <div class="left"><?php echo getSub($log->data['subject']); ?></div>
           <div class="middle"><?php echo $log->data['ca1'];  ?></div>
           <div class="middle"><?php echo $log->data['ca2']; ?></div>
		   <div class="middle"><?php echo $log->data['ca3']; ?></div>
           <div class="middle"><?php echo ($ca = ($log->data['ca1'] + $log->data['ca2']+ $log->data['ca3'])); ?></div>
           <div class="middle"><?php echo $log->data['exam']; ?></div>
           <div class="middle"><?php $total = ($ca + $log->data['exam']); echo ($total < 40)?"<span style=\"color:red\">".$total."</span>": $total; ?></div>
           <div class="middle"><?php echo Grade($total); ?></div>
           <div class="right"></div>
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