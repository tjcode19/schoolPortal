<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

if(isset($_REQUEST['a'])){
        $log->set_sqlstr("DELETE FROM authentication WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();
        
        $log->set_sqlstr("DELETE FROM staff_data WHERE id = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();   
        
		/*
        $uploaddir = '../passport/staff/';
        unlink($uploaddir.$_REQUEST['n'].".jpg");
        unlink($uploaddir."thumb_".$_REQUEST['n'].".jpg");
		*/
    }
	
	function getStatus($st){
			if($st == 1){$status = "Inactive";}
			elseif($st == 2){$status = "Active";}
			elseif($st == 0){$status = "Raw";}
			elseif($st == 3){$status = "Locked";}
			return $status;
		}

$per_page = 20;
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;

$se = isset($_REQUEST['sid']) ? htmlspecialchars($_REQUEST['sid'],ENT_QUOTES) : "";
        $str_sql = ($se!="") ? "SELECT * FROM authentication INNER JOIN staff_data ON authentication.id=staff_data.id".
                                " WHERE staff_data.first_name LIKE '%".$se."%' OR staff_data.class_in_charge LIKE '%".$se.
                                "%' OR authentication.username LIKE '%".$se."%' OR staff_data.last_name LIKE '%".$se."%' OR staff_data.other_name LIKE '%".$se."%'" :
                                "select * from authentication INNER JOIN staff_data ON authentication.id=staff_data.id WHERE authentication.priority=2 order by authentication.id DESC limit $start,20";
$log->set_sqlstr($str_sql);
$log->querydata();
//$rsd = mysql_query($sql);
if($log->no_rec == 0)    $m = "<tr>
                                <td colspan=\"6\" align=\"center\">No Record Found</td>
                            </tr>"; 
?>
             <table width="100%" cellpadding="5" cellspacing="0" id="payrec">
                            
                            <tr>
                                <th></th><th>Staff ID</th><th>Name</th><th>Status</th><th>Last Login</th>
								<th width="20%"><img src="../img/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/></th>
                            </tr>
<?php
 echo ((isset($m))? $m :"");
for($i = 0; $i < $log->no_rec; $i++)
{?>
            	
           <tr align="center">
                <td>
                    <?php echo (($log->data['passport'] != "")?
                            "<img id=\"ss\" src=\"". $log->data['passport'] ."\" alt=\"". $log->data['username'] ."\" />":
                            "<img id=\"ss\" src=\"../img/mono-icons/user32.png\" alt=\"". $log->data['username'] ."\" />") ?>
                </td>
                <td><?php echo $log->data['username']; ?></td>
                <td><?php echo $log->data['last_name']." ".$log->data['first_name']; ?></td>
                <td><?php echo getStatus($log->data['status']); ?></td>
                <td><?php echo $log->data['last_login']; ?></td>
                <td>
                    <a href="../bin_admin/v_s_det.php?n=<?php echo $log->data['id']; ?>">
                        <img class="alignleft" alt="View" title="View Details" src="../img/mono-icons/paper32.png" />
                    </a>
                    <a href="../bin_admin/e_s_det.php?n=<?php echo $log->data['id']; ?>">
                        <img class="alignleft" alt="Edit" title="Edit Details" src="../img/mono-icons/paperpencil32.png" />
                    </a>
                    <a href="../bin_admin/staff_list.php?page=1&a=del&n=<?php echo $log->data['id']; ?>">
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
             $('#loading-img').css('display','block');
             var link = this.href; 
               $("#content").load(link, hideLoader());
               $("#paging_button").hide();               
               e.preventDefault();
	});
	  $('#payrec tr td a:nth-child(2)').click(function(e){
             $('#loading-img').css('display','block');
             var link = this.href; 
               $("#content").load(link);
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