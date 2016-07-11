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

 function getUser($po){
					$log = new login;	
					$log->database();
					$log->set_sqlstr("SELECT username FROM authentication WHERE id ='". $po."'"); 
					$log->querydata();
					return $log->data[0];
				}

$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$log->set_sqlstr("select class_in_charge FROM staff_data WHERE id='".$_SESSION['s_portal_id']."'");
$log->querydata();
$cla = $log->data[0];
//"SELECT * FROM behaviouralattitude INNER JOIN student_data ON behaviouralattitude.student_id=student_data.id WHERE student_data.class = '".$cla.
                               // "'order by behaviouralattitude.id DESC limit $start,20"

$log->set_sqlstr("SELECT * FROM student_data WHERE class = '".$cla."'order by id DESC limit $start,20");
$log->querydata();

if($log->no_rec == 0)    $m = "<div class=\"row\">
    <div class=\"left\"></div>
        <div class=\"middle\"></div>
        <div class=\"middle\">No Record Found</div>
        <div class=\"right\"></div>
    </div>"; 
?>
<div id="container">
    <div id="rowth">
        <div class="leftth"></div>
        <div class="middleth">Student ID</div>
        <div class="middleth">Name</div>
        <div class="rightth"></div>
    </div> 
<?php
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{?>
         
    <div class="row">
        <div class="left"><?php echo (($log->data['passport'] != "")?
                            "<img id=\"ss\" src=\"". $log->data['passport'] ."\" alt=\"". getUser($log->data['id']) ."\" />":
                            "<img id=\"ss\" src=\"../img/mono-icons/user32.png\" alt=\"". getUser($log->data['id']) ."\" />") ?>
        </div>
        <div class="middle"><?php echo getUser($log->data['id']); ?></div>
        <div class="middle"><?php echo $log->data['last_name']." ".$log->data['first_name']." ".$log->data['other_name']; ?></div>
        <div class="right">
            <a href="../bin_staff/status_v.php?n=<?php echo $log->data['id']; ?>&c=<?php echo $log->data['class']; ?>">
                <img class="alignleft" alt="View" title="View Details" src="../img/mono-icons/paper32.png" />
            </a>
            <a href="../bin_staff/status_u.php?n=<?php echo $log->data['id']; ?>&c=<?php echo $log->data['class']; ?>">
                <img class="alignleft" alt="Edit" title="Edit Details" src="../img/mono-icons/paperpencil32.png" />
            </a>
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