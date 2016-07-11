<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();

        
?> 
<div class="entry-content cf">	
	<div id="mai" style="margin-bottom: 10px;">
	
	<form action="" method="post" id="cs">
	<a class="link-button" href="" style="margin-bottom: 10px;" id="adds">Add Fee</a>	
		<select name="cla" id="cla">
			<option value="">Select Class</option>
			<?php 
			$log->set_sqlstr("SELECT * FROM class"); 
			$log->querydata();                        
			for($i=0; $i < $log->no_rec; $i++){
			   echo "<option value=\"".$log->data[0]."\">".$log->data[1]."</option>"; 
			   $log->fetchdata();
			}
			?> 
		</select>   		
	<img src="../img/loader.gif" id="loading-img" style="display:none;width:45px;height:45px;" alt="Please Wait"/>                     
	</form>
	
	</div><hr/>
</div> 
<table width="100%" cellpadding="10" cellspacing="0" id="det">
<tr>
    <th align="right">Fee Type</th><th align="left">Amount</th><th align="left">Class</th><th align="left">Term</th><th align="left">Session</th>
</tr>
<?php 
  
   function addcomma($amt){
       $l = strlen($amt);
       //$g = $l/3;
       $nstr = "";
       for($i = 0; $i < $l; $i++){
           $nstr .=  substr( $amt,$i, 1);
        if( ((($l-($i+1))%3) == 0) 
             && (($i+ 1) != $l) ){
            $nstr .= ", ";
        }
       }
       return $nstr; 
   }
   
   function getTyp($cl){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM schoolfeetype WHERE id='".$cl."'"); 
			$log->querydata();
			return $log->data[0];
		}
	 function getClass($cl){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM class WHERE id='".$cl."'"); 
			$log->querydata();
			return $log->data[0];
		}
	 function getTerm($cl){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM term WHERE id='".$cl."'"); 
			$log->querydata();
			return $log->data[0];
		}
	 function getSe($cl){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM session WHERE id='".$cl."'"); 
			$log->querydata();
			return $log->data[0];
		}
		
		
if(isset($_REQUEST['class'])){
	$cla = $_REQUEST['class'];
}
else $cla = 1;
 $log->set_sqlstr("SELECT * FROM schoolfees WHERE class=".$cla.""); 
        $log->querydata();

	if($log->no_rec > 0){
for($i=0; $i < $log->no_rec; $i++){
  
    ?>
 <tr >
    <td align="right"><?php echo getTyp($log->data[1]); ?> </td>
	<td>NGN <?php echo addcomma($log->data[2]); ?></td>
	<td ><?php echo getClass($log->data[3]); ?> </td>
	<td ><?php echo getTerm($log->data[5]); ?> </td>
	<td ><?php echo getSe($log->data[4]); ?> <a class="link-button" href="" style="margin-bottom: 10px;" id="adds">Add Fee</a>	</td>
</tr>
	<?php $log->fetchdata(); }}else{ ?>
<tr >
    <td colspan="3" align="center">No record found for this class</td>
</tr>
<?php } ?>
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
       $('#adds').click(function(e){
			$('#loading-img').css('display','inline');
			$("#content").load("../bin_admin/settings_edit.php"); 
			e.preventDefault();
			}); 
			
		 $('#cla').change(function(e){
			  $('#loading-img').css('display','inline');
			 var cl = $(this).val();
		   $("#content").load("../bin_admin/settings_show.php?class="+cl); 
		 e.preventDefault();
		});
			 
        
});
</script>
