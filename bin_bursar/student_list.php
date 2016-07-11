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
		
		$fl = $uploaddir.$_REQUEST['n'].".jpg";
		if(file_exists($fl)){
			 unlink($uploaddir.$_REQUEST['n'].".jpg");
			unlink($uploaddir."thumb_".$_REQUEST['n'].".jpg");
		}
    }



$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$se = isset($_REQUEST['sid']) ? htmlspecialchars($_REQUEST['sid'],ENT_QUOTES) : "";
        $str_sql = ($se!="") ? "SELECT * FROM auth_tab INNER JOIN student_data ON auth_tab.Username=student_data.Username".
                                " WHERE student_data.Firstname LIKE '%".$se."%' OR student_data.Class LIKE '%".$se.
                                "%' OR student_data.Other LIKE '%".$se."%' OR student_data.Username LIKE '%".$se."%' OR student_data.Surname LIKE '%".$se."%'" :
                                "select * from auth_tab INNER JOIN student_data ON auth_tab.Username=student_data.Username WHERE auth_tab.Priority='student' order by auth_tab.IDD DESC limit $start,20";
$log->set_sqlstr($str_sql);
$log->querydata();
//$rsd = mysql_query($sql);
if($log->no_rec == 0)    $m = "<tr>
                                <td colspan=\"6\" align=\"center\">No Record Found</td>
                            </tr>"; 
?>
             <table width="100%" cellpadding="10" cellspacing="0" id="payrec">
                            
                            <tr>
                                <th></th><th>Student ID</th><th>Name</th><th>Status</th><th>Last Login</th><th width="20%"></th>
                            </tr>
<?php
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{?>
            	
           <tr align="center">
                <td>
                    <?php echo (($log->data['Passport1'] != "")?
                            "<img id=\"ss\" src=\"". $log->data['Passport1'] ."\" alt=\"". $log->data['Username'] ."\" />":
                            "<img id=\"ss\" src=\"../img/mono-icons/user32.png\" alt=\"". $log->data['Username'] ."\" />") ?>
                </td>
                <td><?php echo $log->data['Username']; ?></td>
                <td><?php echo $log->data['Surname']." ".$log->data['Firstname']." ".$log->data['Other']; ?></td>
                <td><?php echo $log->data['Status']; ?></td>
                <td>Monday</td>
                <td>
                    <a href="../bin_admin/v_st_det.php?n=<?php echo $log->data['Username']; ?>">
                        <img class="alignleft" alt="View" title="View Details" src="../img/mono-icons/paper32.png" />
                    </a>
                    <a href="../bin_admin/e_st_det.php?n=<?php echo $log->data['Username']; ?>">
                        <img class="alignleft" alt="Edit" title="Edit Details" src="../img/mono-icons/paperpencil32.png" />
                    </a>
                    <a href="../bin_admin/student_list.php?page=1&a=del&n=<?php echo $log->data['Username']; ?>">
                        <img class="alignleft" alt="Reset" title="Delete User" src="../img/mono-icons/stop32.png" />
                    </a>
                </td>
            </tr>     
	
<?php $log->fetchdata();
} ?>
   </table>
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
        
         $('#payrec tr td a:first-child').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());
               $("#paging_button").hide();               
               e.preventDefault();
	});
	  $('#payrec tr td a:nth-child(2)').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());
               $("#paging_button").hide();               
               e.preventDefault();
	});
	   $('#payrec tr td a:last-child').click(function(e){
             //showLoader();
            var r=confirm("Are you sure you want to delete?");
            if (r==true)
            { 
             var link = this.href;
             $("#content").load(link);
            }
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