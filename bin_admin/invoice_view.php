<?php include '../includes/login.inc.php'; 
	$log = new login;
	$log->database();
	
	$sed = new login;
	$sed->database();

 
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
        
?> 

<table width="100%" cellpadding="10" cellspacing="0" id="det">
<?php 
 

 $log->set_sqlstr("SELECT * FROM feepayment WHERE student_id=".$cla.""); 
        $log->querydata();

    ?>
<tr >
    <td align="right">Student ID:</td>
	<td></td>
</tr>	
<tr >
    <td align="right">Student Name:</td>
	<td></td>
</tr>
<?php 
	$sed->set_sqlstr("SELECT * FROM feepayment WHERE student_id=".$cla.""); 
    $sed->querydata();
	
	for($i=0; $i < $sed->no_rec; $i++){
?>
<tr >
    <td align="right">School Fee:</td>
	<td> <?php echo $sed->data[0]; ?> </td>
</tr>
<?php $sed->fetchdata(); } ?>
<tr >
    <td align="right">Lesson Fee:</td>
	<td></td>
</tr>			
 <tr >
    <td align="right" colspan="2"> Pay</td>
</tr>
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
