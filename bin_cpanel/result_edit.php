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
        $log->set_sqlstr("SELECT Name FROM subject  ORDER BY Name ASC"); 
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
              
   /* End :: Query Subject, Term, Session From database*/

$c = isset($_REQUEST['c']) ? $_REQUEST['c'] : "";
$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : "";
$t = isset($_REQUEST['t']) ? $_REQUEST['t'] : "";
$se = isset($_REQUEST['se']) ? $_REQUEST['se'] : "";
$act = isset($_REQUEST['act']) ? $_REQUEST['act']: "";

        $str_sql = ($act!=1) ? "SELECT Username, CONCAT( Surname, \", \", Firstname, \" \", Other ) AS rName FROM student_data  WHERE Class='" . $c . "' ORDER BY rName ASC" :
                                "select Username, CONCAT( Surname, \", \", Firstname, \" \", Other ) AS rName FROM student_data WHERE Class='". $c ."' order by rName ASC";

$log->set_sqlstr($str_sql);
$log->querydata(); 
//$rsd = mysql_query($sql);
if($log->no_rec == 0 && ($c == "")){    $m = "
    <div id=\"r\"><div style=\"text-align:center; font-size:20px; \">Please Select Class</div></div>
    "; 
}
elseif($act==1){
    $m = "
                     
 <div id=\"r\">
    <div class=\"right\">
        <div id=\"mai\" style=\"margin-bottom: 10px;\">
            <select name=\"sub\" id=\"sub\">
                <option value=\"\">Select Subject</option>
               ".$sub."
            </select>
             <select name=\"term\" id=\"term\">
                <option value=\"\">Select Term</option>
               ". $term. "
            </select>
            ".$session."<input type=\"hidden\" value=\"".$c."\" id=\"cl\" name=\"cl\" />
                <input type=\"submit\" value=\"Edit\" />
        </div>
    </div>
</div>                  
<div id=\"container\"> 
    <div id=\"rowth\">
        <div class=\"leftth\">Student ID</div>
        <div class=\"middleth\">Name</div>
        <div class=\"middleth\">CA1</div>
        <div class=\"middleth\">CA2</div>
        <div class=\"middleth\">CA</div>
        <div class=\"middleth\">Exam</div>
        <div class=\"middleth\">Total</div>
        <div class=\"rightth\">Grade</div>
    </div> 
    ";
}
else{
    $m = "
                     
 <div id=\"r\">
    <div class=\"right\">
        <div id=\"mai\" style=\"margin-bottom: 10px;\">
                <input type=\"hidden\" value=\"".$s."\" id=\"sub\" name=\"sub\" />
                <input type=\"hidden\" value=\"".$t."\" id=\"term\" name=\"term\" />
                <input type=\"hidden\" value=\"".$se."\" id=\"sess\" name=\"sess\" />
                <input type=\"hidden\" value=\"".$c."\" id=\"cl\" name=\"cl\" />
                <input type=\"hidden\" value=\"1\" id=\"act\" name=\"act\" />
                <h6>Subject: ".$s." | Term: ".$t." | Session: ".$se."</h6>
        </div>
    </div>
    <div class=\"left\">
        <div id=\"mai\" style=\"margin-bottom: 10px;\">
            <input type=\"submit\" value=\"Save\" />
        </div>
    </div>
</div>                  
<div id=\"container\"> 
    <div id=\"rowth\">
        <div class=\"leftth\">Student ID</div>
        <div class=\"middleth\">Name</div>
        <div class=\"middleth\">CA1</div>
        <div class=\"middleth\">CA2</div>
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
            (($g < 45 && $g >= 40?"E":"F"))))));
}
echo ((isset($m))? $m :"");
 if($log->no_rec > 0){  
    for($i = 0; $i < $log->no_rec; $i++)
    {
        $rs = new login();
        $rs->database();
        $rs->set_sqlstr("select * from result WHERE Username='" . $log->data[0] . "' AND Class='". $c ."' AND Course='".$s."' AND Term='".$t."' AND Session='".$se."'");
        $rs->querydata();
        if($rs->no_rec > 0){
?>
        <div class="row">
           <div class="left"><?php echo $log->data[0]; ?></div>
           <div class="middle"><?php echo $log->data[1]; ?></div>
           <div class="middle"><?php echo (($act==1)?$rs->data['CA1']:"<input size=\"1\" type=\"text\" value=\"".$rs->data['CA1']."\" name=\"ca1[]\" id=\"ca1[]\" />");  ?></div>
           <div class="middle"><?php echo (($act==1)?$rs->data['CA2']:"<input size=\"1\" type=\"text\" value=\"".$rs->data['CA2']."\" name=\"ca2[]\" id=\"ca2[]\" />"); ?></div>
           <div class="middle"><?php echo (($act==1)?($ca = ($rs->data['CA1'] + $rs->data['CA2'])):$ca = ($rs->data['CA1'] + $rs->data['CA2'])); ?></div>
           <div class="middle"><?php echo (($act==1)?$rs->data['Exam']:"<input size=\"1\" type=\"text\" value=\"".$rs->data['Exam']."\" name=\"exam[]\" id=\"exam[]\" />
                                                            <input size=\"1\" type=\"hidden\" value=\"".$rs->data['ID']."\" name=\"id[]\" id=\"id[]\" />
                                                            <input size=\"1\" type=\"hidden\" value=\"".$log->data[0]."\" name=\"sid[]\" id=\"sid[]\" />"); ?></div>
           <div class="middle"><?php echo (($act==1)?($total = ($ca + $rs->data['Exam'])):$total = ($ca + $rs->data['Exam'])); ?></div>
           <div class="middle"><?php echo (($act==1)?Grade($total): Grade($total)); ?></div>
           <div class="right"></div>
        </div>
           
        <?php }
        else{
        ?>
        <div class="row">
            <div class="left"><?php echo $log->data[0]; ?></div>
            <div class="middle"><?php echo $log->data[1]; ?></div>
            <div class="middle"><?php echo (($act==1)?"0":"<input size=\"1\" type=\"text\" value=\"\" name=\"ca1[]\" id=\"ca1[]\" />");  ?></div>
            <div class="middle"><?php echo (($act==1)?"0":"<input size=\"1\" type=\"text\" value=\"\" name=\"ca2[]\" id=\"ca2[]\" />"); ?></div>
            <div class="middle"><?php echo (($act==1)?"0":$ca = ($rs->data['CA1'] + $rs->data['CA2'])); ?></div>
            <div class="middle"><?php echo (($act==1)?"0":"<input size=\"1\" type=\"text\" value=\"\" name=\"exam[]\" id=\"exam[]\" />
                                                            <input size=\"1\" type=\"hidden\" value=\"ins\" name=\"id[]\" id=\"id[]\" />
                                                            <input size=\"1\" type=\"hidden\" value=\"".$log->data[0]."\" name=\"sid[]\" id=\"sid[]\" />"); ?></div>
            <div class="middle"><?php echo (($act==1)?"0":$total = ($ca + $rs->data['Exam']));?></div>
            <div class="middle"><?php echo (($act==1)?"0":Grade($total)); ?></div>
            <div class="right"></div>
        </div>
       <?php  }
       
            $log->fetchdata();
       
        }
 }
     ?>
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