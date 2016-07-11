<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

 function getUser($po){
        $log = new login;	
        $log->database();
        $log->set_sqlstr("SELECT username FROM authentication WHERE id ='". $po."'"); 
        $log->querydata();
        return $log->data[0];
    }
    
if(isset($_REQUEST['a']) && $_REQUEST['a']=="pro"){
		$log->set_sqlstr("SELECT class FROM student_data WHERE id ='". $_REQUEST['n'] ."'"); 
		$log->querydata();
		$new_class = $log->data[0]-1;
	
        $log->set_sqlstr("UPDATE student_data SET class=".$new_class." WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
    }
else if(isset($_REQUEST['a']) && $_REQUEST['a']=="rep"){
		$log->set_sqlstr("SELECT class FROM student_data WHERE id ='". $_REQUEST['n'] ."'"); 
		$log->querydata();
		$new_class = $log->data[0]+1;
	
        $log->set_sqlstr("UPDATE student_data SET class=".$new_class." WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
    }

	

$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$se = isset($_REQUEST['sid']) ? $_REQUEST['sid'] : "";
        $str_sql = ($se!="") ? "SELECT * FROM student_data ".
                                " WHERE class LIKE '%".$se."%'" :
                                "select * from student_data WHERE class=0 order by id DESC limit $start,20";
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
        <div class="left"><?php echo (($log->data['passport'] != "")?
                            "<img id=\"ss\" src=\"". $log->data['passport'] ."\" alt=\"". getUser($log->data['id']) ."\" />":
                            "<img id=\"ss\" src=\"../img/mono-icons/user32.png\" alt=\"". $log->data['id'] ."\" />") ?>
        </div>
        <div class="middle"><?php echo getUser($log->data['id']); ?></div>
        <div class="middle"><?php echo $log->data['last_name']." ".$log->data['first_name']." ".$log->data['other_name']; ?></div>
        <div class="right">
			<a href="../bin_admin/v_class.php?n=<?php echo $log->data['id']; ?>">
				<img class="alignleft" alt="View" title="View Details" src="../img/mono-icons/paper32.png" />
			</a>
			<a href="../bin_admin/class_list.php?page=1&a=pro&n=<?php echo $log->data['id']; ?>" class="link-button green">P</a>
			<a href="../bin_admin/class_list.php?page=1&a=rep&n=<?php echo $log->data['id']; ?>" class="link-button red">R</a>
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