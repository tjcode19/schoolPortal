<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();

        
?> 

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
		
		
if(isset($_REQUEST['cl']) || isset($_REQUEST['tr']) || isset($_REQUEST['se'] )){
	$cla = $_REQUEST['cl'];
	$tr = $_REQUEST['tr'];
	$se = $_REQUEST['se'];
}
else{$cla = 1; $tr=1; $se=1;} 

	$sql = "SELECT * FROM schoolfees WHERE term=".$tr." AND session=".$se." AND class=".$cla."";
	$log->set_sqlstr($sql); 
    $log->querydata();

	if($log->no_rec > 0){
for($i=0; $i < $log->no_rec; $i++){
  
    ?>
 <tr >
    <td align="right"><?php echo getTyp($log->data[1]); ?> </td>
	<td>NGN <?php echo addcomma($log->data[2]); ?></td>
	<td ><?php echo getClass($log->data[3]); ?> </td>
	<td ><?php echo getTerm($log->data[5]); ?> </td>
	<td ><?php echo getSe($log->data[4]); ?> </td>
</tr>
	<?php $log->fetchdata(); }}else{ ?>
<tr >
    <td colspan="3" align="center">No record found for this class</td>
</tr>
<?php } ?>
</table>
<script type="text/javascript">
$(document).ready(function(){
	
      	 
        
});
</script>
