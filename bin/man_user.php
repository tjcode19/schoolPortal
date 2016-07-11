<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

//$log->set_sqlstr("SELECT ID FROM news_tab WHERE Status = '1'");
//$log->querydata();

//$link = mysql_connect('localhost', 'root', '');
//mysql_select_db('satsms_db',$link);

$per_page = 10;
 //echo  'Username';
//$sqlc = "show columns from user_auth";
//$rsdc = mysql_query($sqlc);
//$cols = mysql_num_rows($rsdc);
$page = $_REQUEST['page'];

$start = ($page-1)*10;
$log->set_sqlstr("select * from user_auth INNER JOIN sms_acct ON user_auth.Username=sms_acct.Username order by ID limit $start,10");
$log->querydata();
//$rsd = mysql_query($sql);
?>
<table cellspacing="0" cellpadding="10" width="100%" border="0">
            <tr>
                <th>User</th><th>Password</th><th>SMS Balance</th><th></th>
            </tr>
<?php
for($i = 0; $i < $log->no_rec; $i++)
{?>
            	
            <tr  class="shopp">
                <td align="center"><?php echo $log->data['Username']; ?></td>
                <td align="center"><?php echo $log->data['Password']; ?></td>
                <td align="center"><?php echo $log->data['Credit']; ?></td>
                <td align="right">
                    <input type="button" onClick="setA('<?php echo $log->data['Username']; ?>');" value="View" />
                    <input type="button" onClick="setAU('<?php echo $log->data['Username'] ; ?>');" value="+ Units" />
                    <input type="button" onClick="setSU('<?php echo $log->data['Username'] ; ?>');" value="- Units" />
                </td>
            </tr>
         
	
	
<?php $log->fetchdata();
}?>
   </table>
<script type="text/javascript">
$(document).ready(function(){
	
	var Timer  = '';
	var selecter = 0;
	var Main =0;
	
	bring(selecter);
	
});

   //function setA(id){
     //alert(id);  
    //$.post( "../bin/v_user.php", { ids: id } )
   // .done(function( data ) { alert(data);
      //$('#content').fadeIn(3000).html(data);
   // });
    //var postData = $(this).serializeArray();
   
  // }
   
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