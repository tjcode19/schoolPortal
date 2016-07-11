<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

if(isset($_REQUEST['a'])){
        $log->set_sqlstr("DELETE FROM auth_tab WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("DELETE FROM admission_details WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("DELETE FROM student_data WHERE Username = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();   
        
        $uploaddir = '../passport/student/';
        unlink($uploaddir.$_REQUEST['n'].".jpg");
        unlink($uploaddir."thumb_".$_REQUEST['n'].".jpg");
    }

$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$se = isset($_REQUEST['sid']) ? $_REQUEST['sid'] : "";
        $str_sql = ($se!="") ? "SELECT * FROM student_data ".
                                " WHERE Class LIKE '%".$se."%'" :
                                "select * from student_data WHERE Class='KG1' order by Username DESC limit $start,20";
$log->set_sqlstr($str_sql);
$log->querydata();
//$rsd = mysql_query($sql);
if($log->no_rec == 0)    $m = "<div id=\"rowth\">
    <div class=\"left\"></div>
        <div class=\"middle\"></div>
        <div class=\"middle\">Please Select Class to List Students</div>
        <div class=\"right\"></div>
    </div>"; 
?>
<div id="container">
    <div id="rowth">
        <div class="leftth"></div>
        <div class="middleth">Student ID</div>
        <div class="middleth">Name</div>
        <div class="rightth">
            
        </div>
    </div> 
<?php
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{?>
         
    <div class="row">
        <div class="left"><?php echo (($log->data['Passport1'] != "")?
                            "<img id=\"ss\" src=\"". $log->data['Passport1'] ."\" alt=\"". $log->data['Username'] ."\" />":
                            "<img id=\"ss\" src=\"../img/mono-icons/user32.png\" alt=\"". $log->data['Username'] ."\" />") ?>
        </div>
        <div class="middle"><?php echo $log->data['Username']; ?></div>
        <div class="middle"><?php echo $log->data['Surname']." ".$log->data['Firstname']." ".$log->data['Other']; ?></div>
        <div class="right">
          <a href="../bin_admin/v_class.php?n=<?php echo $log->data['Username']; ?>">
                        <img class="alignleft" alt="View" title="View Details" src="../img/mono-icons/paper32.png" />
                    </a>
              <a target="_blank" href="../ControlPanel/printpinsingle.php?n=<?php echo $log->data['Username']; ?>" class="link-button green">P</a>
            <a target="_blank" href="../ControlPanel/printpinsingle.php?n=<?php echo $log->data['Username']; ?>" class="link-button red">R</a>
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
        
         $('#container .row a').click(function(e){
             showLoader();
             var link = this.href;
               $("#content").load(link, hideLoader());
               $("#paging_button").hide();               
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